<?php
// 确保变量有默认值，避免Undefined variable错误
$categoryList = isset($categoryList) ? $categoryList : [];
$category = isset($category) ? $category : ['cat_name' => '全部商品'];
$total = isset($total) ? $total : 0;
$goodsList = isset($goodsList) ? $goodsList : [];
$totalPages = isset($totalPages) ? $totalPages : 1;
$page = isset($page) ? $page : 1;
$catId = isset($catId) ? $catId : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$minPrice = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$maxPrice = isset($_GET['max_price']) ? $_GET['max_price'] : '';

// 构建分页URL参数
$queryParams = [];
if ($catId > 0) $queryParams['cat_id'] = $catId;
if ($sort != 'default') $queryParams['sort'] = $sort;
if ($minPrice !== '') $queryParams['min_price'] = $minPrice;
if ($maxPrice !== '') $queryParams['max_price'] = $maxPrice;
$queryStr = http_build_query($queryParams);
$prefix = $queryStr ? '&' . $queryStr : '';
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品列表 - 热卖商城</title>
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
                    <li class="nav-item"><a class="nav-link active" href="<?php echo APP_BASE ?>/index/goods_list"><i class="bi bi-stars me-1"></i>精选商品</a></li>
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
                <a href="<?php echo APP_BASE ?>/index/goods_list" class="list-group-item active"><i class="bi bi-stars me-2"></i>精选商品</a>
                <a href="<?php echo APP_BASE ?>/index/cart" class="list-group-item"><i class="bi bi-cart3 me-2"></i>购物车</a>
                <a href="<?php echo APP_BASE ?>/index/user" class="list-group-item"><i class="bi bi-person me-2"></i>个人中心</a>
                <a href="<?php echo APP_BASE ?>/index/help" class="list-group-item"><i class="bi bi-question-circle me-2"></i>帮助中心</a>
            </div>
        </div>
    </div>

    <div class="main-layout main-content">
        <div class="sidebar-left">
            <h3 class="sidebar-title"><i class="bi bi-bag-heart me-1"></i> 全部分类</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">全部商品</a></li>
                <?php foreach ($categoryList as $cat): ?>
                    <li><a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $cat['cat_id'] ?>"><?= htmlspecialchars($cat['cat_name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-headset me-1"></i> 客户服务</h3>
            <ul class="sidebar-list">
                <li><a href="#">在线人工客服</a></li>
                <li><a href="#">物流订单查询</a></li>
            </ul>
        </div>

        <div class="content-middle">
            <div class="goods-header">
                <div class="goods-title">
                    <span class="title-icon"><i class="bi bi-gift-fill"></i></span>
                    <span><?= htmlspecialchars($category['cat_name'] ?? '全部商品') ?></span>
                </div>
                <span style="color:var(--text-muted);font-size:14px;">共 <?= $total ?> 件商品</span>
            </div>

            <!-- 排序栏 -->
            <div class="sort-bar">
                <span class="sort-bar-label">排序方式：</span>
                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $catId ?>" class="sort-btn <?= $sort == 'default' ? 'active' : '' ?>">综合</a>
                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $catId ?>&sort=sales" class="sort-btn <?= $sort == 'sales' ? 'active' : '' ?>">销量优先</a>
                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $catId ?>&sort=price_asc" class="sort-btn <?= $sort == 'price_asc' ? 'active' : '' ?>">价格 <span class="sort-arrow">↓</span></a>
                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $catId ?>&sort=price_desc" class="sort-btn <?= $sort == 'price_desc' ? 'active' : '' ?>">价格 <span class="sort-arrow">↑</span></a>

                <!-- 价格筛选 -->
                <div class="price-filter">
                    <input type="number" id="min-price" placeholder="最低价" value="<?= htmlspecialchars($minPrice) ?>" min="0">
                    <span style="color:var(--text-muted);">-</span>
                    <input type="number" id="max-price" placeholder="最高价" value="<?= htmlspecialchars($maxPrice) ?>" min="0">
                    <button id="price-filter-btn">筛选</button>
                </div>
            </div>

            <div class="goods-grid">
                <?php foreach ($goodsList as $goods): ?>
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
                        <a href="<?php echo APP_BASE ?>/index/goods_detail?id=<?= $goods['goods_id'] ?>" class="view-detail-btn btn-bs-outline"><i class="bi bi-eye me-1"></i>查看详情</a>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <div class="page-box">
                    <?php if ($page > 1): ?>
                        <a href="<?php echo APP_BASE ?>/index/goods_list?page=<?= $page - 1 ?><?= $prefix ?>">上一页</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="<?php echo APP_BASE ?>/index/goods_list?page=<?= $i ?><?= $prefix ?>" <?= $i == $page ? 'class="active"' : '' ?>><?= $i ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="<?php echo APP_BASE ?>/index/goods_list?page=<?= $page + 1 ?><?= $prefix ?>">下一页</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="sidebar-right">
            <h3 class="sidebar-title"><i class="bi bi-fire me-1"></i> 热门推荐</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/goods_list?sort=sales">人气单品</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list?sort=price_asc">低价好物</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">新品上架</a></li>
            </ul>
            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-person-circle me-1"></i> 个人中心</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/user">我的订单</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/user">我的收藏</a></li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>热卖商城 &copy;2026 版权所有 | 客服热线：400-123-4567 | 地址：线上电商产业园</p>
    </div>

    <button class="theme-toggle" id="theme-toggle" title="切换深色/浅色模式"><i class="bi bi-moon-stars" id="theme-icon"></i></button>
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
                    try { data = JSON.parse(text); } catch (e) { return; }
                    if (data.code === 200) {
                        document.querySelectorAll('.cart-count, .cart-num').forEach(el => {
                            el.innerText = data.cart_count;
                        });
                    }
                });
        }

        /* 价格筛选 */
        document.getElementById('price-filter-btn').addEventListener('click', function() {
            const minPrice = document.getElementById('min-price').value;
            const maxPrice = document.getElementById('max-price').value;
            let url = '<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $catId ?>&sort=<?= $sort ?>';
            if (minPrice) url += '&min_price=' + minPrice;
            if (maxPrice) url += '&max_price=' + maxPrice;
            window.location.href = url;
        });

        const backTop = document.querySelector('.back-top');
        window.addEventListener('scroll', () => {
            backTop.style.display = document.documentElement.scrollTop > 300 ? 'block' : 'none';
        });
        backTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        const headCart = document.getElementById('head-cart');
        const cartFloatBox = document.createElement('div');
        cartFloatBox.className = 'cart-float-box';
        cartFloatBox.id = 'cart-float-box';
        cartFloatBox.innerHTML = `
            <div class="cart-float-header">
                <h3>我的购物车</h3>
                <span class="cart-float-close" id="cart-float-close">×</span>
            </div>
            <div class="cart-float-content" id="cart-float-content">
                <div class="cart-float-empty">购物车为空</div>
            </div>
            <div class="cart-float-footer">
                <div class="cart-float-total">
                    <span>合计:</span>
                    <span class="cart-float-price">¥ 0.00</span>
                </div>
                <a href="<?php echo APP_BASE ?>/index/cart" class="cart-float-btn">去结算</a>
            </div>
        `;
        document.body.appendChild(cartFloatBox);

        const overlay = document.createElement('div');
        overlay.className = 'overlay';
        overlay.id = 'overlay';
        document.body.appendChild(overlay);

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