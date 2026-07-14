<?php

/**
 * 限时秒杀模型
 * 
 * 处理秒杀活动相关的数据操作，包括：
 * - 获取进行中的秒杀活动
 * - 获取秒杀商品详情
 * - 更新秒杀库存
 */

namespace app\model;

class flashsalemodel extends \framework\model
{
    /**
     * 获取进行中的秒杀活动列表（关联商品信息）
     * 
     * @param int $limit 返回数量
     * @return array 秒杀活动列表
     */
    public function getActiveFlashSales($limit = 6)
    {
        $sql = "SELECT fs.*, g.goods_name, g.goods_img, g.goods_desc, g.cat_id
                FROM flash_sale fs
                INNER JOIN goods g ON fs.goods_id = g.goods_id
                WHERE fs.status = 1 
                  AND fs.start_time <= NOW() 
                  AND fs.end_time >= NOW()
                  AND g.is_sale = 1 
                  AND g.status = 1
                ORDER BY fs.sort_order ASC
                LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }

    /**
     * 获取单个秒杀活动详情
     * 
     * @param int $flashId 秒杀活动ID
     * @return array|null
     */
    public function getFlashSaleDetail($flashId)
    {
        $sql = "SELECT fs.*, g.goods_name, g.goods_img, g.goods_desc, g.cat_id, g.stock
                FROM flash_sale fs
                INNER JOIN goods g ON fs.goods_id = g.goods_id
                WHERE fs.flash_id = ? AND fs.status = 1";
        return $this->db->fetchRow($sql, [$flashId]);
    }

    /**
     * 获取秒杀活动的结束时间（用于倒计时）
     * 
     * @return string|null 最早结束的秒杀活动结束时间
     */
    public function getFlashSaleEndTime()
    {
        $sql = "SELECT MIN(end_time) as end_time FROM flash_sale 
                WHERE status = 1 AND start_time <= NOW() AND end_time >= NOW()";
        $result = $this->db->fetchRow($sql);
        return $result['end_time'] ?? null;
    }

    /**
     * 更新秒杀已售数量
     * 
     * @param int $flashId 秒杀活动ID
     * @param int $quantity 购买数量
     * @return int|false
     */
    public function updateSoldCount($flashId, $quantity)
    {
        $sql = "UPDATE flash_sale SET sold_count = sold_count + ? WHERE flash_id = ? AND sold_count + ? <= total_stock";
        return $this->db->execute($sql, [$quantity, $flashId, $quantity]);
    }
}
