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
    <!-- viewport: 响应式视口设置，width=device-width 自适应设备宽度，initial-scale=1.0 初始缩放比例 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>热卖商城 - 首页</title>
    <link rel="stylesheet" href="<?php echo APP_BASE ?>/resources/css/style.css">
    <!-- 引入 Bootstrap 5 CSS 框架 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- 引入 Bootstrap Icons 图标库 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- 自定义 Bootstrap 样式覆盖 -->
    <link rel="stylesheet" href="<?php echo APP_BASE ?>/resources/css/bootstrap-custom.css">
</head>

<body>
    <!-- 页面加载动画 -->
    <div class="loader">
        <div class="loader-circle"></div>
        <p>页面加载中...</p>
    </div>

    <!-- 顶部信息栏 -->
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

    <!-- 头部区域 -->
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
            <!-- data-bs-toggle="tooltip": 启用 Bootstrap Tooltip 提示组件 -->
            <!-- data-bs-placement="bottom": 设置提示框显示在元素下方 -->
            <div class="head-cart" id="head-cart" data-bs-toggle="tooltip" data-bs-placement="bottom" title="点击查看购物车">
                <i class="bi bi-cart3 me-1"></i>购物车<span class="cart-num" id="cart-num"><?= $cartCount ?></span>
            </div>
        </div>
    </div>

    <!-- ========== Bootstrap 导航栏组件 ========== -->
    <!-- navbar: 基础导航栏类 -->
    <!-- navbar-expand-lg: 在 lg (≥1200px) 屏幕以上展开，以下折叠 -->
    <!-- sticky-top: 粘性定位，滚动时固定在顶部 -->
    <nav class="navbar navbar-expand-lg bs-navbar sticky-top">
        <!-- container-fluid: 流体容器，宽度100%，带左右padding -->
        <div class="container-fluid" style="max-width:1600px;">
            <!-- navbar-toggler: 折叠切换按钮，仅在小屏幕显示 -->
            <!-- data-bs-toggle="offcanvas": 点击时触发 Offcanvas 组件 -->
            <!-- data-bs-target="#mobileNav": 指定目标 Offcanvas 的 ID -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav" aria-controls="mobileNav">
                <i class="bi bi-list fs-4" style="color:var(--text-primary);"></i>
            </button>
            <!-- navbar-collapse: 可折叠的导航内容容器 -->
            <!-- justify-content-center: 水平居中对齐内容 -->
            <div class="collapse navbar-collapse justify-content-center">
                <!-- navbar-nav: 导航项目列表容器 -->
                <!-- gap-1: 项目之间的间距（Bootstrap 间距工具类） -->
                <ul class="navbar-nav gap-1">
                    <!-- nav-item: 导航项容器 -->
                    <!-- nav-link: 导航链接样式 -->
                    <!-- active: 当前激活状态 -->
                    <li class="nav-item"><a class="nav-link active" href="<?php echo APP_BASE ?>/index/index"><i class="bi bi-house-door me-1"></i>首页</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo APP_BASE ?>/index/category"><i class="bi bi-grid me-1"></i>全部分类</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo APP_BASE ?>/index/goods_list"><i class="bi bi-stars me-1"></i>精选商品</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo APP_BASE ?>/index/cart"><i class="bi bi-cart3 me-1"></i>购物车</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo APP_BASE ?>/index/user"><i class="bi bi-person me-1"></i>个人中心</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo APP_BASE ?>/index/help"><i class="bi bi-question-circle me-1"></i>帮助中心</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ========== Bootstrap Offcanvas 组件（移动端侧边栏） ========== -->
    <!-- offcanvas: 侧边滑出面板组件 -->
    <!-- offcanvas-start: 从左侧滑出（可选 offcanvas-end 从右侧） -->
    <!-- tabindex="-1": 防止页面焦点进入未打开的 offcanvas -->
    <div class="offcanvas offcanvas-start bs-offcanvas" tabindex="-1" id="mobileNav">
        <!-- offcanvas-header: offcanvas 的头部区域 -->
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"><i class="bi bi-list me-2"></i>导航菜单</h5>
            <!-- btn-close: Bootstrap 关闭按钮 -->
            <!-- data-bs-dismiss="offcanvas": 点击关闭 offcanvas -->
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <!-- offcanvas-body: offcanvas 的内容区域 -->
        <div class="offcanvas-body">
            <!-- list-group: 列表组组件 -->
            <!-- list-group-item: 列表项 -->
            <!-- active: 当前选中项 -->
            <div class="list-group bs-list-group">
                <a href="<?php echo APP_BASE ?>/index/index" class="list-group-item active"><i class="bi bi-house-door me-2"></i>首页</a>
                <a href="<?php echo APP_BASE ?>/index/category" class="list-group-item"><i class="bi bi-grid me-2"></i>全部分类</a>
                <a href="<?php echo APP_BASE ?>/index/goods_list" class="list-group-item"><i class="bi bi-stars me-2"></i>精选商品</a>
                <a href="<?php echo APP_BASE ?>/index/cart" class="list-group-item"><i class="bi bi-cart3 me-2"></i>购物车</a>
                <a href="<?php echo APP_BASE ?>/index/user" class="list-group-item"><i class="bi bi-person me-2"></i>个人中心</a>
                <a href="<?php echo APP_BASE ?>/index/help" class="list-group-item"><i class="bi bi-question-circle me-2"></i>帮助中心</a>
            </div>
        </div>
    </div>

    <!-- ========== 限时秒杀专区 ========== -->
    <?php if (!empty($flashSales)): ?>
    <div class="main-content" style="margin-top: 20px;">
        <div class="flash-sale-section">
            <div class="flash-sale-header">
                <div class="flash-sale-title">
                    <span class="flash-icon"><i class="bi bi-lightning-charge-fill"></i></span>
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
    <div class="main-content" style="margin-top: 20px;">
        <!-- ========== Bootstrap Grid 栅格系统 ========== -->
        <!-- row: 行容器，所有 col 必须放在 row 内 -->
        <!-- g-4: 列之间的间距（gap-4），单位是 rem -->
        <div class="row g-4">
            <!-- ========== 左侧分类导航 ========== -->
            <!-- col-lg-2: 在 lg (≥1200px) 屏幕占 2/12 宽度 -->
            <!-- col-md-12: 在 md (≥768px) 屏幕占 12/12 宽度（整行） -->
            <!-- Bootstrap 响应式断点: xs(<576px) sm(≥576px) md(≥768px) lg(≥992px) xl(≥1200px) xxl(≥1400px) -->
            <div class="col-lg-2 col-md-12">
                <!-- rounded-2xl: 超大圆角（Bootstrap 圆角工具类） -->
                <!-- p-0: 内边距为0 -->
                <!-- overflow-hidden: 隐藏溢出内容 -->
                <div class="glass-card rounded-2xl p-0 overflow-hidden">
                    <div class="bg-gradient-blue px-4 py-3">
                        <!-- d-flex: 弹性布局（display: flex） -->
                        <!-- align-items-center: 垂直居中对齐 -->
                        <!-- gap-2: 元素之间间距 -->
                        <div class="d-flex align-items-center gap-2 text-white">
                            <i class="bi bi-folder2-open"></i>
                            <span class="font-bold">全部分类</span>
                        </div>
                    </div>
                    <!-- list-group: 列表组 -->
                    <!-- list-group-flush: 移除列表组边框，与父容器边缘对齐 -->
                    <ul class="list-group list-group-flush">
                        <?php foreach ($categoryList as $cat): ?>
                            <!-- list-group-item: 列表项 -->
                            <!-- border-0: 无边框 -->
                            <!-- border-bottom: 底部边框 -->
                            <!-- border-dashed: 虚线边框 -->
                            <!-- hover:bg-blue-50/50: 悬停时背景色（自定义） -->
                            <!-- transition-colors: 颜色过渡动画 -->
                            <li class="list-group-item border-0 border-bottom border-dashed border-gray-100 hover:bg-blue-50/50 transition-colors">
                                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $cat['cat_id'] ?>" class="d-flex align-items-center gap-2 text-dark hover:text-primary-light w-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-light"></span>
                                    <span class="text-sm"><?= htmlspecialchars($cat['cat_name']) ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- ========== 中间主Banner（轮播） ========== -->
            <!-- col-lg-7: lg屏幕占7/12 -->
            <!-- col-md-8: md屏幕占8/12 -->
            <div class="col-lg-7 col-md-8">
                <!-- ========== Bootstrap Carousel 轮播组件 ========== -->
                <!-- carousel: 轮播容器 -->
                <!-- slide: 滑动过渡效果 -->
                <!-- carousel-fade: 淡入淡出过渡效果 -->
                <!-- data-bs-ride="carousel": 自动播放 -->
                <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <!-- carousel-inner: 轮播内容容器 -->
                    <div class="carousel-inner rounded-2xl overflow-hidden shadow-lg">
                        <?php if (!empty($bannerList)): ?>
                            <?php foreach ($bannerList as $key => $banner): ?>
                                <!-- carousel-item: 轮播项 -->
                                <!-- active: 当前激活项（必须有一个） -->
                                <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                                    <a href="<?= htmlspecialchars($banner['banner_url']) ?>">
                                        <!-- d-block: 块级元素 -->
                                        <!-- w-100: 宽度100% -->
                                        <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($banner['banner_img']) ?>" 
                                             class="d-block w-100" 
                                             style="height: 400px; object-fit: cover;"
                                             alt="<?= htmlspecialchars($banner['banner_title']) ?>">
                                    </a>
                                    <!-- carousel-caption: 轮播文字说明 -->
                                    <!-- d-none: 默认隐藏 -->
                                    <!-- d-md-block: md屏幕以上显示 -->
                                    <div class="carousel-caption d-none d-md-block text-left" style="bottom: 30px; left: 30px; right: auto;">
                                        <h2 class="text-white text-3xl font-extrabold mb-2 text-shadow-lg"><?= htmlspecialchars($banner['banner_title']) ?></h2>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="carousel-item active">
                                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=1">
                                    <img src="<?php echo APP_BASE ?>/resources/images/banner/banner1.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="banner1">
                                </a>
                                <div class="carousel-caption d-none d-md-block text-left" style="bottom: 30px; left: 30px; right: auto;">
                                    <h2 class="text-white text-3xl font-extrabold mb-2 text-shadow-lg">数码好物 限时特惠</h2>
                                    <p class="text-white/90">全场低价，正品保障，全国包邮</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=2">
                                    <img src="<?php echo APP_BASE ?>/resources/images/banner/banner2.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="banner2">
                                </a>
                                <div class="carousel-caption d-none d-md-block text-left" style="bottom: 30px; left: 30px; right: auto;">
                                    <h2 class="text-white text-3xl font-extrabold mb-2 text-shadow-lg">美妆护肤 新品上市</h2>
                                    <p class="text-white/90">大牌美妆，品质保障，放心购买</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=3">
                                    <img src="<?php echo APP_BASE ?>/resources/images/banner/banner3.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="banner3">
                                </a>
                                <div class="carousel-caption d-none d-md-block text-left" style="bottom: 30px; left: 30px; right: auto;">
                                    <h2 class="text-white text-3xl font-extrabold mb-2 text-shadow-lg">生活百货 应有尽有</h2>
                                    <p class="text-white/90">品质生活，从这里开始，全场满减</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- carousel-control-prev: 上一张按钮 -->
                    <!-- data-bs-target="#mainCarousel": 指定控制的轮播 ID -->
                    <!-- data-bs-slide="prev": 点击切换到上一张 -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-black/30 rounded-full p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <!-- carousel-control-next: 下一张按钮 -->
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-black/30 rounded-full p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    <!-- carousel-indicators: 轮播指示器（小圆点） -->
                    <div class="carousel-indicators" style="bottom: 15px;">
                        <?php if (!empty($bannerList)): ?>
                            <?php foreach ($bannerList as $key => $banner): ?>
                                <!-- data-bs-slide-to="<?= $key ?>": 点击切换到指定索引 -->
                                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="<?= $key ?>" <?= $key == 0 ? 'class="active"' : '' ?> class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors"></button>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active w-3 h-3 rounded-full bg-white/50 hover:bg-white"></button>
                            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white"></button>
                            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white"></button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- ========== 右侧小Banner ========== -->
            <!-- col-lg-3: lg屏幕占3/12 -->
            <!-- col-md-4: md屏幕占4/12 -->
            <div class="col-lg-3 col-md-4">
                <!-- flex-column: 垂直方向排列（flex-direction: column） -->
                <!-- gap-3: 元素间距 -->
                <!-- h-full: 高度100% -->
                <div class="d-flex flex-column gap-3 h-full">
                    <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=1" class="glass-card rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="<?php echo APP_BASE ?>/resources/images/banner/banner-phone.jpg" class="w-full" style="height: 95px; object-fit: cover;" alt="banner-phone">
                    </a>
                    <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=6" class="glass-card rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="<?php echo APP_BASE ?>/resources/images/banner/banner-tools.jpg" class="w-full" style="height: 95px; object-fit: cover;" alt="banner-tools">
                    </a>
                    <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=3" class="glass-card rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="<?php echo APP_BASE ?>/resources/images/banner/banner-lifetools.jpg" class="w-full" style="height: 95px; object-fit: cover;" alt="banner-lifetools">
                    </a>
                    <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=2" class="glass-card rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="<?php echo APP_BASE ?>/resources/images/banner/banner-meizhuang.jpg" class="w-full" style="height: 95px; object-fit: cover;" alt="banner-meizhuang">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== 热销排行榜 ========== -->
    <?php if (!empty($hotRanking)): ?>
    <div class="main-content" style="margin-top: 20px;">
        <div class="bg-gradient-blue rounded-2xl p-4">
            <!-- justify-content-between: 两端对齐 -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2 text-white">
                    <i class="bi bi-trophy-fill text-xl"></i>
                    <h3 class="font-bold text-lg">热销排行榜</h3>
                </div>
                <a href="<?php echo APP_BASE ?>/index/goods_list?sort=sales" class="text-white/80 hover:text-white text-sm">查看更多 <i class="bi bi-arrow-right"></i></a>
            </div>
            <!-- ========== Bootstrap row-cols 响应式列数 ========== -->
            <!-- row-cols-1: 默认1列 -->
            <!-- row-cols-md-2: md屏幕以上2列 -->
            <!-- row-cols-lg-5: lg屏幕以上5列 -->
            <!-- g-3: 间距 -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-3">
                <?php foreach ($hotRanking as $index => $item): $rank = $index + 1; ?>
                    <!-- col: 必须添加，配合 row-cols 使用 -->
                    <!-- flex: 弹性布局 -->
                    <!-- flex-col: 垂直排列 -->
                    <!-- items-center: 水平居中 -->
                    <!-- text-center: 文字居中 -->
                    <a href="<?php echo APP_BASE ?>/index/goods_detail?id=<?= $item['goods_id'] ?>" class="col glass-card rounded-xl p-3 flex flex-col items-center text-center hover:shadow-lg transition-all hover:-translate-y-1">
                        <span class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold mb-2" 
                              style="background: <?= $rank == 1 ? 'linear-gradient(135deg, #f59e0b, #dc2626)' : ($rank == 2 ? 'linear-gradient(135deg, #64748b, #475569)' : ($rank == 3 ? 'linear-gradient(135deg, #b45309, #92400e)' : 'var(--primary-light)')) ?>">
                            <?= $rank ?>
                        </span>
                        <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($item['goods_img'] ?? 'default.jpg') ?>"
                             onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                             alt="<?= htmlspecialchars($item['goods_name']) ?>"
                             class="w-16 h-16 rounded-xl object-cover bg-gray-100 mb-2">
                        <div class="flex-1 min-w-0">
                            <!-- line-clamp-1: 单行省略（自定义样式） -->
                            <div class="text-dark font-medium text-sm line-clamp-1"><?= htmlspecialchars($item['goods_name']) ?></div>
                            <div class="text-danger font-bold mt-1">¥<?= number_format($item['goods_price'], 2) ?></div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ========== 热门商品 ========== -->
    <div class="main-content" style="margin-top: 20px;">
        <!-- border-bottom: 底部边框 -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-gray-200">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-fire text-lg text-orange-500"></i>
                <h3 class="font-bold text-xl text-dark">热门商品</h3>
            </div>
            <a href="<?php echo APP_BASE ?>/index/goods_list" class="text-gray-500 hover:text-primary-light text-sm">查看更多 <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row g-4">
            <?php if (!empty($randomGoods)): ?>
                <?php foreach ($randomGoods as $goods): ?>
                    <!-- col-lg-2: lg屏幕2/12 -->
                    <!-- col-md-3: md屏幕3/12 -->
                    <!-- col-sm-4: sm屏幕4/12 -->
                    <!-- col-xs-6: xs屏幕6/12（2列） -->
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <div class="product-card card-lift rounded-2xl overflow-hidden">
                            <div class="relative">
                                <!-- aspect-square: 宽高比1:1（自定义样式） -->
                                <div class="aspect-square bg-gray-100 overflow-hidden">
                                    <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($goods['goods_img'] ?? 'default.jpg') ?>"
                                         onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                         alt="<?= htmlspecialchars($goods['goods_name']) ?>"
                                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                </div>
                                <?php if ($goods['is_hot']): ?>
                                    <!-- ========== Bootstrap Badge 徽章组件 ========== -->
                                    <!-- badge: 徽章 -->
                                    <!-- bg-gradient-blue: 自定义渐变背景 -->
                                    <!-- text-xs: 超小字体 -->
                                    <!-- font-bold: 粗体 -->
                                    <!-- px-2: 水平内边距 -->
                                    <!-- py-1: 垂直内边距 -->
                                    <span class="absolute top-2 left-2 badge bg-gradient-blue text-white text-xs font-bold px-2 py-1 rounded-lg">HOT</span>
                                <?php endif; ?>
                            </div>
                            <div class="p-3">
                                <!-- line-clamp-2: 两行省略 -->
                                <h4 class="font-medium text-dark text-sm line-clamp-2 mb-2 hover:text-primary-light transition-colors"><?= htmlspecialchars($goods['goods_name']) ?></h4>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-danger font-bold text-lg">¥<?= number_format($goods['goods_price'], 2) ?></span>
                                    <?php if (!empty($goods['sales'])): ?>
                                        <span class="text-gray-400 text-xs">已售<?= $goods['sales'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <!-- ========== Bootstrap Button 按钮组件 ========== -->
                                <!-- btn: 按钮基础类 -->
                                <!-- btn-gradient-primary: 自定义渐变按钮 -->
                                <!-- w-full: 宽度100% -->
                                <!-- mt-3: 上边距 -->
                                <!-- text-sm: 小字体 -->
                                <!-- py-2: 垂直内边距 -->
                                <button class="btn btn-gradient-primary w-full mt-3 text-sm py-2" data-goods-id="<?= $goods['goods_id'] ?>"><i class="bi bi-eye me-1"></i>查看详情</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="product-card card-lift rounded-2xl overflow-hidden">
                        <div class="relative">
                            <div class="aspect-square bg-gray-100 overflow-hidden">
                                <img src="<?php echo APP_BASE ?>/resources/images/goods/goods1.jpg"
                                     onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                     alt="示例商品"
                                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                            </div>
                            <span class="absolute top-2 left-2 badge bg-gradient-blue text-white text-xs font-bold px-2 py-1 rounded-lg">HOT</span>
                        </div>
                        <div class="p-3">
                            <h4 class="font-medium text-dark text-sm line-clamp-2 mb-2">示例商品1</h4>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-danger font-bold text-lg">¥99.00</span>
                            </div>
                            <button class="btn btn-gradient-primary w-full mt-3 text-sm py-2" data-goods-id="1"><i class="bi bi-eye me-1"></i>查看详情</button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ========== 最近浏览 ========== -->
    <?php if (!empty($recentlyViewed)): ?>
    <div class="main-content" style="margin-top: 20px;">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-gray-200">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-lg text-blue-500"></i>
                <h3 class="font-bold text-xl text-dark">最近浏览</h3>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($recentlyViewed as $item): ?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                    <a href="<?php echo APP_BASE ?>/index/goods_detail?id=<?= $item['goods_id'] ?>" class="product-card card-lift rounded-2xl overflow-hidden block">
                        <div class="relative">
                            <div class="aspect-square bg-gray-100 overflow-hidden">
                                <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($item['goods_img'] ?? 'default.jpg') ?>"
                                     onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                     alt="<?= htmlspecialchars($item['goods_name']) ?>"
                                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                            </div>
                            <?php if ($item['is_hot']): ?>
                                <span class="absolute top-2 left-2 badge bg-gradient-blue text-white text-xs font-bold px-2 py-1 rounded-lg">HOT</span>
                            <?php endif; ?>
                        </div>
                        <div class="p-3">
                            <h4 class="font-medium text-dark text-sm line-clamp-2 mb-2 hover:text-primary-light transition-colors"><?= htmlspecialchars($item['goods_name']) ?></h4>
                            <span class="text-danger font-bold text-lg">¥<?= number_format($item['goods_price'], 2) ?></span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ========== 猜你喜欢 ========== -->
    <div class="main-content" style="margin-top: 20px;">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-gray-200">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-lightbulb text-lg text-yellow-500"></i>
                <h3 class="font-bold text-xl text-dark">猜你喜欢</h3>
            </div>
            <a href="<?php echo APP_BASE ?>/index/goods_list" class="text-gray-500 hover:text-primary-light text-sm">查看更多 <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row g-4" id="recommend-goods">
            <div class="col-12 text-center text-gray-400 py-10">正在为您推荐商品...</div>
        </div>
    </div>

    <!-- 页脚 -->
    <div class="footer">
        <p>热卖商城 ©2026 版权所有 | 客服热线：400-123-4567 | 地址：线上电商产业园</p>
    </div>

    <!-- 主题切换按钮 -->
    <button class="theme-toggle" id="theme-toggle" title="切换深色/浅色模式"><i class="bi bi-moon-stars" id="theme-icon"></i></button>

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
    <div class="back-top"><i class="bi bi-arrow-up"></i></div>
    <div class="toast" id="toast"></div>

    <!-- 引入 Bootstrap JavaScript（包含 Popper.js） -->
    <!-- bootstrap.bundle.min.js: 包含所有 Bootstrap JS 组件 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Bootstrap Tooltip 初始化 -->
    <script>
        // 等待 DOM 加载完成后初始化
        document.addEventListener('DOMContentLoaded', function() {
            // 获取所有带有 data-bs-toggle="tooltip" 属性的元素
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            // 遍历并创建 Tooltip 实例
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    
    <!-- 主题切换 -->
    <script>
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
    </script>

    <!-- 页面加载动画 -->
    <script>
        const loader = document.querySelector('.loader');
        const mainBoxes = document.querySelectorAll('.main-content');
        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.add('hide');
                mainBoxes.forEach(box => box.classList.add('show'));
            }, 800);
        });
    </script>

    <script>
        function showToast(text) {
            const toast = document.getElementById('toast');
            toast.textContent = text;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2000);
        }

        document.querySelectorAll('.btn[data-goods-id]').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-goods-id');
                window.location.href = '<?php echo APP_BASE ?>/index/goods_detail?id=' + id;
            });
        });

        /* 倒计时功能 */
        (function() {
            const endTime = new Date("2024-12-31 23:59:59").getTime();
            function updateTimer() {
                const now = new Date().getTime();
                const diff = endTime - now;
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

        /* 猜你喜欢加载 */
        (function() {
            const recommendContainer = document.getElementById('recommend-goods');
            if (!recommendContainer) return;

            setTimeout(() => {
                fetch('<?php echo APP_BASE ?>/index/getRecommend')
                    .then(res => res.json())
                    .then(data => {
                        if (data.code === 200 && data.data && data.data.length > 0) {
                            let html = '';
                            data.data.forEach(goods => {
                                html += `
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                        <div class="product-card card-lift rounded-2xl overflow-hidden">
                                            <div class="relative">
                                                <div class="aspect-square bg-gray-100 overflow-hidden">
                                                    <img src="${'<?php echo APP_BASE ?>/resources/images/'}${goods.goods_img || 'default.jpg'}" 
                                                         onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                                         alt="${goods.goods_name}"
                                                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                                </div>
                                            </div>
                                            <div class="p-3">
                                                <h4 class="font-medium text-dark text-sm line-clamp-2 mb-2 hover:text-primary-light transition-colors">${goods.goods_name}</h4>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="text-danger font-bold text-lg">¥${parseFloat(goods.goods_price).toFixed(2)}</span>
                                                </div>
                                                <button class="btn btn-gradient-primary w-full mt-3 text-sm py-2" data-goods-id="${goods.goods_id}"><i class="bi bi-eye me-1"></i>查看详情</button>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                            recommendContainer.innerHTML = html;
                            
                            document.querySelectorAll('.btn[data-goods-id]').forEach(btn => {
                                btn.addEventListener('click', () => {
                                    window.location.href = '<?php echo APP_BASE ?>/index/goods_detail?id=' + btn.getAttribute('data-goods-id');
                                });
                            });
                        } else {
                            recommendContainer.innerHTML = '<div class="col-12 text-center text-gray-400 py-10">暂无推荐商品</div>';
                        }
                    })
                    .catch(err => {
                        console.error('加载推荐商品失败', err);
                        recommendContainer.innerHTML = '<div class="col-12 text-center text-gray-400 py-10">加载推荐失败</div>';
                    });
            }, 500);
        })();

        /* ========== 图片懒加载 ========== */
        (function() {
            const lazyImages = document.querySelectorAll('img[data-src]');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.onload = () => {
                            img.classList.remove('lazy');
                        };
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px',
                threshold: 0.01
            });

            lazyImages.forEach(img => {
                imageObserver.observe(img);
            });
        })();

        /* ========== 平滑滚动到锚点 ========== */
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                const target = document.querySelector(targetId);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        /* ========== 导航栏滚动效果 ========== */
        (function() {
            const navbar = document.querySelector('.bs-navbar');
            window.addEventListener('scroll', () => {
                if (document.documentElement.scrollTop > 50) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });
        })();

        /* ========== 商品卡片悬浮效果 ========== */
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });

        /* ========== 搜索框聚焦效果 ========== */
        const searchInput = document.querySelector('.search-input');
        const searchBox = document.querySelector('.search-box');
        if (searchInput && searchBox) {
            searchInput.addEventListener('focus', () => {
                searchBox.classList.add('focused');
            });
            searchInput.addEventListener('blur', () => {
                searchBox.classList.remove('focused');
            });
        }
    </script>
</body>

</html>