<?php

/**
 * 最近浏览记录模型
 * 
 * 处理用户浏览商品记录的数据操作，包括：
 * - 记录用户浏览商品
 * - 获取最近浏览记录
 */

namespace app\model;

class recentlyviewedmodel extends \framework\model
{
    /**
     * 记录用户浏览商品
     * 
     * 如果同一用户/会话已浏览过该商品，则更新浏览时间；
     * 否则插入新记录。每个用户/会话最多保留20条记录。
     * 
     * @param int $goodsId 商品ID
     * @param int|null $userId 用户ID
     * @param string|null $sessionId 会话ID
     * @return void
     */
    public function addView($goodsId, $userId = null, $sessionId = null)
    {
        // 检查是否已有记录
        if ($userId) {
            $sql = "SELECT view_id FROM recently_viewed WHERE user_id = ? AND goods_id = ?";
            $existing = $this->db->fetchRow($sql, [$userId, $goodsId]);
        } else {
            $sql = "SELECT view_id FROM recently_viewed WHERE session_id = ? AND goods_id = ?";
            $existing = $this->db->fetchRow($sql, [$sessionId, $goodsId]);
        }

        if ($existing) {
            // 更新浏览时间
            $sql = "UPDATE recently_viewed SET view_time = NOW() WHERE view_id = ?";
            $this->db->execute($sql, [$existing['view_id']]);
        } else {
            // 插入新记录
            $sql = "INSERT INTO recently_viewed (user_id, session_id, goods_id, view_time) VALUES (?, ?, ?, NOW())";
            $this->db->execute($sql, [$userId, $sessionId, $goodsId]);

            // 清理旧记录，保留最近20条
            if ($userId) {
                $sql = "DELETE FROM recently_viewed WHERE user_id = ? AND view_id NOT IN (
                    SELECT view_id FROM (
                        SELECT view_id FROM recently_viewed WHERE user_id = ? ORDER BY view_time DESC LIMIT 20
                    ) AS t
                )";
            } else {
                $sql = "DELETE FROM recently_viewed WHERE session_id = ? AND view_id NOT IN (
                    SELECT view_id FROM (
                        SELECT view_id FROM recently_viewed WHERE session_id = ? ORDER BY view_time DESC LIMIT 20
                    ) AS t
                )";
            }
            $this->db->execute($sql, [$userId ?: $sessionId, $userId ?: $sessionId]);
        }
    }

    /**
     * 获取最近浏览的商品列表
     * 
     * @param int|null $userId 用户ID
     * @param string|null $sessionId 会话ID
     * @param int $limit 返回数量
     * @return array 浏览记录列表
     */
    public function getRecentlyViewed($userId = null, $sessionId = null, $limit = 12)
    {
        if ($userId) {
            $sql = "SELECT rv.view_time, g.goods_id, g.goods_name, g.goods_img, g.goods_price, g.is_hot
                    FROM recently_viewed rv
                    INNER JOIN goods g ON rv.goods_id = g.goods_id
                    WHERE rv.user_id = ? AND g.is_sale = 1 AND g.status = 1
                    ORDER BY rv.view_time DESC
                    LIMIT ?";
            return $this->db->fetchAll($sql, [$userId, $limit]);
        } else {
            $sql = "SELECT rv.view_time, g.goods_id, g.goods_name, g.goods_img, g.goods_price, g.is_hot
                    FROM recently_viewed rv
                    INNER JOIN goods g ON rv.goods_id = g.goods_id
                    WHERE rv.session_id = ? AND g.is_sale = 1 AND g.status = 1
                    ORDER BY rv.view_time DESC
                    LIMIT ?";
            return $this->db->fetchAll($sql, [$sessionId, $limit]);
        }
    }
}
