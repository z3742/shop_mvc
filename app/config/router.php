<?php

/**
 * 路由配置
 *
 * 定义URL路径到控制器方法的映射关系
 */

return [
    // 首页和基础页面
    'index'        => 'home/index/index',
    'category'     => 'home/index/toCategory',
    'goods_list'   => 'home/index/toGoodsList',
    'goods_detail' => 'home/index/toGoodsDetail',
    'help'         => 'home/index/toHelp',
    'cart'         => 'home/index/toCart',

    // 用户相关
    'login'        => 'home/index/toLogin',
    'register'     => 'home/index/toRegister',
    'user'         => 'home/index/toUser',
    'search'       => 'home/index/search',
    'logout'       => 'home/index/logout',

    // 用户API
    'captcha'           => 'home/user/captcha',
    'user/login'        => 'home/user/doLogin',
    'user/register'     => 'home/user/doRegister',
    'user/add_goods'    => 'home/user/addGoods',
    'user/check_goods'  => 'home/user/checkGoods',
    'user/pending_list' => 'home/user/pendingList',
    'user/my_goods'     => 'home/user/myGoods',
    'user/address_list' => 'home/user/getAddressList',
    'user/add_address'  => 'home/user/addAddress',
    'user/edit_address' => 'home/user/editAddress',
    'user/delete_address' => 'home/user/deleteAddress',
    'user/order_list' => 'home/user/orderList',
    'user/order_list_by_status' => 'home/user/orderListByStatus',
    'user/order_detail' => 'home/user/orderDetail',
    'user/update_order_status' => 'home/user/updateOrderStatus',
    'user/admin_order_list' => 'home/user/adminOrderList',

    // 商品API
    'goods/hot'           => 'home/goods/getHotGoods',
    'goods/list'          => 'home/goods/getGoodsList',
    'goods/detail'        => 'home/goods/getGoodsDetail',
    'goods/search'        => 'home/goods/searchGoods',
    'goods/delete'        => 'home/goods/deleteGoods',
    'goods/flash_sale'    => 'home/goods/getFlashSales',
    'goods/hot_ranking'   => 'home/goods/getHotRanking',
    'goods/recent_viewed' => 'home/goods/getRecentlyViewed',
    'goods/add_view'      => 'home/goods/addView',
    'goods/related'       => 'home/goods/getRelated',

    // 分类API
    'category/list' => 'home/category/index',

    // 购物车API
    'cart/index'   => 'home/cart/index',
    'cart/add'     => 'home/cart/add',
    'cart/update'  => 'home/cart/update',
    'cart/delete'  => 'home/cart/delete',
    'cart/clear'   => 'home/cart/clear',
    'cart/count'   => 'home/cart/count',
    'cart/checkout' => 'home/cart/checkout',

    // 评价API
    'comment/add'    => 'home/comment/add',
    'comment/list'   => 'home/comment/list',
    'comment/rating' => 'home/comment/rating',
    'comment/delete' => 'home/comment/delete',

    // 收藏API
    'favorite/add'    => 'home/favorite/add',
    'favorite/remove' => 'home/favorite/remove',
    'favorite/list'   => 'home/favorite/list',
    'favorite/check'  => 'home/favorite/check',
    'favorite/count'  => 'home/favorite/count',
];
