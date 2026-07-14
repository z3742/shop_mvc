<?php
// 确保变量有默认值，避免Undefined variable错误
$categoryList = isset($categoryList) ? $categoryList : [];
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>全部分类 - 热卖商城</title>
    <link rel="stylesheet" href="<?php echo APP_BASE ?>/resources/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo APP_BASE ?>/resources/css/bootstrap-custom.css">
</head>

<body>
    <div class="loader">
        <div class="loader-circle"></div>
        <p>页面加载中...</p>
    </div>

    <div class="top-bar">
        <div class="top-bar-inner">
            <div class="fl">欢迎来到热卖商城！正品保障 | 全国包邮 | 售后无忧</div>
            <div class="fr">
                <?php if (isset($_SESSION['username'])): ?>
                    <span>欢迎<?= htmlspecialchars($_SESSION['username']) ?></span>
                    <a href="<?php echo APP_BASE ?>/index/logout">退出</a>
                <?php else: ?>
                    <a href="<?php echo APP_BASE ?>/index/login">请登录</a>
                    <a href="<?php echo APP_BASE ?>/index/register">免费注册</a>
                <?php endif; ?>
                <a href="<?php echo APP_BASE ?>/index/user">个人中心</a>
                <a href="<?php echo APP_BASE ?>/index/cart">购物车(<span class="cart-count">0</span>)</a>
                <a href="<?php echo APP_BASE ?>/index/help">帮助中心</a>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="header-inner">
            <div class="logo">
                <div class="logo-icon"></div>
                <span class="logo-text">热卖商城</span>
            </div>
            <form class="search-box" action="<?php echo APP_BASE ?>/index/search" method="get">
                <input type="text" class="search-input" name="keyword" placeholder="搜索商品或分类">
                <button type="submit" class="search-btn"><i class="bi bi-search me-1"></i>搜索</button>
            </form>
            <div class="head-cart" id="head-cart" data-bs-toggle="tooltip" data-bs-placement="bottom" title="点击查看购物车"><i class="bi bi-cart3 me-1"></i>购物车<span class="cart-num" id="cart-num">0</span></div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg bs-navbar sticky-top">
        <div class="container-fluid" style="max-width:1600px;">
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav" aria-controls="mobileNav">
                <i class="bi bi-list fs-4" style="color:var(--text-primary);"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav gap-1">
                    <li class="nav-item"><a class="nav-link" href="<?php echo APP_BASE ?>/index/index"><i class="bi bi-house-door me-1"></i>首页</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?php echo APP_BASE ?>/index/category"><i class="bi bi-grid me-1"></i>全部分类</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo APP_BASE ?>/index/goods_list"><i class="bi bi-stars me-1"></i>精选商品</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo APP_BASE ?>/index/cart"><i class="bi bi-cart3 me-1"></i>购物车</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo APP_BASE ?>/index/user"><i class="bi bi-person me-1"></i>个人中心</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo APP_BASE ?>/index/help"><i class="bi bi-question-circle me-1"></i>帮助中心</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="offcanvas offcanvas-start bs-offcanvas" tabindex="-1" id="mobileNav">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"><i class="bi bi-list me-2"></i>导航菜单</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group bs-list-group">
                <a href="<?php echo APP_BASE ?>/index/index" class="list-group-item"><i class="bi bi-house-door me-2"></i>首页</a>
                <a href="<?php echo APP_BASE ?>/index/category" class="list-group-item active"><i class="bi bi-grid me-2"></i>全部分类</a>
                <a href="<?php echo APP_BASE ?>/index/goods_list" class="list-group-item"><i class="bi bi-stars me-2"></i>精选商品</a>
                <a href="<?php echo APP_BASE ?>/index/cart" class="list-group-item"><i class="bi bi-cart3 me-2"></i>购物车</a>
                <a href="<?php echo APP_BASE ?>/index/user" class="list-group-item"><i class="bi bi-person me-2"></i>个人中心</a>
                <a href="<?php echo APP_BASE ?>/index/help" class="list-group-item"><i class="bi bi-question-circle me-2"></i>帮助中心</a>
            </div>
        </div>
    </div>

    <div class="main-layout main-content">
        <div class="sidebar-left">
            <h3 class="sidebar-title"><i class="bi bi-folder2-open me-1"></i> 全部分类</h3>
            <ul class="sidebar-list">
                <?php foreach ($categoryList as $cat): ?>
                    <li><a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $cat['cat_id'] ?>"><?= htmlspecialchars($cat['cat_name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-bag-heart me-1"></i> 商城服务</h3>
            <ul class="sidebar-list">
                <li><a href="#">新用户首单优惠</a></li>
                <li><a href="#">全场满99元免运费包邮</a></li>
            </ul>
        </div>

        <div class="content-middle">
            <div class="goods-header">
                <div class="goods-title">
                    <span class="title-icon"></span>
                    <span>分类商品</span>
                </div>
                <a href="<?php echo APP_BASE ?>/index/goods_list" class="more-link">查看全部 ></a>
            </div>
            <div class="goods-grid">
                <?php foreach ($categoryList as $cat): ?>
                    <div class="category-item" onclick="location.href='<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $cat['cat_id'] ?>'">
                        <span class="category-icon"></span>
                        <span class="category-name"><?= htmlspecialchars($cat['cat_name']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="sidebar-right">
            <h3 class="sidebar-title"><i class="bi bi-fire me-1"></i> 热销TOP榜单</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">1. 高清屏幕电脑</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">2. 无线蓝牙耳机</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">3. 智能运动手表</a></li>
            </ul>
            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-gift me-1"></i> 优惠中心</h3>
            <ul class="sidebar-list">
                <li><a href="#">满200减20 通用券</a></li>
                <li><a href="#">满200减20 品类券</a></li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>热卖商城 &copy;2026 版权所有 | 客服热线：00-123-4567 | 地址：线上电商产业园</p>
    </div>

    <!-- 购物车悬浮框-->
    <div class="cart-float-box" id="cart-float-box">
        <div class="cart-float-header">
            <h3>我的购物车</h3>
            <span class="cart-float-close" id="cart-float-close">×</span>
        </div>
        <div class="cart-float-content" id="cart-float-content">
            <div class="cart-float-empty">购物车为空</div>
        </div>
        <div class="cart-float-footer">
            <div class="cart-float-total">
                <span>合计</span>
                <span class="cart-float-price">¥ 0.00</span>
            </div>
            <a href="<?php echo APP_BASE ?>/index/cart" class="cart-float-btn">去结算</a>
        </div>
    </div>

    <!-- 遮罩层 -->
    <div class="overlay" id="overlay"></div>

    <div class="back-top"><i class="bi bi-arrow-up"></i></div>
    <div class="toast" id="toast"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <script>
        const loader = document.querySelector('.loader');
        const mainBoxes = document.querySelectorAll('.main-content');
        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.add('hide');
                mainBoxes.forEach(box => box.classList.add('show'));
            }, 1200);
            fetchCartCount();
        });

        function showToast(text) {
            const toast = document.getElementById('toast');
            toast.innerText = text;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2000);
        }

        function fetchCartCount() {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/count')
                .then(r => r.text())
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        console.error('解析JSON失败:', text);
                        return;
                    }
                    if (data.code === 200) {
                        document.querySelectorAll('.cart-count, .cart-num').forEach(el => {
                            el.innerText = data.cart_count;
                        });
                    }
                });
        }

        const backTop = document.querySelector('.back-top');
        window.addEventListener('scroll', () => {
            backTop.style.display = document.documentElement.scrollTop > 300 ? 'block' : 'none';
        });
        backTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // 购物车悬浮框
        const headCart = document.getElementById('head-cart');
        const cartFloatBox = document.getElementById('cart-float-box');
        const overlay = document.getElementById('overlay');
        const cartFloatClose = document.getElementById('cart-float-close');
        const cartFloatContent = document.getElementById('cart-float-content');
        const cartFloatPrice = document.querySelector('.cart-float-price');

        // 使用事件委托监听删除按钮点击
        if (cartFloatContent) {
            cartFloatContent.addEventListener('click', function(e) {
                const target = e.target;
                if (target.classList.contains('cart-float-del')) {
                    e.stopPropagation();
                    const cartId = target.getAttribute('data-cart-id');
                    if (cartId) {
                        deleteCartItem(cartId);
                    }
                }
            });
        }

        function loadCartData() {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/index')
                .then(r => r.text())
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        console.error('解析JSON失败:', text);
                        return;
                    }
                    if (data.code === 200) {
                        if (data.data && data.data.length > 0) {
                            let html = '';
                            data.data.forEach(item => {
                                html += `
                        <div class="cart-float-item" data-cart-id="${item.cart_id}" style="position:relative;">
                            <img src="<?php echo APP_BASE ?>/resources/images/${item.goods_img || 'default.jpg'}" 
                                 onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                 alt="${item.goods_name}">
                            <div class="cart-float-item-info">
                                <div class="cart-float-item-name">${item.goods_name}</div>
                                <div class="cart-float-item-price">¥${(item.goods_price * item.goods_num).toFixed(2)}</div>
                                <div class="cart-float-item-num">x${item.goods_num}</div>
                            </div>
                            <span class="cart-float-del" data-cart-id="${item.cart_id}" style="cursor:pointer;position:absolute;top:5px;right:5px;color:#999;font-size:18px;font-weight:bold;z-index:10;display:inline-block;width:20px;height:20px;line-height:18px;text-align:center;">×</span>
                        </div>
                    `;
                            });
                            cartFloatContent.innerHTML = html;
                            cartFloatPrice.innerText = '¥' + data.total.toFixed(2);
                        } else {
                            cartFloatContent.innerHTML = '<div class="cart-float-empty">购物车为空</div>';
                            cartFloatPrice.innerText = '¥ 0.00';
                        }
                    } else if (data.code === 401) {
                        cartFloatContent.innerHTML = '<div class="cart-float-empty"><a href="<?php echo APP_BASE ?>/index/login">请先登录查看购物车</a></div>';
                        cartFloatPrice.innerText = '¥ 0.00';
                    }
                }).catch(err => {
                    console.error('加载购物车失败', err);
                });
        }

        function deleteCartItem(cartId) {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'cart_id=' + cartId
                })
                .then(r => r.text())
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        console.error('解析JSON失败:', text);
                        return;
                    }
                    if (data.code === 200) {
                        document.getElementById('cart-num').innerText = data.cart_count || 0;
                        document.querySelectorAll('.cart-count').forEach(el => {
                            el.innerText = data.cart_count || 0;
                        });
                        loadCartData();
                        showToast('删除成功');
                    }
                });
        }

        headCart.addEventListener('click', () => {
            loadCartData();
            cartFloatBox.classList.add('show');
            overlay.classList.add('show');
        });

        cartFloatClose.addEventListener('click', () => {
            cartFloatBox.classList.remove('show');
            overlay.classList.remove('show');
        });

        overlay.addEventListener('click', () => {
            cartFloatBox.classList.remove('show');
            overlay.classList.remove('show');
        });
    </script>
</body>

</html>