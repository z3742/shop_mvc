<?php
// 确保变量有默认值，避免Undefined variable错误
$categoryList = isset($categoryList) ? $categoryList : [];
$category = isset($category) ? $category : ['cat_name' => '全部商品'];
$total = isset($total) ? $total : 0;
$goodsList = isset($goodsList) ? $goodsList : [];
$totalPages = isset($totalPages) ? $totalPages : 1;
$page = isset($page) ? $page : 1;
$catId = isset($catId) ? $catId : 0;
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品列表 - 热卖商城</title>
    <link rel="stylesheet" href="<?php echo APP_BASE ?>/resources/css/style.css">
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
                <button type="submit" class="search-btn">搜索</button>
            </form>
            <div class="head-cart" id="head-cart">购物车<span class="cart-num" id="cart-num">0</span></div>
        </div>
    </div>

    <div class="nav">
        <div class="nav-inner">
            <ul class="nav-list">
                <li><a href="<?php echo APP_BASE ?>/index/index">首页</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/category">全部分类</a></li>
                <li class="active"><a href="<?php echo APP_BASE ?>/index/goods_list">精选商品</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/cart">购物车</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/user">个人中心</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/help">帮助中心</a></li>
            </ul>
        </div>
    </div>

    <div class="main-layout main-content">
        <div class="sidebar-left">
            <h3 class="sidebar-title">🛍️ 全部分类</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">全部商品</a></li>
                <?php foreach ($categoryList as $cat): ?>
                    <li><a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $cat['cat_id'] ?>"><?= htmlspecialchars($cat['cat_name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
            <h3 class="sidebar-title" style="margin-top:20px;">🎧 客户服务</h3>
            <ul class="sidebar-list">
                <li><a href="#">在线人工客服</a></li>
                <li><a href="#">物流订单查询</a></li>
            </ul>
        </div>

        <div class="content-middle">
            <div class="goods-header">
                <div class="goods-title">
                    <span class="title-icon">🎁</span>
                    <span><?= htmlspecialchars($category['cat_name'] ?? '全部商品') ?></span>
                </div>
                <span style="color:#999;font-size:14px;">共 <?= $total ?> 件商品</span>
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
                                </div>
                            </div>
                        </a>
                        <a href="<?php echo APP_BASE ?>/index/goods_detail?id=<?= $goods['goods_id'] ?>" class="view-detail-btn">查看详情</a>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ($totalPages > 1): ?>
                <div class="page-box">
                    <?php if ($page > 1): ?>
                        <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $catId ?>&page=<?= $page - 1 ?>">上一页</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $catId ?>&page=<?= $i ?>" <?= $i == $page ? 'class="active"' : '' ?>><?= $i ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $catId ?>&page=<?= $page + 1 ?>">下一页</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="sidebar-right">
            <h3 class="sidebar-title">🔥 热门推荐</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">人气单品</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">限时特惠</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">新品上架</a></li>
            </ul>
            <h3 class="sidebar-title" style="margin-top:20px;">👤 个人中心</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/user">我的订单</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/user">我的收藏</a></li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>热卖商城 &copy;2026 版权所有 | 客服热线：00-123-4567 | 地址：线上电商产业园</p>
    </div>
    <div class="back-top">↑</div>
    <div class="toast" id="toast"></div>

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
                    if (cartId) {
                        deleteCartItem(cartId);
                    }
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
                .then(r => r.json())
                .then(data => {
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