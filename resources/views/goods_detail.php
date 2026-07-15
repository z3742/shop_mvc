<?php
$goods = isset($goods) ? $goods : [];
$categoryList = isset($categoryList) ? $categoryList : [];
$category = isset($category) ? $category : [];
$isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1;
$relatedGoods = isset($relatedGoods) ? $relatedGoods : [];
$recentlyViewed = isset($recentlyViewed) ? $recentlyViewed : [];
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($goods['goods_name']) ?> - 热卖商城</title>
    <link rel="stylesheet" href="<?php echo APP_BASE ?>/resources/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo APP_BASE ?>/resources/css/bootstrap-custom.css">
</head>

<body>
    <div class="loader">
        <div class="loader-circle"></div>
        <p>页面加载中..</p>
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
                    <li class="nav-item"><a class="nav-link" href="<?php echo APP_BASE ?>/index/category"><i class="bi bi-grid me-1"></i>全部分类</a></li>
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
                <a href="<?php echo APP_BASE ?>/index/category" class="list-group-item"><i class="bi bi-grid me-2"></i>全部分类</a>
                <a href="<?php echo APP_BASE ?>/index/goods_list" class="list-group-item"><i class="bi bi-stars me-2"></i>精选商品</a>
                <a href="<?php echo APP_BASE ?>/index/cart" class="list-group-item"><i class="bi bi-cart3 me-2"></i>购物车</a>
                <a href="<?php echo APP_BASE ?>/index/user" class="list-group-item"><i class="bi bi-person me-2"></i>个人中心</a>
                <a href="<?php echo APP_BASE ?>/index/help" class="list-group-item"><i class="bi bi-question-circle me-2"></i>帮助中心</a>
            </div>
        </div>
    </div>

    <div class="main-content" style="margin-top: 20px;">
        <div class="row">
            <!-- 左侧分类导航 -->
            <div class="col-lg-2 d-none d-lg-block">
                <div class="glass-card rounded-xl p-4 mb-4">
                    <h4 class="font-bold text-dark mb-3"><i class="bi bi-bag-heart me-2"></i>相关分类</h4>
                    <ul class="list-unstyled">
                        <?php foreach ($categoryList as $cat): ?>
                            <li class="mb-2">
                                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $cat['cat_id'] ?>" class="text-dark hover:text-primary-light text-sm transition-colors">
                                    <i class="bi bi-chevron-right me-1"></i><?= htmlspecialchars($cat['cat_name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="glass-card rounded-xl p-4">
                    <h4 class="font-bold text-dark mb-3"><i class="bi bi-shield-check me-2"></i>购物须知</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-sm text-dark"><i class="bi bi-check-circle text-success me-1"></i>正品保证 全国联保</li>
                        <li class="mb-2 text-sm text-dark"><i class="bi bi-check-circle text-success me-1"></i>支持7天无理由退换</li>
                        <li class="text-sm text-dark"><i class="bi bi-check-circle text-success me-1"></i>极速发货 售后保障</li>
                    </ul>
                </div>
            </div>

            <!-- 中间内容区 -->
            <div class="col-lg-7">
                <!-- 商品详情卡片 -->
                <div class="card rounded-2xl shadow-lg overflow-hidden mb-4">
                    <div class="row">
                        <!-- 商品图片 -->
                        <div class="col-md-5">
                            <div class="p-4 bg-gray-50">
                                <div class="aspect-square rounded-xl overflow-hidden border border-gray-200">
                                    <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($goods['goods_img'] ?? 'default.jpg') ?>"
                                         onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                         alt="<?= htmlspecialchars($goods['goods_name']) ?>"
                                         class="w-full h-full object-contain">
                                </div>
                            </div>
                        </div>

                        <!-- 商品信息 -->
                        <div class="col-md-7 p-5">
                            <h1 class="text-xl font-bold text-dark mb-3"><?= htmlspecialchars($goods['goods_name']) ?></h1>
                            <div class="text-danger text-3xl font-extrabold mb-4">¥ <?= number_format($goods['goods_price'], 2) ?></div>
                            
                            <!-- 商品参数 -->
                            <div class="bg-gray-50 rounded-xl p-4 mb-4">
                                <div class="row row-cols-2 g-3">
                                    <div class="col"><span class="text-gray-500">库存：</span><span class="font-medium"><?= $goods['stock'] ?> 件</span></div>
                                    <div class="col"><span class="text-gray-500">销量：</span><span class="font-medium"><?= $goods['sales'] ?? 0 ?> 件</span></div>
                                    <div class="col"><span class="text-gray-500">分类：</span><span class="font-medium"><?= htmlspecialchars($category['cat_name'] ?? '未知') ?></span></div>
                                    <div class="col"><span class="text-gray-500">服务：</span><span class="font-medium">全国包邮 · 次日达</span></div>
                                </div>
                            </div>

                            <!-- 操作按钮 -->
                            <div class="d-flex flex-wrap gap-3">
                                <div class="d-flex align-items-center border border-gray-200 rounded-lg overflow-hidden">
                                    <button class="w-10 h-10 bg-gray-100 hover:bg-gray-200 transition-colors" onclick="decreaseNum()">-</button>
                                    <input type="text" value="1" id="buy-num" class="w-14 h-10 text-center border-0 outline-none">
                                    <button class="w-10 h-10 bg-gray-100 hover:bg-gray-200 transition-colors" onclick="increaseNum()">+</button>
                                </div>
                                <button class="btn btn-gradient-primary" data-goods-id="<?= $goods['goods_id'] ?>"><i class="bi bi-cart-plus me-1"></i>加入购物车</button>
                                <button class="btn btn-gradient-success" data-goods-id="<?= $goods['goods_id'] ?>"><i class="bi bi-lightning-charge me-1"></i>立即购买</button>
                                <button class="btn btn-outline-primary" data-goods-id="<?= $goods['goods_id'] ?>" id="favorite-btn"><i class="bi bi-heart me-1"></i>收藏</button>
                                <?php if ($isAdmin): ?>
                                    <button class="btn btn-gradient-danger" data-goods-id="<?= $goods['goods_id'] ?>"><i class="bi bi-trash me-1"></i>删除</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 标签页 -->
                <div class="card rounded-2xl shadow-lg overflow-hidden mb-4">
                    <div class="card-header bg-white border-0">
                        <ul class="nav nav-tabs bs-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab-desc">商品介绍</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-comment">商品评价</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-relate">相关推荐</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- 商品介绍 -->
                            <div class="tab-pane fade show active" id="tab-desc">
                                <p class="text-gray-600 leading-relaxed"><?= htmlspecialchars($goods['goods_desc'] ?? '暂无详细介绍') ?></p>
                            </div>

                            <!-- 商品评价 -->
                            <div class="tab-pane fade" id="tab-comment">
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="star-rating" id="rating-stars"></div>
                                        <span class="text-xl font-bold text-dark" id="rating-num">0.0</span>
                                        <span class="text-gray-500" id="rating-count">(0条评价)</span>
                                    </div>
                                </div>
                                <div id="comment-list" class="mb-4">
                                    <div class="text-center text-gray-400 py-10 border border-dashed border-gray-200 rounded-xl">暂无评价，快来发表第一条评价吧</div>
                                </div>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <h4 class="font-bold text-dark mb-3">发表评价</h4>
                                    <div class="mb-3">
                                        <span class="text-gray-500 me-2">评分：</span>
                                        <div class="star-rating" id="rating-input">
                                            <span class="star" data-rating="1">★</span>
                                            <span class="star" data-rating="2">★</span>
                                            <span class="star" data-rating="3">★</span>
                                            <span class="star" data-rating="4">★</span>
                                            <span class="star" data-rating="5">★</span>
                                        </div>
                                    </div>
                                    <textarea id="comment-content" rows="4" class="form-control bs-input mb-3" placeholder="请输入您的评价..."></textarea>
                                    <button class="btn btn-gradient-primary" id="submit-comment-btn">提交评价</button>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- 相关推荐 -->
                            <div class="tab-pane fade" id="tab-relate">
                                <?php if (!empty($relatedGoods)): ?>
                                    <div class="row g-4">
                                        <?php foreach ($relatedGoods as $related): ?>
                                            <div class="col-lg-4 col-md-6">
                                                <a href="<?php echo APP_BASE ?>/index/goods_detail?id=<?= $related['goods_id'] ?>" class="product-card card-lift rounded-xl overflow-hidden block">
                                                    <div class="aspect-square bg-gray-100 overflow-hidden">
                                                        <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($related['goods_img'] ?? 'default.jpg') ?>"
                                                             onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                                             alt="<?= htmlspecialchars($related['goods_name']) ?>"
                                                             class="w-full h-full object-cover hover:scale-105 transition-transform">
                                                    </div>
                                                    <div class="p-3">
                                                        <h5 class="font-medium text-dark text-sm truncate"><?= htmlspecialchars($related['goods_name']) ?></h5>
                                                        <span class="text-danger font-bold">¥<?= number_format($related['goods_price'], 2) ?></span>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center text-gray-400 py-10">暂无相关推荐</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 最近浏览 -->
                <?php if (!empty($recentlyViewed)): ?>
                <div class="card rounded-2xl shadow-lg overflow-hidden">
                    <div class="card-header bg-white border-0">
                        <h4 class="font-bold text-dark"><i class="bi bi-clock-history me-2"></i>最近浏览</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <?php foreach ($recentlyViewed as $item): ?>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <a href="<?php echo APP_BASE ?>/index/goods_detail?id=<?= $item['goods_id'] ?>" class="product-card card-lift rounded-xl overflow-hidden block">
                                        <div class="aspect-square bg-gray-100 overflow-hidden">
                                            <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($item['goods_img'] ?? 'default.jpg') ?>"
                                                 onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                                 alt="<?= htmlspecialchars($item['goods_name']) ?>"
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform">
                                        </div>
                                        <div class="p-3">
                                            <h5 class="font-medium text-dark text-sm truncate"><?= htmlspecialchars($item['goods_name']) ?></h5>
                                            <span class="text-danger font-bold">¥<?= number_format($item['goods_price'], 2) ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- 右侧边栏 -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="glass-card rounded-xl p-4 mb-4">
                    <h4 class="font-bold text-dark mb-3"><i class="bi bi-lightbulb me-2"></i>猜你喜欢</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo APP_BASE ?>/index/goods_list" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-star me-1"></i>人气单品</a></li>
                        <li class="mb-2"><a href="<?php echo APP_BASE ?>/index/goods_list?sort=sales" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-trophy me-1"></i>热销排行</a></li>
                        <li class="mb-2"><a href="<?php echo APP_BASE ?>/index/goods_list?sort=price_asc" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-tag me-1"></i>低价好物</a></li>
                        <li><a href="<?php echo APP_BASE ?>/index/goods_list" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-clock me-1"></i>新品上架</a></li>
                    </ul>
                </div>
                <div class="bg-gradient-blue rounded-xl p-4 text-white">
                    <h4 class="font-bold mb-3"><i class="bi bi-gift me-2"></i>专属优惠</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-percent me-1"></i>数码品类满200减20</li>
                        <li><i class="bi bi-ticket me-1"></i>单品直降优惠券</li>
                    </ul>
                    <button class="btn glass-btn w-full mt-3">立即领取</button>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>热卖商城 &copy;2026 版权所有 | 客服热线：400-123-4567 | 地址：线上电商产业园</p>
    </div>

    <button class="theme-toggle" id="theme-toggle" title="切换深色/浅色模式"><i class="bi bi-moon-stars" id="theme-icon"></i></button>

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
        /* 主题切换 */
        (function() {
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                if (themeIcon) themeIcon.className = 'bi bi-sun';
            }
            themeToggle.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                if (currentTheme === 'dark') {
                    document.documentElement.removeAttribute('data-theme');
                    localStorage.setItem('theme', 'light');
                    if (themeIcon) themeIcon.className = 'bi bi-moon-stars';
                } else {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                    if (themeIcon) themeIcon.className = 'bi bi-sun';
                }
            });
        })();

        const loader = document.querySelector('.loader');
        const mainBoxes = document.querySelectorAll('.main-content');
        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.add('hide');
                mainBoxes.forEach(box => box.classList.add('show'));
            }, 800);
            fetchCartCount();
            checkFavorite();
            loadComments();
            loadRating();
        });

        function showToast(text) {
            const toast = document.getElementById('toast');
            toast.innerText = text;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2000);
        }

        function fetchCartCount() {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/count')
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200) {
                        document.querySelectorAll('.cart-count, .cart-num').forEach(el => {
                            el.innerText = data.cart_count;
                        });
                    }
                });
        }

        function decreaseNum() {
            const input = document.getElementById('buy-num');
            let val = parseInt(input.value);
            if (val > 1) input.value = val - 1;
        }

        function increaseNum() {
            const input = document.getElementById('buy-num');
            input.value = parseInt(input.value) + 1;
        }

        const addCartBtn = document.querySelector('.btn.btn-gradient-primary[data-goods-id]');
        if (addCartBtn) {
            addCartBtn.addEventListener('click', () => {
                const goodsId = addCartBtn.dataset.goodsId;
                const num = parseInt(document.getElementById('buy-num').value);
                addCartBtn.disabled = true;
                const originalText = addCartBtn.innerHTML;
                addCartBtn.innerHTML = '<i class="bi bi-spinner bi-spin me-1"></i>添加中...';
                fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/add', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'goods_id=' + goodsId + '&num=' + num
                    })
                    .then(r => r.text())
                    .then(text => {
                        let data;
                        try { data = JSON.parse(text); } catch (e) {
                            throw new Error('响应不是有效的JSON: ' + text);
                        }
                        if (data.code === 200) {
                            document.querySelectorAll('.cart-count, .cart-num').forEach(el => el.innerText = data.cart_count);
                            showToast('成功加入购物车');
                        } else if (data.code === 401) {
                            showToast('请先登录');
                            setTimeout(() => location.href = '<?php echo APP_BASE ?>/index/login', 1000);
                        } else {
                            showToast(data.msg || '加入购物车失败');
                        }
                    })
                    .catch(err => { console.error('添加购物车错误', err); showToast('网络连接错误，请稍后重试'); })
                    .finally(() => { addCartBtn.disabled = false; addCartBtn.innerHTML = originalText; });
            });
        }

        const buyBtn = document.querySelector('.btn.btn-gradient-success[data-goods-id]');
        if (buyBtn) {
            buyBtn.addEventListener('click', async () => {
                const goodsId = buyBtn.dataset.goodsId || document.querySelector('.btn.btn-gradient-primary[data-goods-id]')?.dataset.goodsId;
                const num = parseInt(document.getElementById('buy-num').value);
                if (!goodsId) { showToast('商品信息获取失败'); return; }
                try {
                    const response = await fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/add', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'goods_id=' + goodsId + '&num=' + num
                    });
                    const text = await response.text();
                    let data;
                    try { data = JSON.parse(text); } catch (e) { throw new Error('响应不是有效的JSON: ' + text); }
                    if (data.code === 200) {
                        document.querySelectorAll('.cart-count, .cart-num').forEach(el => el.innerText = data.cart_count);
                        showToast('已成功加入购物车，正在跳转...');
                        setTimeout(() => location.href = '<?php echo APP_BASE ?>/index/cart', 800);
                    } else if (data.code === 401) {
                        showToast('请先登录');
                        setTimeout(() => location.href = '<?php echo APP_BASE ?>/index/login', 1000);
                    } else {
                        showToast(data.msg || '操作失败');
                    }
                } catch (err) { console.error('立即购买错误:', err); showToast('网络连接错误，请稍后重试'); }
            });
        }

        const deleteGoodsBtn = document.querySelector('.btn.btn-gradient-danger[data-goods-id]');
        if (deleteGoodsBtn) {
            deleteGoodsBtn.addEventListener('click', () => {
                if (!confirm('确定要删除该商品吗？')) return;
                const goodsId = deleteGoodsBtn.dataset.goodsId;
                deleteGoodsBtn.disabled = true;
                deleteGoodsBtn.innerHTML = '<i class="bi bi-spinner bi-spin me-1"></i>删除中...';
                fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=goods/delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'goods_id=' + goodsId
                })
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200) {
                        showToast('删除成功');
                        setTimeout(() => location.href = '<?php echo APP_BASE ?>/index/goods_list', 1000);
                    } else {
                        showToast(data.msg || '删除失败');
                        deleteGoodsBtn.disabled = false;
                        deleteGoodsBtn.innerHTML = '<i class="bi bi-trash me-1"></i>删除';
                    }
                })
                .catch(err => { console.error('删除商品错误:', err); showToast('网络连接错误'); deleteGoodsBtn.disabled = false; deleteGoodsBtn.innerHTML = '<i class="bi bi-trash me-1"></i>删除'; });
            });
        }

        const backTop = document.querySelector('.back-top');
        window.addEventListener('scroll', () => {
            backTop.style.display = document.documentElement.scrollTop > 300 ? 'block' : 'none';
        });
        backTop.addEventListener('click', () => { window.scrollTo({ top: 0, behavior: 'smooth' }); });

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
                .then(r => r.json())
                .then(data => {
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
            .then(r => r.json())
            .then(data => {
                if (data.code === 200) {
                    document.getElementById('cart-num').innerText = data.cart_count || 0;
                    document.querySelectorAll('.cart-count').forEach(el => el.innerText = data.cart_count || 0);
                    loadCartData();
                    showToast('删除成功');
                }
            });
        }

        if (headCart) {
            headCart.addEventListener('click', () => { loadCartData(); cartFloatBox.classList.add('show'); overlay.classList.add('show'); });
        }
        if (cartFloatClose) {
            cartFloatClose.addEventListener('click', () => { cartFloatBox.classList.remove('show'); overlay.classList.remove('show'); });
        }
        if (overlay) {
            overlay.addEventListener('click', () => { cartFloatBox.classList.remove('show'); overlay.classList.remove('show'); });
        }

        let selectedRating = 5;

        function checkFavorite() {
            const goodsId = document.querySelector('.btn.btn-gradient-primary[data-goods-id]')?.dataset.goodsId;
            if (!goodsId) return;
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=favorite/check&goods_id=' + goodsId)
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data.is_favorite) {
                        const btn = document.getElementById('favorite-btn');
                        if (btn) { btn.innerHTML = '<i class="bi bi-heart-fill me-1"></i>已收藏'; btn.classList.add('active'); }
                    }
                })
                .catch(err => console.error('检查收藏失败:', err));
        }

        const favoriteBtn = document.getElementById('favorite-btn');
        if (favoriteBtn) {
            favoriteBtn.addEventListener('click', () => {
                const goodsId = favoriteBtn.dataset.goodsId;
                if (!goodsId) return;
                if (favoriteBtn.innerHTML.includes('已收藏')) {
                    fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=favorite/remove', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'goods_id=' + goodsId
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.code === 200) {
                            showToast('取消收藏成功');
                            favoriteBtn.innerHTML = '<i class="bi bi-heart me-1"></i>收藏';
                            favoriteBtn.classList.remove('active');
                        } else { showToast(data.msg || '操作失败'); }
                    });
                } else {
                    fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=favorite/add', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'goods_id=' + goodsId
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.code === 200) {
                            showToast('收藏成功');
                            favoriteBtn.innerHTML = '<i class="bi bi-heart-fill me-1"></i>已收藏';
                            favoriteBtn.classList.add('active');
                        } else { showToast(data.msg || '操作失败'); }
                    });
                }
            });
        }

        function loadRating() {
            const goodsId = document.querySelector('.btn.btn-gradient-primary[data-goods-id]')?.dataset.goodsId;
            if (!goodsId) return;
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=comment/rating&goods_id=' + goodsId)
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data) {
                        const avgRating = data.data.avg_rating || 0;
                        const total = data.data.total || 0;
                        document.getElementById('rating-num').innerText = avgRating.toFixed(1);
                        document.getElementById('rating-count').innerText = '(' + total + '条评价)';
                        const starsContainer = document.getElementById('rating-stars');
                        let starsHtml = '';
                        for (let i = 1; i <= 5; i++) {
                            starsHtml += '<span style="font-size:24px;color:' + (i <= Math.round(avgRating) ? '#ffd700' : '#ddd') + ';">★</span>';
                        }
                        starsContainer.innerHTML = starsHtml;
                    }
                })
                .catch(err => console.error('加载评分失败:', err));
        }

        function loadComments() {
            const goodsId = document.querySelector('.btn.btn-gradient-primary[data-goods-id]')?.dataset.goodsId;
            if (!goodsId) return;
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=comment/list&goods_id=' + goodsId)
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data && data.data.length > 0) {
                        let html = '';
                        data.data.forEach(item => {
                            let stars = '';
                            for (let i = 1; i <= 5; i++) {
                                stars += '<span style="font-size:16px;color:' + (i <= item.rating ? '#ffd700' : '#ddd') + ';">★</span>';
                            }
                            html += `
                                <div class="border-bottom border-gray-100 py-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="font-bold text-dark">${item.username || '用户'}</span>
                                        <span class="text-gray-400 text-sm">${item.create_time || ''}</span>
                                    </div>
                                    <div class="mb-2">${stars}</div>
                                    <div class="text-gray-600">${item.content}</div>
                                </div>
                            `;
                        });
                        document.getElementById('comment-list').innerHTML = html;
                    }
                })
                .catch(err => console.error('加载评价失败:', err));
        }

        const stars = document.querySelectorAll('#rating-input .star');
        stars.forEach(star => {
            star.style.cursor = 'pointer';
            star.style.fontSize = '28px';
            star.style.color = '#ddd';
            star.style.marginRight = '4px';
            star.addEventListener('mouseenter', () => {
                const rating = parseInt(star.dataset.rating);
                stars.forEach(s => { s.style.color = parseInt(s.dataset.rating) <= rating ? '#ffd700' : '#ddd'; });
            });
            star.addEventListener('click', () => { selectedRating = parseInt(star.dataset.rating); });
            star.addEventListener('mouseleave', () => {
                stars.forEach(s => { s.style.color = parseInt(s.dataset.rating) <= selectedRating ? '#ffd700' : '#ddd'; });
            });
        });

        document.getElementById('submit-comment-btn')?.addEventListener('click', () => {
            const content = document.getElementById('comment-content').value.trim();
            const goodsId = document.querySelector('.btn.btn-gradient-primary[data-goods-id]')?.dataset.goodsId;
            if (!content) { showToast('请输入评价内容'); return; }
            const btn = document.getElementById('submit-comment-btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-spinner bi-spin me-1"></i>提交中...';
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=comment/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'goods_id=' + goodsId + '&content=' + encodeURIComponent(content) + '&rating=' + selectedRating
            })
            .then(r => r.json())
            .then(data => {
                if (data.code === 200) {
                    showToast('评价成功');
                    document.getElementById('comment-content').value = '';
                    loadComments();
                    loadRating();
                } else { showToast(data.msg || '评价失败'); }
            })
            .catch(err => { console.error('提交评价失败:', err); showToast('网络错误'); })
            .finally(() => { btn.disabled = false; btn.innerHTML = '提交评价'; });
        });
    </script>
</body>

</html>