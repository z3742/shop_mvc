<?php
// 确保变量有默认值，避免Undefined variable错误
$cartList = isset($cartList) ? $cartList : [];
$cartTotal = isset($cartTotal) ? $cartTotal : 0;
$cartCount = isset($cartCount) ? $cartCount : 0;
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>购物车 - 热卖商城</title>
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
            <div class="head-cart" id="head-cart" data-bs-toggle="tooltip" data-bs-placement="bottom" title="点击查看购物车"><i class="bi bi-cart3 me-1"></i>购物车<span class="cart-num" id="cart-num"><?= $cartCount ?></span></div>
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
                    <li class="nav-item"><a class="nav-link active" href="<?php echo APP_BASE ?>/index/cart"><i class="bi bi-cart3 me-1"></i>购物车</a></li>
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
                <a href="<?php echo APP_BASE ?>/index/cart" class="list-group-item active"><i class="bi bi-cart3 me-2"></i>购物车</a>
                <a href="<?php echo APP_BASE ?>/index/user" class="list-group-item"><i class="bi bi-person me-2"></i>个人中心</a>
                <a href="<?php echo APP_BASE ?>/index/help" class="list-group-item"><i class="bi bi-question-circle me-2"></i>帮助中心</a>
            </div>
        </div>
    </div>

    <div class="main-content" style="margin-top: 20px;">
        <div class="row">
            <!-- 左侧导航 -->
            <div class="col-lg-2 d-none d-lg-block">
                <div class="glass-card rounded-xl p-4 mb-4">
                    <h4 class="font-bold text-dark mb-3"><i class="bi bi-bag-heart me-2"></i>快捷入口</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo APP_BASE ?>/index/index" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-arrow-left me-1"></i>返回商城首页</a></li>
                        <li class="mb-2"><a href="<?php echo APP_BASE ?>/index/goods_list" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-shopping-bag me-1"></i>继续选购商品</a></li>
                        <li class="mb-2"><a href="<?php echo APP_BASE ?>/index/user" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-receipt me-1"></i>我的全部订单</a></li>
                        <li><a href="<?php echo APP_BASE ?>/index/user" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-heart me-1"></i>商品收藏夹</a></li>
                    </ul>
                </div>
                <div class="glass-card rounded-xl p-4 mb-4">
                    <h4 class="font-bold text-dark mb-3"><i class="bi bi-clipboard-check me-2"></i>购物须知</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-sm text-dark"><i class="bi bi-truck me-1"></i>满99元全国包邮</li>
                        <li class="mb-2 text-sm text-dark"><i class="bi bi-credit-card me-1"></i>支持货到付款服务</li>
                        <li class="mb-2 text-sm text-dark"><i class="bi bi-arrow-counterclockwise me-1"></i>7天无理由退换货</li>
                        <li class="text-sm text-dark"><i class="bi bi-shield-check me-1"></i>正品保证 假一赔十</li>
                    </ul>
                </div>
                <div class="glass-card rounded-xl p-4">
                    <h4 class="font-bold text-dark mb-3"><i class="bi bi-bell me-2"></i>售后服务</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-headset me-1"></i>在线客服咨询</a></li>
                        <li class="mb-2"><a href="#" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-search me-1"></i>物流进度查询</a></li>
                        <li><a href="#" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-chat-left-text me-1"></i>售后问题反馈</a></li>
                    </ul>
                </div>
            </div>

            <!-- 中间主要内容 -->
            <div class="col-lg-7">
                <div class="card rounded-2xl shadow-lg overflow-hidden mb-4">
                    <div class="card-header bg-white border-0">
                        <h3 class="font-bold text-dark"><i class="bi bi-cart3 me-2"></i>我的购物车</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($cartList)): ?>
                            <div class="text-center py-12">
                                <div class="text-6xl mb-4 text-gray-300"><i class="bi bi-cart-x"></i></div>
                                <p class="text-gray-400 mb-4">购物车空空如也</p>
                                <a href="<?php echo APP_BASE ?>/index/goods_list" class="btn btn-gradient-primary"><i class="bi bi-bag me-1"></i>去选购</a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th scope="col">商品图片</th>
                                            <th scope="col">商品名称</th>
                                            <th scope="col">单价</th>
                                            <th scope="col">数量</th>
                                            <th scope="col">小计</th>
                                            <th scope="col">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cartList as $item): ?>
                                            <tr data-cart-id="<?= $item['cart_id'] ?>">
                                                <td>
                                                    <div class="w-16 h-16 rounded-lg overflow-hidden border border-gray-200">
                                                        <img src="<?php echo APP_BASE ?>/resources/images/<?= htmlspecialchars($item['goods_img'] ?? 'default.jpg') ?>"
                                                             onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                                             alt="<?= htmlspecialchars($item['goods_name']) ?>"
                                                             class="w-full h-full object-cover">
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="<?php echo APP_BASE ?>/index/goods_detail?id=<?= $item['goods_id'] ?>" class="text-dark hover:text-primary-light font-medium">
                                                        <?= htmlspecialchars($item['goods_name']) ?>
                                                    </a>
                                                </td>
                                                <td class="text-danger font-bold">¥<?= number_format($item['goods_price'], 2) ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center border border-gray-200 rounded-lg overflow-hidden w-fit">
                                                        <button class="w-8 h-8 bg-gray-100 hover:bg-gray-200 transition-colors" data-cart-id="<?= $item['cart_id'] ?>">-</button>
                                                        <input type="text" value="<?= $item['goods_num'] ?>" class="w-12 h-8 text-center border-0 outline-none">
                                                        <button class="w-8 h-8 bg-gray-100 hover:bg-gray-200 transition-colors" data-cart-id="<?= $item['cart_id'] ?>">+</button>
                                                    </div>
                                                </td>
                                                <td class="text-danger font-bold sub-total">¥<?= number_format($item['goods_price'] * $item['goods_num'], 2) ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-danger" data-cart-id="<?= $item['cart_id'] ?>"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- 收货地址 -->
                            <div class="mt-4 bg-gray-50 rounded-xl p-4">
                                <h4 class="font-bold text-dark mb-3"><i class="bi bi-map-pin me-2"></i>选择收货地址</h4>
                                <div id="address-list-cart" class="space-y-2">
                                    <div class="text-center text-gray-400 py-4">正在加载收货地址...</div>
                                </div>
                                <button class="btn btn-outline-primary btn-sm mt-3" onclick="showAddAddressModal()"><i class="bi bi-plus me-1"></i>添加新地址</button>
                            </div>

                            <!-- 结算区域 -->
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <div class="text-lg">
                                    <span class="text-gray-500">商品总金额：</span>
                                    <span class="text-danger font-bold text-xl sum-price">¥<?= number_format($cartTotal, 2) ?></span>
                                </div>
                                <button class="btn btn-gradient-primary px-8" id="checkout-btn"><i class="bi bi-credit-card me-1"></i>确认结算</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- 右侧推荐 -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="glass-card rounded-xl p-4 mb-4">
                    <h4 class="font-bold text-dark mb-3"><i class="bi bi-gift me-2"></i>热门优惠券</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-ticket me-1"></i>满200减20 通用券</a></li>
                        <li class="mb-2"><a href="#" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-ticket me-1"></i>满200减20 品类券</a></li>
                        <li class="mb-2"><a href="#" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-ticket me-1"></i>满200减20 新人券</a></li>
                        <li><a href="#" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-star me-1"></i>新用户首单专享优惠</a></li>
                    </ul>
                </div>
                <div class="glass-card rounded-xl p-4 mb-4">
                    <h4 class="font-bold text-dark mb-3"><i class="bi bi-fire me-2"></i>热门推荐</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo APP_BASE ?>/index/goods_list" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-arrow-up-circle me-1"></i>热销榜单</a></li>
                        <li class="mb-2"><a href="<?php echo APP_BASE ?>/index/goods_list" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-clock me-1"></i>新品上市限时抢购</a></li>
                        <li><a href="<?php echo APP_BASE ?>/index/goods_list" class="text-dark hover:text-primary-light text-sm"><i class="bi bi-cpu me-1"></i>数码配件</a></li>
                    </ul>
                </div>
                <div class="bg-gradient-blue rounded-xl p-4 text-white">
                    <h4 class="font-bold mb-3"><i class="bi bi-chat-dots me-2"></i>用户评价</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-sm"><i class="bi bi-quote me-1"></i>商品质量很好 物流速度快</li>
                        <li class="text-sm"><i class="bi bi-quote me-1"></i>价格实惠 值得购买</li>
                    </ul>
                </div>
            </div>
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

    <div class="modal" id="address-modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">添加收货地址</h3>
                <span class="modal-close" onclick="closeAddressModal()">×</span>
            </div>
            <div class="modal-body">
                <form id="address-form">
                    <input type="hidden" id="addr_id" name="addr_id">
                    <div class="form-item">
                        <label>收货人：</label>
                        <input type="text" id="consignee" name="consignee" placeholder="请输入收货人姓名" required>
                    </div>
                    <div class="form-item">
                        <label>联系电话：</label>
                        <input type="tel" id="phone" name="phone" placeholder="请输入联系电话" required>
                    </div>
                    <div class="form-item">
                        <label>省：</label>
                        <input type="text" id="province" name="province" placeholder="省份">
                    </div>
                    <div class="form-item">
                        <label>市：</label>
                        <input type="text" id="city" name="city" placeholder="城市">
                    </div>
                    <div class="form-item">
                        <label>区：</label>
                        <input type="text" id="district" name="district" placeholder="区/县">
                    </div>
                    <div class="form-item">
                        <label>详细地址：</label>
                        <textarea id="detail_addr" name="detail_addr" rows="3" placeholder="请输入详细地址" required></textarea>
                    </div>
                    <div class="form-item">
                        <button type="submit" class="form-btn">保存地址</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
            loadAddressList();
        });

        function showToast(text) {
            const toast = document.getElementById('toast');
            toast.innerText = text;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2000);
        }

        // 数量减少按钮
        document.querySelectorAll('tbody tr td:nth-child(4) button:first-child').forEach(btn => {
            btn.addEventListener('click', () => {
                const tr = btn.closest('tr');
                const input = tr.querySelector('.num-input');
                const price = parseFloat(tr.querySelector('td:nth-child(3)').innerText.replace('¥', ''));
                let val = parseInt(input.value);
                if (val > 1) {
                    val--;
                    input.value = val;
                    updateSubTotal(tr, price, val);
                    updateCartNum(btn.dataset.cartId, val);
                }
            });
        });

        document.querySelectorAll('tbody tr td:nth-child(4) button:last-child').forEach(btn => {
            btn.addEventListener('click', () => {
                const tr = btn.closest('tr');
                const input = tr.querySelector('.num-input');
                const price = parseFloat(tr.querySelector('td:nth-child(3)').innerText.replace('¥', ''));
                let val = parseInt(input.value);
                val++;
                input.value = val;
                updateSubTotal(tr, price, val);
                updateCartNum(btn.dataset.cartId, val);
            });
        });

        function updateSubTotal(tr, price, num) {
            const subTotal = tr.querySelector('.sub-total');
            subTotal.innerText = '¥' + (price * num).toFixed(2);
        }

        function updateCartNum(cartId, num) {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'cart_id=' + cartId + '&num=' + num
                })
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200) {
                        document.querySelector('.sum-price').innerText = '商品总金额：¥' + data.cart_total.toFixed(2);
                    }
                });
        }

        // 删除购物车
        document.querySelectorAll('.btn-outline-danger').forEach(del => {
            del.addEventListener('click', () => {
                const cartId = del.dataset.cartId;
                const tr = del.closest('tr');
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
                            tr.remove();
                            document.querySelector('.sum-price').innerText = '¥' + data.cart_total.toFixed(2);
                            document.querySelectorAll('.cart-count, .cart-num').forEach(el => {
                                el.innerText = data.cart_count;
                            });
                            showToast('删除成功');

                            if (document.querySelectorAll('tbody tr').length === 0) {
                                document.querySelector('.card-body').innerHTML = `
                                    <div class="text-center py-12">
                                        <div class="text-6xl mb-4 text-gray-300"><i class="bi bi-cart-x"></i></div>
                                        <p class="text-gray-400 mb-4">购物车空空如也</p>
                                        <a href="<?php echo APP_BASE ?>/index/goods_list" class="btn btn-gradient-primary"><i class="bi bi-bag me-1"></i>去选购</a>
                                    </div>
                                `;
                            }
                        }
                    });
            });
        });

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
                            <span class="cart-float-del" data-cart-id="${item.cart_id}" style="cursor:pointer;position:absolute;top:5px;right:5px;color:#999;font-size:18px;font-weight:bold;z-index:10;">×</span>
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
            console.log('删除购物车项:', cartId);
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'cart_id=' + cartId
                })
                .then(r => r.json())
                .then(data => {
                    console.log('删除结果:', data);
                    if (data.code === 200) {
                        document.getElementById('cart-num').innerText = data.cart_count || 0;
                        document.querySelectorAll('.cart-count').forEach(el => {
                            el.innerText = data.cart_count || 0;
                        });
                        loadCartData();
                        showToast('删除成功');
                    } else {
                        showToast(data.msg || '删除失败');
                    }
                }).catch(err => {
                    console.error('删除失败:', err);
                    showToast('删除失败，请稍后重试');
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

        let selectedAddrId = 0;

        function loadAddressList() {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=user/address_list')
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data && data.data.length > 0) {
                        let html = '';
                        data.data.forEach(item => {
                            html += `
                                <div class="p-3 border-2 rounded-lg cursor-pointer transition-all ${selectedAddrId === item.addr_id ? 'border-primary-light bg-primary-light/10' : 'border-gray-200 hover:border-gray-300'}" 
                                     onclick="selectAddress(${item.addr_id})">
                                    <div class="font-bold text-dark">${item.consignee} ${item.phone}</div>
                                    <div class="text-gray-500 text-sm mt-1">${item.province || ''}${item.city || ''}${item.district || ''}${item.detail_addr}</div>
                                </div>
                            `;
                        });
                        document.getElementById('address-list-cart').innerHTML = html;
                        if (selectedAddrId === 0) {
                            selectedAddrId = data.data[0].addr_id;
                            loadAddressList();
                        }
                    } else {
                        document.getElementById('address-list-cart').innerHTML = '<div class="text-center text-gray-400 py-4">暂无收货地址，请添加</div>';
                    }
                })
                .catch(err => console.error('加载地址失败:', err));
        }

        function selectAddress(addrId) {
            selectedAddrId = addrId;
            loadAddressList();
        }

        function showAddAddressModal() {
            document.getElementById('address-modal').style.display = 'flex';
            document.getElementById('overlay').classList.add('show');
            document.getElementById('addr_id').value = '';
            document.getElementById('address-form').reset();
        }

        function closeAddressModal() {
            document.getElementById('address-modal').style.display = 'none';
            document.getElementById('overlay').classList.remove('show');
        }

        document.getElementById('address-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const consignee = document.getElementById('consignee').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const province = document.getElementById('province').value.trim();
            const city = document.getElementById('city').value.trim();
            const district = document.getElementById('district').value.trim();
            const detailAddr = document.getElementById('detail_addr').value.trim();

            if (!consignee || !phone || !detailAddr) {
                showToast('请填写完整地址信息');
                return;
            }

            const addrId = document.getElementById('addr_id').value;
            const url = addrId ? '<?php echo APP_BASE ?>/public/index.php?pathinfo=user/edit_address' : '<?php echo APP_BASE ?>/public/index.php?pathinfo=user/add_address';
            
            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'addr_id=' + addrId + '&consignee=' + encodeURIComponent(consignee) + '&phone=' + encodeURIComponent(phone) + 
                      '&province=' + encodeURIComponent(province) + '&city=' + encodeURIComponent(city) + 
                      '&district=' + encodeURIComponent(district) + '&detail_addr=' + encodeURIComponent(detailAddr)
            })
            .then(r => r.json())
            .then(data => {
                if (data.code === 200) {
                    showToast('保存成功');
                    closeAddressModal();
                    loadAddressList();
                } else {
                    showToast(data.msg || '保存失败');
                }
            })
            .catch(err => {
                console.error('保存地址失败:', err);
                showToast('网络错误');
            });
        });

        // 确认结算下单
        document.getElementById('checkout-btn')?.addEventListener('click', () => {
            if (selectedAddrId === 0) {
                showToast('请先选择收货地址');
                return;
            }

            const checkoutBtn = document.getElementById('checkout-btn');
            checkoutBtn.disabled = true;
            checkoutBtn.innerHTML = '<i class="bi bi-spinner bi-spin me-1"></i>处理中...';

            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=cart/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'addr_id=' + selectedAddrId
                })
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200) {
                        showToast('下单成功');
                        setTimeout(() => {
                            window.location.href = '<?php echo APP_BASE ?>/index/user';
                        }, 1500);
                    } else {
                        showToast(data.msg || '下单失败');
                        checkoutBtn.disabled = false;
                        checkoutBtn.innerHTML = '<i class="bi bi-credit-card me-1"></i>确认结算';
                    }
                })
                .catch(err => {
                    console.error('下单失败:', err);
                    showToast('下单失败，请稍后重试');
                    checkoutBtn.disabled = false;
                    checkoutBtn.innerHTML = '<i class="bi bi-credit-card me-1"></i>确认结算';
                });
        });
    </script>
</body>

</html>