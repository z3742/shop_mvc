<?php
$cartCount = isset($cartCount) ? $cartCount : 0;
$categoryList = isset($categoryList) ? $categoryList : [];
$bannerList = isset($bannerList) ? $bannerList : [];
$randomGoods = isset($randomGoods) ? $randomGoods : [];
$flashSales = isset($flashSales) ? $flashSales : [];
$flashEndTime = isset($flashEndTime) ? $flashEndTime : null;
$hotRanking = isset($hotRanking) ? $hotRanking : [];
$recentlyViewed = isset($recentlyViewed) ? $recentlyViewed : [];
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>热卖商城 - 首页</title>
    <link rel="stylesheet" href="<?php echo APP_BASE ?>/resources/css/style.css">
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
                <a href="<?php echo APP_BASE ?>/index/cart">购物车(<span class="cart-count"><?= $cartCount ?></span>)</a>
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
                <button type="submit" class="search-btn">搜索</button>
            </form>
            <div class="head-cart" id="head-cart">购物车<span class="cart-num" id="cart-num"><?= $cartCount ?></span></div>
        </div>
    </div>

    <div class="nav">
        <div class="nav-inner">
            <ul class="nav-list">
                <li class="active"><a href="<?php echo APP_BASE ?>/index/index">首页</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/category">全部分类</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">精选商品</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/cart">购物车</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/user">个人中心</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/help">帮助中心</a></li>
            </ul>
        </div>
    </div>

    <!-- ========== 限时秒杀专区 ========== -->
    <?php if (!empty($flashSales)): ?>
    <div class="main-content" style="margin-top: 20px;">
        <div class="flash-sale-section">
            <div class="flash-sale-header">
                <div class="flash-sale-title">
                    <span class="flash-icon">⚡</span>
                    <h2>限时秒杀</h2>
                    <span class="flash-subtitle">超低价格 · 限时抢购 · 抢完即止</span>
                </div>
                <div class="flash-timer" id="flash-timer" data-end-time="<?= htmlspecialchars($flashEndTime ?? '') ?>">
                    <span class="timer-label">距结束</span>
                    <span class="flash-timer-item" id="timer-hours">00</span>
                    <span class="flash-timer-sep">:</span>
                    <span class="flash-timer-item" id="timer-minutes">00</span>
                    <span class="flash-timer-sep">:</span>
                    <span class="flash-timer-item" id="timer-seconds">00</span>
                </div>
            </div>
            <div class="flash-sale-grid">
                <?php foreach ($flashSales as $flash): 
                    $soldPercent = $flash['total_stock'] > 0 ? round($flash['sold_count'] / $flash['total_stock'] * 100) : 0;
                ?>
                    <a href="<?php echo APP_BASE ?>/index/goods_detail?id=<?= $flash['goods_id'] ?>" class="flash-sale-card">
                        <div class="goods-image">
                            <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($flash['goods_img'] ?? 'default.jpg') ?>"
                                onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                alt="<?= htmlspecialchars($flash['goods_name']) ?>">
                            <span class="flash-sale-tag">秒杀</span>
                        </div>
                        <div class="flash-sale-info">
                            <div class="flash-sale-name"><?= htmlspecialchars($flash['goods_name']) ?></div>
                            <div class="flash-price-row">
                                <span class="flash-price">¥<?= number_format($flash['flash_price'], 0) ?></span>
                                <span class="flash-original-price">¥<?= number_format($flash['original_price'], 0) ?></span>
                            </div>
                            <div class="flash-progress">
                                <div class="flash-progress-bar">
                                    <div class="flash-progress-fill" style="width: <?= $soldPercent ?>%"></div>
                                </div>
                                <div class="flash-progress-text">已抢<?= $soldPercent ?>%</div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ========== Banner区域 ========== -->
    <div class="banner-section main-content">
        <div class="banner-row">
            <div class="category-nav">
                <div class="nav-header">
                    <span class="nav-icon">📁</span>
                    <span>全部分类</span>
                </div>
                <ul class="nav-list">
                    <?php foreach ($categoryList as $cat): ?>
                        <li>
                            <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $cat['cat_id'] ?>">
                                <span class="nav-item-icon">●</span>
                                <span class="nav-item-name"><?= htmlspecialchars($cat['cat_name']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="main-banner-area">
                <div class="main-banner">
                    <?php if (!empty($bannerList)): ?>
                        <?php foreach ($bannerList as $key => $banner): ?>
                            <div class="slide-item <?= $key == 0 ? 'active' : '' ?>">
                                <a href="<?= htmlspecialchars($banner['banner_url']) ?>">
                                    <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($banner['banner_img']) ?>" alt="<?= htmlspecialchars($banner['banner_title']) ?>">
                                </a>
                                <div class="slide-text">
                                    <h2><?= htmlspecialchars($banner['banner_title']) ?></h2>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="slide-item active">
                            <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=1">
                                <img src="<?php echo APP_BASE ?>/resources/images/banner/banner1.jpg" alt="banner1">
                            </a>
                            <div class="slide-text">
                                <h2>数码好物 限时特惠</h2>
                                <p>全场低价，正品保障，全国包邮</p>
                            </div>
                        </div>
                        <div class="slide-item">
                            <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=2">
                                <img src="<?php echo APP_BASE ?>/resources/images/banner/banner2.jpg" alt="banner2">
                            </a>
                            <div class="slide-text">
                                <h2>美妆护肤 新品上市</h2>
                                <p>大牌美妆，品质保障，放心购买</p>
                            </div>
                        </div>
                        <div class="slide-item">
                            <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=3">
                                <img src="<?php echo APP_BASE ?>/resources/images/banner/banner3.jpg" alt="banner3">
                            </a>
                            <div class="slide-text">
                                <h2>生活百货 应有尽有</h2>
                                <p>品质生活，从这里开始，全场满减</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <button class="banner-arrow banner-prev" id="banner-prev">‹</button>
                    <button class="banner-arrow banner-next" id="banner-next">›</button>
                </div>
                <div class="banner-dots">
                    <?php if (!empty($bannerList)): ?>
                        <?php foreach ($bannerList as $key => $banner): ?>
                            <span class="banner-dot <?= $key == 0 ? 'active' : '' ?>" data-index="<?= $key ?>"></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="banner-dot active" data-index="0"></span>
                        <span class="banner-dot" data-index="1"></span>
                        <span class="banner-dot" data-index="2"></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="side-banners-area">
                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=1" class="side-banner-item">
                    <img src="<?php echo APP_BASE ?>/resources/images/banner/banner-phone.jpg" alt="banner-phone">
                </a>
                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=6" class="side-banner-item">
                    <img src="<?php echo APP_BASE ?>/resources/images/banner/banner-tools.jpg" alt="banner-tools">
                </a>
                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=3" class="side-banner-item">
                    <img src="<?php echo APP_BASE ?>/resources/images/banner/banner-lifetools.jpg" alt="banner-lifetools">
                </a>
                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=2" class="side-banner-item">
                    <img src="<?php echo APP_BASE ?>/resources/images/banner/banner-meizhuang.jpg" alt="banner-meizhuang">
                </a>
            </div>
        </div>
    </div>

    <!-- ========== 热销排行榜 ========== -->
    <?php if (!empty($hotRanking)): ?>
    <div class="hot-rank-section main-content">
        <div class="goods-header">
            <div class="goods-title">
                <span class="title-icon">🏆</span>
                <span>热销排行榜</span>
            </div>
            <a href="<?php echo APP_BASE ?>/index/goods_list?sort=sales" class="more-link">查看更多 →</a>
        </div>
        <div class="hot-rank-list">
            <?php foreach ($hotRanking as $index => $item): $rank = $index + 1; ?>
                <a href="<?php echo APP_BASE ?>/index/goods_detail?id=<?= $item['goods_id'] ?>" class="hot-rank-item">
                    <span class="hot-rank-num rank-<?= $rank ?>"><?= $rank ?></span>
                    <div class="hot-rank-image">
                        <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($item['goods_img'] ?? 'default.jpg') ?>"
                            onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                            alt="<?= htmlspecialchars($item['goods_name']) ?>">
                    </div>
                    <div class="hot-rank-info">
                        <div class="hot-rank-name"><?= htmlspecialchars($item['goods_name']) ?></div>
                        <div class="hot-rank-price">¥<?= number_format($item['goods_price'], 2) ?></div>
                        <div class="hot-rank-sales">已售<?= $item['sales'] ?? 0 ?>件</div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ========== 热门商品 ========== -->
    <div class="goods-section main-content">
        <div class="goods-header">
            <div class="goods-title">
                <span class="title-icon">🔥</span>
                <span>热门商品</span>
            </div>
            <a href="<?php echo APP_BASE ?>/index/goods_list" class="more-link">查看更多 →</a>
        </div>
        <div class="goods-grid">
            <?php if (!empty($randomGoods)): ?>
                <?php foreach ($randomGoods as $goods): ?>
                    <div class="goods-card">
                        <a href="<?php echo APP_BASE ?>/index/goods_detail?id=<?= $goods['goods_id'] ?>">
                            <div class="goods-image">
                                <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($goods['goods_img'] ?? 'default.jpg') ?>"
                                    onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                    alt="<?= htmlspecialchars($goods['goods_name']) ?>">
                                <?php if ($goods['is_hot']): ?>
                                    <span class="hot-tag">HOT</span>
                                <?php endif; ?>
                            </div>
                            <div class="goods-info">
                                <div class="goods-title-text"><?= htmlspecialchars($goods['goods_name']) ?></div>
                                <div class="goods-price-info">
                                    <span class="price">¥<?= number_format($goods['goods_price'], 2) ?></span>
                                    <?php if (!empty($goods['sales'])): ?>
                                        <span class="goods-sales-text">已售<?= $goods['sales'] ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                        <button class="view-detail-btn" data-goods-id="<?= $goods['goods_id'] ?>">查看详情</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="goods-card">
                    <a href="<?php echo APP_BASE ?>/index/goods_detail?id=1">
                        <div class="goods-image">
                            <img src="<?php echo APP_BASE ?>/resources/images/goods/goods1.jpg"
                                onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                alt="示例商品">
                            <span class="hot-tag">HOT</span>
                        </div>
                        <div class="goods-info">
                            <div class="goods-title-text">示例商品1</div>
                            <div class="goods-price-info">
                                <span class="price">¥99.00</span>
                            </div>
                        </div>
                    </a>
                    <button class="view-detail-btn" data-goods-id="1">查看详情</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ========== 最近浏览 ========== -->
    <?php if (!empty($recentlyViewed)): ?>
    <div class="recent-viewed-section main-content">
        <div class="goods-header">
            <div class="goods-title">
                <span class="title-icon">👁</span>
                <span>最近浏览</span>
            </div>
        </div>
        <div class="recent-viewed-grid">
            <?php foreach ($recentlyViewed as $item): ?>
                <a href="<?php echo APP_BASE ?>/index/goods_detail?id=<?= $item['goods_id'] ?>" class="goods-card" style="text-decoration:none;">
                    <div class="goods-image">
                        <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($item['goods_img'] ?? 'default.jpg') ?>"
                            onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                            alt="<?= htmlspecialchars($item['goods_name']) ?>">
                        <?php if ($item['is_hot']): ?>
                            <span class="hot-tag">HOT</span>
                        <?php endif; ?>
                    </div>
                    <div class="goods-info">
                        <div class="goods-title-text"><?= htmlspecialchars($item['goods_name']) ?></div>
                        <div class="goods-price-info">
                            <span class="price">¥<?= number_format($item['goods_price'], 2) ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ========== 猜你喜欢 ========== -->
    <div class="goods-section main-content">
        <div class="goods-header">
            <div class="goods-title">
                <span class="title-icon">💡</span>
                <span>猜你喜欢</span>
            </div>
            <a href="<?php echo APP_BASE ?>/index/goods_list" class="more-link">查看更多 →</a>
        </div>
        <div class="goods-grid" id="recommend-goods">
            <div style="text-align:center;color:var(--text-muted);padding:30px;grid-column:1/-1;">正在为您推荐商品...</div>
        </div>
    </div>

    <div class="footer">
        <p>热卖商城 ©2026 版权所有 | 客服热线：400-123-4567 | 地址：线上电商产业园</p>
    </div>

    <!-- 主题切换按钮 -->
    <button class="theme-toggle" id="theme-toggle" title="切换深色/浅色模式">🌙</button>

    <!-- 购物车悬浮框 -->
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

    <div class="overlay" id="overlay"></div>
    <div class="back-top">↑</div>
    <div class="toast" id="toast"></div>

    <script>
        /* ========== 主题切换 ========== */
        (function() {
            const themeToggle = document.getElementById('theme-toggle');
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                themeToggle.textContent = '☀';
            }
            themeToggle.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                if (currentTheme === 'dark') {
                    document.documentElement.removeAttribute('data-theme');
                    localStorage.setItem('theme', 'light');
                    themeToggle.textContent = '🌙';
                } else {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                    themeToggle.textContent = '☀';
                }
            });
        })();

        /* ========== 页面加载动画 ========== */
        const loader = document.querySelector('.loader');
        const mainBoxes = document.querySelectorAll('.main-content');
        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.add('hide');
                mainBoxes.forEach(box => box.classList.add('show'));
            }, 800);
        });

        function showToast(text) {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.innerText = text;
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2000);
            }
        }

        /* ========== 返回顶部 ========== */
        const backTop = document.querySelector('.back-top');
        if (backTop) {
            window.addEventListener('scroll', () => {
                backTop.style.display = document.documentElement.scrollTop > 300 ? 'block' : 'none';
            });
            backTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        /* ========== 秒杀倒计时 ========== */
        (function() {
            const timerEl = document.getElementById('flash-timer');
            if (!timerEl) return;
            const endTime = timerEl.dataset.endTime;
            if (!endTime) return;

            function updateTimer() {
                const end = new Date(endTime).getTime();
                const now = new Date().getTime();
                const diff = end - now;
                if (diff <= 0) {
                    document.getElementById('timer-hours').textContent = '00';
                    document.getElementById('timer-minutes').textContent = '00';
                    document.getElementById('timer-seconds').textContent = '00';
                    return;
                }
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                document.getElementById('timer-hours').textContent = String(hours).padStart(2, '0');
                document.getElementById('timer-minutes').textContent = String(minutes).padStart(2, '0');
                document.getElementById('timer-seconds').textContent = String(seconds).padStart(2, '0');
            }
            updateTimer();
            setInterval(updateTimer, 1000);
        })();

        /* ========== 交互功能 ========== */
        document.addEventListener('DOMContentLoaded', function() {
            const viewBtns = document.querySelectorAll('.view-detail-btn');
            viewBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const goodsId = btn.dataset.goodsId;
                    window.location.href = '<?php echo APP_BASE ?>/index/goods_detail?id=' + goodsId;
                });
            });

            const headCart = document.getElementById('head-cart');
            const cartFloatBox = document.getElementById('cart-float-box');
            const overlay = document.getElementById('overlay');
            const cartFloatClose = document.getElementById('cart-float-close');
            const cartFloatContent = document.getElementById('cart-float-content');
            const cartFloatPrice = document.querySelector('.cart-float-price');

            if (cartFloatContent) {
                cartFloatContent.addEventListener('click', function(e) {
                    const target = e.target;
                    if (target.classList.contains('cart-float-del')) {
                        e.stopPropagation();
                        const cartId = target.getAttribute('data-cart-id');
                        if (cartId) deleteCartItem(cartId);
                    }
                });
            }

            function loadCartData() {
                fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/index')
                    .then(r => r.text())
                    .then(text => {
                        let data;
                        try { data = JSON.parse(text); } catch (e) { return; }
                        if (data.code === 200) {
                            if (data.data && data.data.length > 0) {
                                let html = '';
                                data.data.forEach(item => {
                                    html += `
                                        <div class="cart-float-item" data-cart-id="${item.cart_id}">
                                            <img src="<?php echo APP_BASE ?>/resources/images/${item.goods_img || 'default.jpg'}"
                                                 onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                                 alt="${item.goods_name}">
                                            <div class="cart-float-item-info">
                                                <div class="cart-float-item-name">${item.goods_name}</div>
                                                <div class="cart-float-item-price">¥${(item.goods_price * item.goods_num).toFixed(2)}</div>
                                                <div class="cart-float-item-num">x${item.goods_num}</div>
                                            </div>
                                            <span class="cart-float-del" data-cart-id="${item.cart_id}">×</span>
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
                    }).catch(err => console.error('加载购物车失败', err));
            }

            function deleteCartItem(cartId) {
                fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'cart_id=' + cartId
                })
                .then(r => r.text())
                .then(text => {
                    let data;
                    try { data = JSON.parse(text); } catch (e) { return; }
                    if (data.code === 200) {
                        const cartNumEl = document.getElementById('cart-num');
                        const cartCountEl = document.querySelector('.cart-count');
                        if (cartNumEl) cartNumEl.innerText = data.cart_count || 0;
                        if (cartCountEl) cartCountEl.innerText = data.cart_count || 0;
                        loadCartData();
                        showToast('删除成功');
                    } else {
                        showToast(data.msg || '删除失败');
                    }
                })
                .catch(err => { console.error('删除失败', err); showToast('删除失败，请重试'); });
            }

            if (headCart) {
                headCart.addEventListener('click', () => {
                    loadCartData();
                    cartFloatBox.classList.add('show');
                    overlay.classList.add('show');
                });
            }
            if (cartFloatClose) {
                cartFloatClose.addEventListener('click', () => {
                    cartFloatBox.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }
            if (overlay) {
                overlay.addEventListener('click', () => {
                    cartFloatBox.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }

            // Banner轮播
            const mainBanner = document.querySelector('.main-banner');
            const slideItems = document.querySelectorAll('.slide-item');
            const bannerDots = document.querySelectorAll('.banner-dot');
            const prevBtn = document.getElementById('banner-prev');
            const nextBtn = document.getElementById('banner-next');

            if (mainBanner && slideItems.length > 1) {
                let currentIndex = 0;
                const totalSlides = slideItems.length;

                function showSlide(index) {
                    slideItems.forEach((slide, i) => {
                        slide.classList.remove('active');
                        bannerDots[i]?.classList.remove('active');
                    });
                    slideItems[index].classList.add('active');
                    bannerDots[index]?.classList.add('active');
                    currentIndex = index;
                }
                function nextSlide() { showSlide((currentIndex + 1) % totalSlides); }
                function prevSlide() { showSlide((currentIndex - 1 + totalSlides) % totalSlides); }

                bannerDots.forEach((dot, index) => dot.addEventListener('click', () => showSlide(index)));
                prevBtn?.addEventListener('click', (e) => { e.preventDefault(); prevSlide(); });
                nextBtn?.addEventListener('click', (e) => { e.preventDefault(); nextSlide(); });

                let timer = setInterval(nextSlide, 4000);
                mainBanner.addEventListener('mouseenter', () => clearInterval(timer));
                mainBanner.addEventListener('mouseleave', () => { timer = setInterval(nextSlide, 4000); });
            }

            loadRecommendGoods();
        });

        function loadRecommendGoods() {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=goods/hot')
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data && data.data.length > 0) {
                        let html = '';
                        data.data.forEach(item => {
                            html += `
                                <div class="goods-card">
                                    <a href="<?php echo APP_BASE ?>/index/goods_detail?id=${item.goods_id}">
                                        <div class="goods-image">
                                            <img src="<?php echo APP_BASE ?>/resources/images/${item.goods_img || 'default.jpg'}"
                                                 onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                                 alt="${item.goods_name}">
                                            <span class="hot-tag">HOT</span>
                                        </div>
                                        <div class="goods-info">
                                            <div class="goods-title-text">${item.goods_name}</div>
                                            <div class="goods-price-info">
                                                <span class="price">¥${parseFloat(item.goods_price).toFixed(2)}</span>
                                            </div>
                                        </div>
                                    </a>
                                    <button class="view-detail-btn" data-goods-id="${item.goods_id}">查看详情</button>
                                </div>
                            `;
                        });
                        document.getElementById('recommend-goods').innerHTML = html;
                        document.querySelectorAll('.view-detail-btn').forEach(btn => {
                            btn.addEventListener('click', () => {
                                window.location.href = '<?php echo APP_BASE ?>/index/goods_detail?id=' + btn.dataset.goodsId;
                            });
                        });
                    } else {
                        document.getElementById('recommend-goods').innerHTML = '<div style="text-align:center;color:var(--text-muted);padding:30px;grid-column:1/-1;">暂无推荐商品</div>';
                    }
                })
                .catch(err => {
                    console.error('加载推荐商品失败', err);
                    document.getElementById('recommend-goods').innerHTML = '<div style="text-align:center;color:var(--text-muted);padding:30px;grid-column:1/-1;">加载推荐失败</div>';
                });
        }
    </script>
</body>

</html>