<?php

/**
 * 分类模型
 * 
 * 处理商品分类相关的数据操作，包括：
 * - 获取分类列表
 * - 获取单个分类详情
 * - 搜索分类
 */

namespace app\model;

class categorymodel extends \framework\model
{
    /**
     * 获取所有分类列表
     * 
     * 获取所有显示状态为开启的分类，按分类ID排序
     * 
     * @return array 分类列表
     */
    public function getCategoryList()
    {
        $sql = "SELECT * FROM category WHERE is_show=1 ORDER BY cat_id";
        return $this->db->fetchAll($sql);
    }

    /**
     * 获取单个分类详情
     * 
     * @param int $catId 分类ID
     * @return array|null 分类详情数组，不存在返回null
     */
    public function getCategoryDetail($catId)
    {
        $sql = "SELECT * FROM category WHERE cat_id=?";
        return $this->db->fetchRow($sql, [$catId]);
    }

    /**
     * 搜索分类
     * 
     * 根据关键词模糊搜索分类名称
     * 
     * @param string $keyword 搜索关键词
     * @return array|null 匹配的分类，不存在返回null
     */
    public function searchCategory($keyword)
    {
        $sql = "SELECT * FROM category WHERE cat_name LIKE ?";
        return $this->db->fetchRow($sql, ['%' . $keyword . '%']);
    }
}