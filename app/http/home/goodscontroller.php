<?php

/**
 * 商品控制器
 * 
 * 处理商品相关的业务逻辑，包括：
 * - 商品列表展示
 * - 商品详情展示
 * - 热门商品获取
 * - 商品搜索
 * - 商品删除（管理员）
 */

namespace app\http\home;

use app\model\goodsmodel;
use app\model\categorymodel;

class goodscontroller
{
    /** @var goodsmodel 商品模型实例 */
    private $goodsModel;

    /** @var categorymodel 分类模型实例 */
    private $categoryModel;

    /**
     * 构造函数 - 初始化商品模型和分类模型
     */
    public function __construct()
    {
        $this->goodsModel = new goodsmodel();
        $this->categoryModel = new categorymodel();
    }

    /**
     * 显示商品列表页面
     */
    public function index()
    {
        $this->showGoodsList();
    }

    /**
     * 显示商品列表页面
     * 
     * 根据分类ID筛选商品，支持分页
     */
    public function showGoodsList()
    {
        $catId = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = 12;
        $offset = ($page - 1) * $pageSize;

        if ($catId > 0) {
            $goodsList = $this->goodsModel->getGoodsByCategory($catId, $pageSize, $offset);
            $total = $this->goodsModel->getGoodsCount($catId);
            $category = $this->categoryModel->getCategoryDetail($catId);
        } else {
            $goodsList = $this->goodsModel->getGoodsList($pageSize, $offset);
            $total = $this->goodsModel->getGoodsCount();
            $category = ['cat_name' => '全部商品'];
        }

        $totalPages = ceil($total / $pageSize);
        $categoryList = $this->categoryModel->getCategoryList();

        require VIEW_PATH . 'goods_list.php';
    }

    /**
     * 显示商品详情页面
     * 
     * 根据商品ID获取商品详情
     */
    public function detail()
    {
        $goodsId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $goods = $this->goodsModel->getGoodsDetail($goodsId);

        if (!$goods) {
            echo '商品不存在';
            return;
        }

        $category = $this->categoryModel->getCategoryDetail($goods['cat_id']);
        $categoryList = $this->categoryModel->getCategoryList();

        require VIEW_PATH . 'goods_detail.php';
    }

    /**
     * 获取热门商品列表
     * 
     * @return void 返回JSON响应
     */
    public function getHotGoods()
    {
        $goodsConfig = $GLOBALS['config']['goods'] ?? [];
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : ($goodsConfig['hot_goods_limit'] ?? 6);
        $goods = $this->goodsModel->getHotGoods($limit);
        $this->jsonReturn(['code' => 200, 'data' => $goods]);
    }

    /**
     * 获取商品列表（API接口）
     * 
     * 支持按分类筛选和分页
     * 
     * @return void 返回JSON响应
     */
    public function getGoodsList()
    {
        $goodsConfig = $GLOBALS['config']['goods'] ?? [];
        $catId = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = isset($_GET['page_size']) ? intval($_GET['page_size']) : ($goodsConfig['page_size'] ?? 12);
        $offset = ($page - 1) * $pageSize;

        $goodsModel = $this->goodsModel;
        if ($catId > 0) {
            $goods = $goodsModel->getGoodsByCategory($catId, $pageSize, $offset);
            $total = $goodsModel->getGoodsCount($catId);
        } else {
            $goods = $goodsModel->getGoodsList($pageSize, $offset);
            $total = $goodsModel->getGoodsCount();
        }

        $this->jsonReturn(['code' => 200, 'data' => $goods, 'total' => $total, 'page' => $page, 'page_size' => $pageSize]);
    }

    /**
     * 获取商品详情（API接口）
     * 
     * @return void 返回JSON响应
     */
    public function getGoodsDetail()
    {
        $goodsId = isset($_GET['id']) ? intval($_GET['id']) : (isset($_GET['goods_id']) ? intval($_GET['goods_id']) : 0);
        if (!$goodsId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $goods = $this->goodsModel->getGoodsDetail($goodsId);

        if (!$goods) {
            $goods = $this->goodsModel->getPendingGoodsDetail($goodsId);
        }

        if ($goods) {
            $category = $this->categoryModel->getCategoryDetail($goods['cat_id']);
            $goods['cat_name'] = $category['cat_name'] ?? '';
            $this->jsonReturn(['code' => 200, 'data' => $goods]);
        } else {
            $this->jsonReturn(['code' => 404, 'msg' => '商品不存在']);
        }
    }

    /**
     * 搜索商品
     * 
     * 根据关键词搜索商品，支持分页
     * 
     * @return void 返回JSON响应
     */
    public function searchGoods()
    {
        $goodsConfig = $GLOBALS['config']['goods'] ?? [];
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = isset($_GET['page_size']) ? intval($_GET['page_size']) : ($goodsConfig['page_size'] ?? 12);
        $offset = ($page - 1) * $pageSize;

        $goodsModel = $this->goodsModel;
        $goods = $keyword
            ? $goodsModel->searchGoods($keyword, $pageSize, $offset)
            : $goodsModel->getGoodsList($pageSize, $offset);

        $this->jsonReturn(['code' => 200, 'data' => $goods]);
    }

    /**
     * 删除商品（管理员）
     * 
     * 管理员有权限删除商品
     * 
     * @return void 返回JSON响应
     */
    public function deleteGoods()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
            $this->jsonReturn(['code' => 403, 'msg' => '权限不足']);
            return;
        }

        $goodsId = isset($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;
        if (!$goodsId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $result = $this->goodsModel->deleteGoods($goodsId);
        if ($result !== false) {
            $this->jsonReturn(['code' => 200, 'msg' => '删除成功']);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '删除失败']);
        }
    }

    /**
     * 返回JSON响应
     * 
     * @param array $data 要返回的数据
     */
    private function jsonReturn($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
