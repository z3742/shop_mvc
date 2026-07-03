<?php

/**
 * 商品模型
 * 
 * 处理商品相关的数据操作，包括：
 * - 获取商品列表
 * - 获取热门商品
 * - 获取分类商品
 * - 获取商品详情
 * - 搜索商品
 * - 添加商品
 * - 审核商品
 * - 删除商品
 */

namespace app\model;

class goodsmodel extends \framework\model
{
    /**
     * 获取商品列表
     * 
     * 获取已上架且审核通过的商品，支持分页
     * 
     * @param int $limit 每页数量
     * @param int $offset 偏移量
     * @return array 商品列表
     */
    public function getGoodsList($limit = 10, $offset = 0)
    {
        // limit设置每页显示的结果集数量，offset表示从第几条结果集开始显示
        $sql = "SELECT * FROM goods WHERE is_sale=1 AND status=1 ORDER BY goods_id DESC LIMIT ? OFFSET ?";
        // 调用db类的fetchAll方法执行SQL查询，传入SQL语句和绑定参数
        return $this->db->fetchAll($sql, [$limit, $offset]);
    }

    /**
     * 获取热门商品
     * 
     * 获取已上架、审核通过且标记为热门的商品
     * 
     * @param int $limit 返回数量限制
     * @return array 热门商品列表
     */
    public function getHotGoods($limit = 6)
    {
        $sql = "SELECT * FROM goods WHERE is_sale=1 AND is_hot=1 AND status=1 ORDER BY goods_id DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }

    /**
     * 获取分类商品列表
     * 
     * 获取指定分类下已上架且审核通过的商品，支持分页
     * 
     * @param int $catId 分类ID
     * @param int $limit 每页数量
     * @param int $offset 偏移量
     * @return array 商品列表
     */
    public function getGoodsByCategory($catId, $limit = 10, $offset = 0)
    {
        $sql = "SELECT * FROM goods WHERE is_sale=1 AND cat_id=? AND status=1 ORDER BY goods_id DESC LIMIT ? OFFSET ?";
        return $this->db->fetchAll($sql, [$catId, $limit, $offset]);
    }

    /**
     * 获取商品详情
     * 
     * 获取单个已上架且审核通过的商品详情
     * 
     * @param int $goodsId 商品ID
     * @return array|null 商品详情，不存在返回null
     */
    public function getGoodsDetail($goodsId)
    {
        $sql = "SELECT * FROM goods WHERE goods_id=? AND is_sale=1 AND status=1";
        return $this->db->fetchRow($sql, [$goodsId]);
    }

    /**
     * 获取待审核商品详情
     * 
     * 获取单个待审核商品的详情（审核员专用）
     * 
     * @param int $goodsId 商品ID
     * @return array|null 商品详情，不存在返回null
     */
    public function getPendingGoodsDetail($goodsId)
    {
        $sql = "SELECT g.*, u.username FROM goods g 
                LEFT JOIN user u ON g.user_id = u.user_id 
                WHERE g.goods_id=? AND g.status=0";
        return $this->db->fetchRow($sql, [$goodsId]);
    }

    /**
     * 搜索商品
     * 
     * 根据关键词模糊搜索商品名称，支持分页
     * 
     * @param string $keyword 搜索关键词
     * @param int $limit 每页数量
     * @param int $offset 偏移量
     * @return array 匹配的商品列表
     */
    public function searchGoods($keyword, $limit = 10, $offset = 0)
    {
        // 通过获取搜索框的value,将搜索框的value传入sql语句中，以模糊访问的形式进行查询
        $sql = "SELECT * FROM goods WHERE is_sale=1 AND status=1 AND goods_name LIKE ? ORDER BY goods_id DESC LIMIT ? OFFSET ?";
        return $this->db->fetchAll($sql, ['%' . $keyword . '%', $limit, $offset]);
    }

    /**
     * 获取商品数量
     * 
     * 获取指定分类或全部已上架且审核通过的商品数量
     * 
     * @param int|null $catId 分类ID，为null时统计全部商品
     * @return int 商品数量
     */
    public function getGoodsCount($catId = null)
    {
        if ($catId) {
            $sql = "SELECT COUNT(*) as total FROM goods WHERE is_sale=1 AND status=1 AND cat_id=?";
            $result = $this->db->fetchRow($sql, [$catId]);
        } else {
            $sql = "SELECT COUNT(*) as total FROM goods WHERE is_sale=1 AND status=1";
            $result = $this->db->fetchRow($sql);
        }
        return $result['total'] ?? 0;
    }

    /**
     * 获取随机商品
     * 
     * 随机获取指定数量的已上架且审核通过的商品
     * 
     * @param int $limit 返回数量限制
     * @return array 随机商品列表
     */
    public function getRandomGoods($limit = 20)
    {
        $limit = intval($limit);
        $sql = "SELECT * FROM goods WHERE is_sale=1 AND status=1 ORDER BY RAND() LIMIT {$limit}";
        return $this->db->fetchAll($sql);
    }

    /**
     * 获取搜索商品数量
     * 
     * 根据关键词统计匹配的商品数量
     * 
     * @param string $keyword 搜索关键词
     * @return int 匹配的商品数量
     */
    public function searchGoodsCount($keyword)
    {
        $sql = "SELECT COUNT(*) as total FROM goods WHERE is_sale=1 AND status=1 AND goods_name LIKE ?";
        $result = $this->db->fetchRow($sql, ['%' . $keyword . '%']);
        return $result['total'] ?? 0;
    }

    /**
     * 添加商品
     * 
     * 用户提交商品审核申请，初始状态为待审核（status=0）
     * 
     * @param string $goodsName 商品名称
     * @param string $goodsImg 商品图片路径
     * @param float $goodsPrice 商品价格
     * @param int $stock 库存数量
     * @param string $goodsDesc 商品描述
     * @param int $catId 分类ID
     * @param int $userId 提交用户ID
     * @return int|false 插入成功返回商品ID，失败返回false
     */
    public function addGoods($goodsName, $goodsImg, $goodsPrice, $stock, $goodsDesc, $catId, $userId)
    {
        $sql = "INSERT INTO goods (goods_name, goods_img, goods_price, stock, goods_desc, cat_id, user_id, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
        return $this->db->execute($sql, [$goodsName, $goodsImg, $goodsPrice, $stock, $goodsDesc, $catId, $userId]);
    }

    /**
     * 审核商品
     * 
     * 管理员审核商品，更新商品状态和审核信息
     * 
     * @param int $goodsId 商品ID
     * @param int $status 审核状态（1通过，0待审核，其他为拒绝）
     * @param int $adminId 审核管理员ID
     * @return int|false 影响行数，失败返回false
     */
    public function auditGoods($goodsId, $status, $adminId)
    {
        $sql = "UPDATE goods SET status=?, audit_time=NOW(), audit_user_id=? WHERE goods_id=?";
        return $this->db->execute($sql, [$status, $adminId, $goodsId]);
    }

    /**
     * 获取待审核商品列表
     * 
     * 获取所有待审核状态的商品，关联用户信息
     * 
     * @return array 待审核商品列表
     */
    public function getPendingGoods()
    {
        $sql = "SELECT g.*, u.username FROM goods g LEFT JOIN user u ON g.user_id=u.user_id WHERE g.status=0 ORDER BY g.goods_id DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * 删除商品
     * 
     * 管理员删除商品
     * 
     * @param int $goodsId 商品ID
     * @return int|false 影响行数，失败返回false
     */
    public function deleteGoods($goodsId)
    {
        $sql = "DELETE FROM goods WHERE goods_id=?";
        return $this->db->execute($sql, [$goodsId]);
    }

    /**
     * 根据用户ID获取该用户提交的所有商品
     * 
     * @param int $userId 用户ID
     * @return array
     */
    public function getGoodsByUser($userId)
    {
        $sql = "SELECT g.*, c.name AS cat_name FROM goods g LEFT JOIN category c ON g.cat_id=c.cat_id WHERE g.user_id=? ORDER BY g.goods_id DESC";
        return $this->db->fetchAll($sql, [$userId]);
    }
}
