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
                <button type="submit" class="search-btn"><i class="bi bi-search me-1"></i>搜索</button>
            </form>
            <div class="head-cart" id="head-cart" data-bs-toggle="tooltip" data-bs-placement="bottom" title="点击查看购物车">
                <i class="bi bi-cart3 me-1"></i>购物车<span class="cart-num" id="cart-num"><?= $cartCount ?></span>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg bs-navbar sticky-top">
        <div class="container-fluid" style="max-width:1600px;">
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav" aria-controls="mobileNav">
                <i class="bi bi-list fs-4" style="color:var(--text-primary);"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav gap-1">
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

    <!-- 移动端导航 Offcanvas -->
    <div class="offcanvas offcanvas-start bs-offcanvas" tabindex="-1" id="mobileNav">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"><i class="bi bi-list me-2"></i>导航菜单</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
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
        <div class="row g-4">
            <!-- 左侧分类导航 -->
            <div class="col-lg-2 col-md-12">
                <div class="glass-card rounded-2xl p-0 overflow-hidden">
                    <div class="bg-gradient-blue px-4 py-3">
                        <div class="d-flex align-items-center gap-2 text-white">
                            <i class="bi bi-folder2-open"></i>
                            <span class="font-bold">全部分类</span>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($categoryList as $cat): ?>
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

            <!-- 中间主Banner -->
            <div class="col-lg-7 col-md-8">
                <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-2xl overflow-hidden shadow-lg">
                        <?php if (!empty($bannerList)): ?>
                            <?php foreach ($bannerList as $key => $banner): ?>
                                <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                                    <a href="<?= htmlspecialchars($banner['banner_url']) ?>">
                                        <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($banner['banner_img']) ?>" 
                                             class="d-block w-100" 
                                             style="height: 400px; object-fit: cover;"
                                             alt="<?= htmlspecialchars($banner['banner_title']) ?>">
                                    </a>
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
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-black/30 rounded-full p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-black/30 rounded-full p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    <div class="carousel-indicators" style="bottom: 15px;">
                        <?php if (!empty($bannerList)): ?>
                            <?php foreach ($bannerList as $key => $banner): ?>
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

            <!-- 右侧小Banner -->
            <div class="col-lg-3 col-md-4">
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2 text-white">
                    <i class="bi bi-trophy-fill text-xl"></i>
                    <h3 class="font-bold text-lg">热销排行榜</h3>
                </div>
                <a href="<?php echo APP_BASE ?>/index/goods_list?sort=sales" class="text-white/80 hover:text-white text-sm">查看更多 <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-3">
                <?php foreach ($hotRanking as $index => $item): $rank = $index + 1; ?>
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
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <div class="product-card card-lift rounded-2xl overflow-hidden">
                            <div class="relative">
                                <div class="aspect-square bg-gray-100 overflow-hidden">
                                    <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($goods['goods_img'] ?? 'default.jpg') ?>"
                                         onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                         alt="<?= htmlspecialchars($goods['goods_name']) ?>"
                                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                </div>
                                <?php if ($goods['is_hot']): ?>
                                    <span class="absolute top-2 left-2 badge bg-gradient-blue text-white text-xs font-bold px-2 py-1 rounded-lg">HOT</span>
                                <?php endif; ?>
                            </div>
                            <div class="p-3">
                                <h4 class="font-medium text-dark text-sm line-clamp-2 mb-2 hover:text-primary-light transition-colors"><?= htmlspecialchars($goods['goods_name']) ?></h4>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-danger font-bold text-lg">¥<?= number_format($goods['goods_price'], 2) ?></span>
                                    <?php if (!empty($goods['sales'])): ?>
                                        <span class="text-gray-400 text-xs">已售<?= $goods['sales'] ?></span>
                                    <?php endif; ?>
                                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 初始化 Bootstrap Tooltip
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <script>
        /* ========== 主题切换 ========== */
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
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                    <div class="product-card card-lift rounded-2xl overflow-hidden">
                                        <div class="relative">
                                            <div class="aspect-square bg-gray-100 overflow-hidden">
                                                <img src="<?php echo APP_BASE ?>/resources/images/${item.goods_img || 'default.jpg'}"
                                                     onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                                     alt="${item.goods_name}"
                                                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                            </div>
                                            <span class="absolute top-2 left-2 badge bg-gradient-blue text-white text-xs font-bold px-2 py-1 rounded-lg">HOT</span>
                                        </div>
                                        <div class="p-3">
                                            <h4 class="font-medium text-dark text-sm line-clamp-2 mb-2 hover:text-primary-light transition-colors">${item.goods_name}</h4>
                                            <span class="text-danger font-bold text-lg">¥${parseFloat(item.goods_price).toFixed(2)}</span>
                                            <button class="btn btn-gradient-primary w-full mt-3 text-sm py-2" data-goods-id="${item.goods_id}"><i class="bi bi-eye me-1"></i>查看详情</button>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        document.getElementById('recommend-goods').innerHTML = html;
                        document.querySelectorAll('.btn[data-goods-id]').forEach(btn => {
                            btn.addEventListener('click', () => {
                                window.location.href = '<?php echo APP_BASE ?>/index/goods_detail?id=' + btn.dataset.goodsId;
                            });
                        });
                    } else {
                        document.getElementById('recommend-goods').innerHTML = '<div class="col-12 text-center text-gray-400 py-10">暂无推荐商品</div>';
                    }
                })
                .catch(err => {
                    console.error('加载推荐商品失败', err);
                    document.getElementById('recommend-goods').innerHTML = '<div class="col-12 text-center text-gray-400 py-10">加载推荐失败</div>';
                });
        }

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