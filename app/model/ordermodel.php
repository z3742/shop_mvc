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
    public function createOrder($userId, $cartList, $totalAmount)
    {
        $orderSn = $this->generateOrderSn();

        $sql = "INSERT INTO `order` (order_sn, user_id, total_amount, status) VALUES (?, ?, ?, 0)";
        $result = $this->db->execute($sql, [$orderSn, $userId, $totalAmount]);

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
}