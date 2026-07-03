<?php

/**
 * 购物车模型
 * 
 * 处理购物车相关的数据操作，包括：
 * - 获取购物车列表
 * - 添加商品到购物车
 * - 更新购物车商品数量
 * - 删除购物车商品
 * - 清空购物车
 * - 获取购物车商品数量
 * - 计算购物车总价
 */

namespace app\model;

class cartmodel extends \framework\model
{
    /**
     * 获取用户购物车列表
     * 
     * 获取指定用户的购物车列表，关联商品信息
     * 
     * @param int $userId 用户ID
     * @return array 购物车列表
     */
    public function getCartList($userId)
    {
        $sql = "SELECT c.*, g.goods_name, g.goods_price, g.goods_img, g.stock 
                FROM cart c 
                LEFT JOIN goods g ON c.goods_id = g.goods_id 
                WHERE c.user_id=?";
        return $this->db->fetchAll($sql, [$userId]);
    }

    /**
     * 添加商品到购物车
     * 
     * 如果商品已存在则增加数量，否则新增记录
     * 
     * @param int $userId 用户ID
     * @param int $goodsId 商品ID
     * @param int $num 数量（默认1）
     * @return int|false 成功返回影响行数，失败返回false
     */
    public function addToCart($userId, $goodsId, $num = 1)
    {
        $sql = "SELECT cart_id, goods_num FROM cart WHERE user_id=? AND goods_id=?";
        $exist = $this->db->fetchRow($sql, [$userId, $goodsId]);

        if ($exist) {
            $newNum = $exist['goods_num'] + $num;
            $sql = "UPDATE cart SET goods_num=? WHERE cart_id=?";
            return $this->db->execute($sql, [$newNum, $exist['cart_id']]);
        } else {
            $sql = "INSERT INTO cart (user_id, goods_id, goods_num) VALUES (?, ?, ?)";
            return $this->db->execute($sql, [$userId, $goodsId, $num]);
        }
    }

    /**
     * 更新购物车商品数量
     * 
     * @param int $cartId 购物车记录ID
     * @param int $num 新数量
     * @param int $userId 用户ID（用于验证权限）
     * @return int|false 成功返回影响行数，失败返回false
     */
    public function updateCartNum($cartId, $num, $userId)
    {
        $sql = "UPDATE cart SET goods_num=? WHERE cart_id=? AND user_id=?";
        return $this->db->execute($sql, [$num, $cartId, $userId]);
    }

    /**
     * 删除购物车商品
     * 
     * @param int $cartId 购物车记录ID
     * @param int $userId 用户ID（用于验证权限）
     * @return int|false 成功返回影响行数，失败返回false
     */
    public function deleteCart($cartId, $userId)
    {
        $sql = "DELETE FROM cart WHERE cart_id=? AND user_id=?";
        return $this->db->execute($sql, [$cartId, $userId]);
    }

    /**
     * 清空用户购物车
     * 
     * 删除指定用户的所有购物车记录
     * 
     * @param int $userId 用户ID
     * @return int|false 成功返回影响行数，失败返回false
     */
    public function clearCart($userId)
    {
        $sql = "DELETE FROM cart WHERE user_id=?";
        return $this->db->execute($sql, [$userId]);
    }

    /**
     * 获取购物车商品总数
     * 
     * 统计购物车中所有商品的数量之和
     * 
     * @param int $userId 用户ID
     * @return int 商品总数
     */
    public function getCartCount($userId)
    {
        $sql = "SELECT SUM(goods_num) as total FROM cart WHERE user_id=?";
        $result = $this->db->fetchRow($sql, [$userId]);
        return $result['total'] ?? 0;
    }

    /**
     * 计算购物车总价
     * 
     * 计算购物车中所有商品的价格总和
     * 
     * @param int $userId 用户ID
     * @return float 总价
     */
    public function getCartTotal($userId)
    {
        $sql = "SELECT SUM(c.goods_num * g.goods_price) as total 
                FROM cart c 
                LEFT JOIN goods g ON c.goods_id = g.goods_id 
                WHERE c.user_id=?";
        $result = $this->db->fetchRow($sql, [$userId]);
        if (!$result) {
            return 0;
        }
        return (float)($result['total'] ?? 0);
    }
}
