<?php
$goods = isset($goods) ? $goods : [];
$categoryList = isset($categoryList) ? $categoryList : [];
$category = isset($category) ? $category : [];
$isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1;
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($goods['goods_name']) ?> - 热卖商城</title>
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
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">精选商品</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/cart">购物车</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/user">个人中心</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/help">帮助中心</a></li>
            </ul>
        </div>
    </div>

    <div class="main-layout main-content">
        <div class="sidebar-left">
            <h3 class="sidebar-title">🛍️ 相关分类</h3>
            <ul class="sidebar-list">
                <?php foreach ($categoryList as $cat): ?>
                    <li><a href="<?php echo APP_BASE ?>/index/goods_list?cat_id=<?= $cat['cat_id'] ?>"><?= htmlspecialchars($cat['cat_name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
            <h3 class="sidebar-title" style="margin-top:20px;">🛡️ 购物须知</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/help">正品保证 全国联保</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/help">支持7天无理由退换</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/help">极速发货 售后保障</a></li>
            </ul>
        </div>

        <div class="content-middle">
            <div class="detail-main">
                <div class="detail-pic">
                    <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($goods['goods_img'] ?? 'default.jpg') ?>"
                        onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                        alt="<?= htmlspecialchars($goods['goods_name']) ?>">
                </div>
                <div class="detail-info">
                    <h2 class="detail-name"><?= htmlspecialchars($goods['goods_name']) ?></h2>
                    <div class="detail-price">¥ <?= number_format($goods['goods_price'], 2) ?></div>
                    <div class="detail-params">
                        <p>库存：<?= $goods['stock'] ?> 件</p>
                        <p>分类：<?= htmlspecialchars($category['cat_name'] ?? '未知') ?></p>
                        <p>规格：全国包邮 · 次日达</p>
                    </div>
                    <div class="detail-operate" style="margin-top:15px;">
                        <div class="detail-num">
                            <button class="num-minus">-</button>
                            <input type="text" value="1" class="num-input" id="buy-num">
                            <button class="num-plus">+</button>
                        </div>
                        <button class="detail-btn add-cart" style="margin-top:15px;" data-goods-id="<?= $goods['goods_id'] ?>">加入购物车</button>
                        <button class="detail-btn buy" style="margin-top:15px;" data-goods-id="<?= $goods['goods_id'] ?>">立即购买</button>
                        <?php if ($isAdmin): ?>
                        <button class="detail-btn delete-goods" style="margin-top:15px;background:#d9534f;" data-goods-id="<?= $goods['goods_id'] ?>">删除商品</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div style="margin-top:20px;line-height:2;">
                <h3 class="goods-title">商品介绍</h3>
                <p><?= htmlspecialchars($goods['goods_desc'] ?? '暂无详细介绍') ?></p>
            </div>
        </div>

        <div class="sidebar-right">
            <h3 class="sidebar-title">💡 猜你喜欢</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">主板专用保护膜</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">手机支架</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">高清钢化膜</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">防尘防灰网罩</a></li>
            </ul>
            <h3 class="sidebar-title" style="margin-top:20px;">🎁 专属优惠券</h3>
            <ul class="sidebar-list">
                <li><a href="#">数码品类满200减20</a></li>
                <li><a href="#">单品直降优惠券</a></li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>热卖商城 &copy;2026 版权所有 | 客服热线：00-123-4567 | 地址：线上电商产业园</p>
    </div>

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
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200) {
                        document.querySelectorAll('.cart-count, .cart-num').forEach(el => {
                            el.innerText = data.cart_count;
                        });
                    }
                });
        }

        const minus = document.querySelector('.num-minus');
        const plus = document.querySelector('.num-plus');
        const input = document.getElementById('buy-num');
        if (minus && plus && input) {
            minus.addEventListener('click', () => {
                let val = parseInt(input.value);
                if (val > 1) input.value = val - 1;
            });
            plus.addEventListener('click', () => {
                input.value = parseInt(input.value) + 1;
            });
        }

        const addCartBtn = document.querySelector('.add-cart');
        if (addCartBtn) {
            addCartBtn.addEventListener('click', () => {
                const goodsId = addCartBtn.dataset.goodsId;
                const num = parseInt(input.value);

                addCartBtn.disabled = true;
                const originalText = addCartBtn.innerText;
                addCartBtn.innerText = '添加中...';

                fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'goods_id=' + goodsId + '&num=' + num
                    })
                    .then(r => {
                        if (!r.ok) {
                            throw new Error('HTTP错误: ' + r.status);
                        }
                        return r.text();
                    })
                    .then(text => {
                        console.log('API响应:', text);
                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch (e) {
                            throw new Error('响应不是有效的JSON: ' + text);
                        }

                        if (data.code === 200) {
                            document.querySelectorAll('.cart-count, .cart-num').forEach(el => {
                                el.innerText = data.cart_count;
                            });
                            showToast('成功加入购物车');
                        } else if (data.code === 401) {
                            showToast('请先登录');
                            setTimeout(() => location.href = '<?php echo APP_BASE ?>/index/login', 1000);
                        } else {
                            showToast(data.msg || '加入购物车失败');
                        }
                    })
                    .catch(err => {
                        console.error('添加购物车错误', err);
                        showToast('网络连接错误，请稍后重试');
                    })
                    .finally(() => {
                        addCartBtn.disabled = false;
                        addCartBtn.innerText = originalText;
                    });
            });
        }

        const buyBtn = document.querySelector('.buy');
        if (buyBtn) {
            buyBtn.addEventListener('click', async () => {
                const goodsId = buyBtn.dataset.goodsId || document.querySelector('.add-cart')?.dataset.goodsId;
                const num = parseInt(input.value);

                if (!goodsId) {
                    showToast('商品信息获取失败');
                    return;
                }

                try {
                    const response = await fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'goods_id=' + goodsId + '&num=' + num
                    });

                    const text = await response.text();
                    console.log('API响应:', text);
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        throw new Error('响应不是有效的JSON: ' + text);
                    }

                    if (data.code === 200) {
                        document.querySelectorAll('.cart-count, .cart-num').forEach(el => {
                            el.innerText = data.cart_count;
                        });
                        showToast('已成功加入购物车，正在跳转...');
                        setTimeout(() => location.href = '<?php echo APP_BASE ?>/index/cart', 800);
                    } else if (data.code === 401) {
                        showToast('请先登录');
                        setTimeout(() => location.href = '<?php echo APP_BASE ?>/index/login', 1000);
                    } else {
                        showToast(data.msg || '操作失败');
                    }
                } catch (err) {
                    console.error('立即购买错误:', err);
                    showToast('网络连接错误，请稍后重试');
                }
            });
        }

        const deleteGoodsBtn = document.querySelector('.delete-goods');
        if (deleteGoodsBtn) {
            deleteGoodsBtn.addEventListener('click', () => {
                if (!confirm('确定要删除该商品吗？')) {
                    return;
                }
                
                const goodsId = deleteGoodsBtn.dataset.goodsId;
                deleteGoodsBtn.disabled = true;
                deleteGoodsBtn.innerText = '删除中...';
                
                fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=goods/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
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
                        deleteGoodsBtn.innerText = '删除商品';
                    }
                })
                .catch(err => {
                    console.error('删除商品错误:', err);
                    showToast('网络连接错误');
                    deleteGoodsBtn.disabled = false;
                    deleteGoodsBtn.innerText = '删除商品';
                });
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
    </script>
</body>

</html>
