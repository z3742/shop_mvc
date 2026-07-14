<?php

/**
 * 订单模型
 * 
 * 处理订单相关的数据操作，包括：
 * - 创建订单
 * - 生成订单号
 */

namespace app\model;

class ordermodel extends \framework\model
{
    /**
     * 创建订单
     * 
     * 创建订单主记录并关联订单商品记录
     * 
     * @param int $userId 用户ID
     * @param array $cartList 购物车商品列表
     * @param float $totalAmount 订单总金额
     * @return int|false 订单ID，失败返回false
     */
    public function createOrder($userId, $cartList, $totalAmount, $addrId = 0)
    {
        $orderSn = $this->generateOrderSn();

        $consignee = '';
        $phone = '';
        $address = '';

        if ($addrId > 0) {
            $sql = "SELECT consignee, phone, province, city, district, detail_addr FROM user_address WHERE addr_id = ? AND user_id = ?";
            $addr = $this->db->fetchRow($sql, [$addrId, $userId]);
            if ($addr) {
                $consignee = $addr['consignee'];
                $phone = $addr['phone'];
                $address = ($addr['province'] ?: '') . ($addr['city'] ?: '') . ($addr['district'] ?: '') . ($addr['detail_addr'] ?: '');
            }
        }

        $sql = "INSERT INTO `order` (order_sn, user_id, total_amount, status, consignee, phone, address) VALUES (?, ?, ?, 0, ?, ?, ?)";
        $result = $this->db->execute($sql, [$orderSn, $userId, $totalAmount, $consignee, $phone, $address]);

        if ($result !== false){
            $orderId = $this->db->lastInsertId();

            foreach ($cartList as $item) {
                $sql = "INSERT INTO order_goods (order_id, goods_id, goods_name, goods_price, goods_num, goods_img) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $this->db->execute($sql, [
                    $orderId,
                    $item['goods_id'],
                    $item['goods_name'],
                    $item['goods_price'],
                    $item['goods_num'],
                    $item['goods_img']
                ]);
            }

            return $orderId;
        }

        return false;
    }

    /**
     * 生成订单号
     * 
     * 订单号格式：当前日期时间（YmdHis）+ 6位随机数
     * 
     * @return string 订单号
     */
    private function generateOrderSn()
    {
        return date('YmdHis') . rand(100000, 999999);
    }

    public function getOrderList($userId)
    {
        $sql = "SELECT o.*, u.username, a.consignee, a.phone, a.province, a.city, a.district, a.detail_addr 
                FROM `order` o 
                LEFT JOIN user u ON o.user_id = u.user_id 
                LEFT JOIN user_address a ON o.order_id = a.addr_id
                WHERE o.user_id = ? 
                ORDER BY o.order_id DESC";
        return $this->db->fetchAll($sql, [$userId]);
    }

    public function getOrderByStatus($userId, $status)
    {
        $sql = "SELECT o.*, u.username 
                FROM `order` o 
                LEFT JOIN user u ON o.user_id = u.user_id 
                WHERE o.user_id = ? AND o.status = ? 
                ORDER BY o.order_id DESC";
        return $this->db->fetchAll($sql, [$userId, $status]);
    }

    public function getOrderDetail($orderId)
    {
        $sql = "SELECT o.*, u.username, a.consignee, a.phone, a.province, a.city, a.district, a.detail_addr 
                FROM `order` o 
                LEFT JOIN user u ON o.user_id = u.user_id 
                LEFT JOIN user_address a ON o.user_id = a.user_id
                WHERE o.order_id = ?";
        return $this->db->fetchRow($sql, [$orderId]);
    }

    public function getOrderGoods($orderId)
    {
        $sql = "SELECT * FROM order_goods WHERE order_id = ?";
        return $this->db->fetchAll($sql, [$orderId]);
    }

    public function updateOrderStatus($orderId, $status)
    {
        $sql = "UPDATE `order` SET status = ? WHERE order_id = ?";
        return $this->db->execute($sql, [$status, $orderId]);
    }

    public function getOrderCountByStatus($userId, $status)
    {
        $sql = "SELECT COUNT(*) as total FROM `order` WHERE user_id = ? AND status = ?";
        $result = $this->db->fetchRow($sql, [$userId, $status]);
        return $result ? $result['total'] : 0;
    }

    public function getAllOrders($status = -1)
    {
        if ($status >= 0) {
            $sql = "SELECT o.*, u.username FROM `order` o LEFT JOIN user u ON o.user_id = u.user_id WHERE o.status = ? ORDER BY o.order_id DESC";
            return $this->db->fetchAll($sql, [$status]);
        } else {
            $sql = "SELECT o.*, u.username FROM `order` o LEFT JOIN user u ON o.user_id = u.user_id ORDER BY o.order_id DESC";
            return $this->db->fetchAll($sql);
        }
    }
}