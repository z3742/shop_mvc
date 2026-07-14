<?php

namespace app\model;

class favoriteModel extends \framework\model
{
    public function addFavorite($userId, $goodsId)
    {
        $sql = "INSERT INTO goods_favorite (user_id, goods_id) VALUES (?, ?)";
        return $this->db->execute($sql, [$userId, $goodsId]);
    }

    public function removeFavorite($userId, $goodsId)
    {
        $sql = "DELETE FROM goods_favorite WHERE user_id = ? AND goods_id = ?";
        return $this->db->execute($sql, [$userId, $goodsId]);
    }

    public function isFavorite($userId, $goodsId)
    {
        $sql = "SELECT COUNT(*) as count FROM goods_favorite WHERE user_id = ? AND goods_id = ?";
        $result = $this->db->fetchRow($sql, [$userId, $goodsId]);
        return $result['count'] > 0;
    }

    public function getFavoriteList($userId, $limit = 10, $offset = 0)
    {
        $sql = "SELECT f.*, g.goods_name, g.goods_price, g.goods_img FROM goods_favorite f LEFT JOIN goods g ON f.goods_id = g.goods_id WHERE f.user_id = ? AND g.status = 1 ORDER BY f.create_time DESC LIMIT ? OFFSET ?";
        return $this->db->fetchAll($sql, [$userId, $limit, $offset]);
    }

    public function getFavoriteCount($userId)
    {
        $sql = "SELECT COUNT(*) as total FROM goods_favorite WHERE user_id = ?";
        $result = $this->db->fetchRow($sql, [$userId]);
        return $result['total'] ?? 0;
    }

    public function deleteFavorite($favoriteId)
    {
        $sql = "DELETE FROM goods_favorite WHERE favorite_id = ?";
        return $this->db->execute($sql, [$favoriteId]);
    }
}
