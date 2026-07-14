<?php

/**
 * 首页控制器
 * 
 * 负责处理商城首页、商品列表、商品详情、购物车、用户登录注册等页面展示
 */

namespace app\http\home;

use app\model\goodsmodel;
use app\model\categorymodel;
use app\model\cartmodel;
use app\model\indexmodel;
use app\model\usermodel;
use app\model\flashsalemodel;
use app\model\recentlyviewedmodel;

class indexcontroller
{
    /** @var goodsmodel 商品模型 */
    private $goodsModel;

    /** @var categorymodel 分类模型 */
    private $categoryModel;

    /** @var cartmodel 购物车模型 */
    private $cartModel;

    /** @var indexmodel 首页模型 */
    private $indexModel;

    /** @var flashsalemodel 秒杀模型 */
    private $flashSaleModel;

    /** @var recentlyviewedmodel 最近浏览模型 */
    private $recentlyViewedModel;



    public function __construct()
    {
        $this->goodsModel = new goodsmodel();
        $this->categoryModel = new categorymodel();
        $this->cartModel = new cartmodel();
        $this->indexModel = new indexmodel();
        $this->flashSaleModel = new flashsalemodel();
        $this->recentlyViewedModel = new recentlyviewedmodel();
    }

    /**
     * 首页
     */
    public function index()
    {
        $goodsConfig = $GLOBALS['config']['goods'] ?? [];
        $categoryList = $this->categoryModel->getCategoryList();
        $bannerList = $this->indexModel->getBannerList();
        $randomGoods = $this->goodsModel->getRandomGoods($goodsConfig['random_count'] ?? 20);
        $hotGoods = $this->goodsModel->getHotGoods($goodsConfig['hot_count'] ?? 8);
        $flashSales = $this->flashSaleModel->getActiveFlashSales(6);
        $flashEndTime = $this->flashSaleModel->getFlashSaleEndTime();
        $hotRanking = $this->goodsModel->getGoodsBySales(5);
        $cartCount = isset($_SESSION['user_id'])
            ? $this->cartModel->getCartCount($_SESSION['user_id'])
            : 0;

        // 获取最近浏览记录
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $recentlyViewed = $this->recentlyViewedModel->getRecentlyViewed($userId, $sessionId, 12);

        require VIEW_PATH . 'index.php';
    }

    /**
     * 商品分类页面
     */
    public function toCategory()
    {
        $categoryList = $this->categoryModel->getCategoryList();
        require VIEW_PATH . 'category.php';
    }

    /**
     * 商品列表页面（支持排序和价格筛选）
     */
    public function toGoodsList()
    {
        $catId = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
        $minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : null;
        $maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : null;
        $pageSize = $GLOBALS['config']['goods']['page_size'] ?? 12;
        $offset = ($page - 1) * $pageSize;

        // 使用排序查询
        $goodsList = $this->goodsModel->getGoodsSorted($sort, $catId, $minPrice, $maxPrice, $pageSize, $offset);
        $total = $this->goodsModel->getGoodsSortedCount($catId, $minPrice, $maxPrice);

        if ($catId > 0) {
            $category = $this->categoryModel->getCategoryDetail($catId);
        } else {
            $category = ['cat_name' => '全部商品'];
        }

        $totalPages = ceil($total / $pageSize);
        $categoryList = $this->categoryModel->getCategoryList();

        require VIEW_PATH . 'goods_list.php';
    }

    /**
     * 商品详情页面（含最近浏览记录和相关推荐）
     */
    public function toGoodsDetail()
    {
        $goodsId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $goods = $this->goodsModel->getGoodsDetail($goodsId);

        if (!$goods) {
            echo '商品不存在';
            return;
        }

        $category = $this->categoryModel->getCategoryDetail($goods['cat_id']);
        $categoryList = $this->categoryModel->getCategoryList();

        // 记录最近浏览
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $this->recentlyViewedModel->addView($goodsId, $userId, $sessionId);

        // 获取相关推荐商品
        $relatedGoods = $this->goodsModel->getRelatedGoods($goods['cat_id'], $goodsId, 4);

        // 获取最近浏览记录
        $recentlyViewed = $this->recentlyViewedModel->getRecentlyViewed($userId, $sessionId, 6);

        require VIEW_PATH . 'goods_detail.php';
    }

    /**
     * 帮助中心页面
     */
    public function toHelp()
    {
        require VIEW_PATH . 'help.php';
    }

    /**
     * 购物车页面
     */
    public function toCart()
    {
        $cartList = [];
        $cartTotal = 0;
        $cartCount = 0;

        if (isset($_SESSION['user_id'])) {
            $cartList = $this->cartModel->getCartList($_SESSION['user_id']);
            $cartTotal = $this->cartModel->getCartTotal($_SESSION['user_id']);
            $cartCount = $this->cartModel->getCartCount($_SESSION['user_id']);
        }

        require VIEW_PATH . 'cart.php';
    }

    /**
     * 登录页面
     */
    public function toLogin()
    {
        require VIEW_PATH . 'login.php';
    }

    /**
     * 注册页面
     */
    public function toRegister()
    {
        require VIEW_PATH . 'register.php';
    }

    /**
     * 用户中心页面
     */
    public function toUser()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . APP_BASE . '/index/login');
            return;
        }

        $userModel = new usermodel();
        $userInfo = $userModel->getUserInfo($_SESSION['user_id']);

        require VIEW_PATH . 'user.php';
    }

    /**
     * 商品搜索
     */
    public function search()
    {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = $GLOBALS['config']['goods']['page_size'] ?? 12;
        $offset = ($page - 1) * $pageSize;

        if ($keyword) {
            $goodsNameTotal = $this->goodsModel->searchGoodsCount($keyword);
            if ($goodsNameTotal > 0) {
                $goodsList = $this->goodsModel->searchGoods($keyword, $pageSize, $offset);
                $total = $goodsNameTotal;
                $searchType = 'goods';
                $searchResult = $keyword;
            } else {
                $matchedCat = $this->categoryModel->searchCategory($keyword);
                if ($matchedCat) {
                    $goodsList = $this->goodsModel->getGoodsByCategory($matchedCat['cat_id'], $pageSize, $offset);
                    $total = $this->goodsModel->getGoodsCount($matchedCat['cat_id']);
                    $searchType = 'category';
                    $searchResult = $matchedCat['cat_name'];
                } else {
                    $goodsList = [];
                    $total = 0;
                    $searchType = '';
                    $searchResult = $keyword;
                }
            }
        } else {
            $goodsList = $this->goodsModel->getGoodsList($pageSize, $offset);
            $total = $this->goodsModel->getGoodsCount();
            $searchType = '';
            $searchResult = '';
        }

        $totalPages = ceil($total / $pageSize);
        $categoryList = $this->categoryModel->getCategoryList();

        require VIEW_PATH . 'goods_list.php';
    }

    /**
     * 用户登出
     */
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        session_destroy();
        header('Location: ' . APP_BASE . '/index/index');
    }
}
