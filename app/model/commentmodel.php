<?php

namespace app\model;

class commentmodel extends \framework\model
{
    public function addComment($goodsId, $userId, $orderId, $content, $rating)
    {
        $sql = "INSERT INTO goods_comment (goods_id, user_id, order_id, content, rating) VALUES (?, ?, ?, ?, ?)";
        return $this->db->execute($sql, [$goodsId, $userId, $orderId, $content, $rating]);
    }

    public function getCommentsByGoods($goodsId, $limit = 10, $offset = 0)
    {
        $sql = "SELECT c.*, u.username FROM goods_comment c LEFT JOIN user u ON c.user_id = u.user_id WHERE c.goods_id = ? ORDER BY c.create_time DESC LIMIT ? OFFSET ?";
        return $this->db->fetchAll($sql, [$goodsId, $limit, $offset]);
    }

    public function getCommentCount($goodsId)
    {
        $sql = "SELECT COUNT(*) as total FROM goods_comment WHERE goods_id = ?";
        $result = $this->db->fetchRow($sql, [$goodsId]);
        return $result['total'] ?? 0;
    }

    public function getGoodsRating($goodsId)
    {
        $sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM goods_comment WHERE goods_id = ?";
        return $this->db->fetchRow($sql, [$goodsId]);
    }

    public function hasCommented($goodsId, $userId)
    {
        $sql = "SELECT COUNT(*) as count FROM goods_comment WHERE goods_id = ? AND user_id = ?";
        $result = $this->db->fetchRow($sql, [$goodsId, $userId]);
        return $result['count'] > 0;
    }

    public function deleteComment($commentId)
    {
        $sql = "DELETE FROM goods_comment WHERE comment_id = ?";
        return $this->db->execute($sql, [$commentId]);
    }
}
