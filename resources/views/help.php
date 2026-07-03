<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>帮助中心 - 热卖商城</title>
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
                <li class="active"><a href="<?php echo APP_BASE ?>/index/help">帮助中心</a></li>
            </ul>
        </div>
    </div>

    <div class="main-layout main-content">
        <div class="sidebar-left">
            <h3 class="sidebar-title">🙋 帮助分类</h3>
            <ul class="sidebar-list">
                <li><a href="#">购物常见问题</a></li>
                <li><a href="#">配送方式说明</a></li>
                <li><a href="#">支付方式指引</a></li>
                <li><a href="#">售后服务政策</a></li>
                <li><a href="#">退换货流程</a></li>
                <li><a href="#">联系客服</a></li>
            </ul>
        </div>

        <div class="content-middle">
            <div class="goods-header">
                <div class="goods-title">
                    <span class="title-icon">❓</span>
                    <span>帮助中心</span>
                </div>
            </div>

            <div style="margin-top:20px;">
                <div style="margin-bottom:25px;">
                    <h3 style="font-size:16px;margin-bottom:10px;color:#333;">📦 购物问题</h3>
                    <div style="padding:10px;background:#fafafa;border-radius:6px;">
                        <p style="margin-bottom:8px;"><strong>Q: 如何成为会员？</strong></p>
                        <p style="color:#666;font-size:14px;margin-bottom:12px;">A: 注册成为热卖商城会员后，即可享受会员专属优惠和积分奖励。</p>

                        <p style="margin-bottom:8px;"><strong>Q: 如何查看商品库存？</strong></p>
                        <p style="color:#666;font-size:14px;margin-bottom:12px;">A: 商品详情页会显示实时库存，库存不足时我们会尽快补货。</p>

                        <p style="margin-bottom:8px;"><strong>Q: 如何取消订单？</strong></p>
                        <p style="color:#666;font-size:14px;">A: 进入"我的订单"找到对应订单点击"取消"即可。</p>
                    </div>
                </div>

                <div style="margin-bottom:25px;">
                    <h3 style="font-size:16px;margin-bottom:10px;color:#333;">🙋 配送与支付</h3>
                    <div style="padding:10px;background:#fafafa;border-radius:6px;">
                        <p style="margin-bottom:8px;"><strong>Q: 支付方式有哪些？</strong></p>
                        <p style="color:#666;font-size:14px;margin-bottom:12px;">A: 支持微信支付、支付宝、微信等多种支付方式。</p>

                        <p style="margin-bottom:8px;"><strong>Q: 配送范围是多长时间？</strong></p>
                        <p style="color:#666;font-size:14px;margin-bottom:12px;">A: 国内地区1-3个工作日配送，偏远地区3-7个工作日。</p>

                        <p style="margin-bottom:8px;"><strong>Q: 如何查看物流信息？</strong></p>
                        <p style="color:#666;font-size:14px;">A: 订单发货后，您可以在"我的订单"中查看实时物流跟踪。</p>
                    </div>
                </div>

                <div style="margin-bottom:25px;">
                    <h3 style="font-size:16px;margin-bottom:10px;color:#333;">🙋 售后服务</h3>
                    <div style="padding:10px;background:#fafafa;border-radius:6px;">
                        <p style="margin-bottom:8px;"><strong>Q: 支持7天无理由退换吗？</strong></p>
                        <p style="color:#666;font-size:14px;margin-bottom:12px;">A: 是的，商品在不影响二次销售的情况下，7天内可无理由退换。</p>

                        <p style="margin-bottom:8px;"><strong>Q: 如何申请售后？</strong></p>
                        <p style="color:#666;font-size:14px;margin-bottom:12px;">A: 进入"我的订单"，找到对应订单点击"申请售后"即可。</p>

                        <p style="margin-bottom:8px;"><strong>Q: 退换货运费由谁承担？</strong></p>
                        <p style="color:#666;font-size:14px;">A: 因商品质量问题退换货由商家承担运费，因个人原因退换货需自行承担。</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-right">
            <h3 class="sidebar-title">🎟️ 优惠活动</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">新人专属优惠</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">限时特卖活动</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">满减减免活动</a></li>
            </ul>

            <h3 class="sidebar-title" style="margin-top:20px;">🆘 联系我们</h3>
            <ul class="sidebar-list">
                <li><a href="#">客服热线：00-123-4567</a></li>
                <li><a href="#">工作时间：9-22时</a></li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>热卖商城 &copy;2026 版权所有 | 客服热线：00-123-4567 | 地址：线上电商产业园</p>
    </div>

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

    <!-- 遮罩层 -->
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