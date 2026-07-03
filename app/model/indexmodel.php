<?php

/**
 * 首页模型
 * 
 * 处理首页相关的数据操作，包括：
 * - 获取首页轮播图数据
 */

namespace app\model;

class indexmodel extends \framework\model
{
    /**
     * 获取首页轮播图数据
     * 
     * 获取所有显示状态为开启的轮播图，按排序字段升序排列
     * 
     * 注意：banner表已在 database/shop_db.sql 中定义并初始化数据
     * 
     * @return array 轮播图列表
     */
    public function getBannerList()
    {
        $sql = "SELECT * FROM banner WHERE is_show = 1 ORDER BY sort_order ASC";
        return $this->db->fetchAll($sql);
    }
}