<?php
$userInfo = isset($userInfo) ? $userInfo : [];
$isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1;
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人中心 - 热卖商城</title>
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
                    <li class="nav-item"><a class="nav-link active" href="<?php echo APP_BASE ?>/index/user"><i class="bi bi-person me-1"></i>个人中心</a></li>
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
                <a href="<?php echo APP_BASE ?>/index/user" class="list-group-item active"><i class="bi bi-person me-2"></i>个人中心</a>
                <a href="<?php echo APP_BASE ?>/index/help" class="list-group-item"><i class="bi bi-question-circle me-2"></i>帮助中心</a>
            </div>
        </div>
    </div>

    <div class="main-layout main-content">
        <div class="sidebar-left">
            <div class="user-info-card">
                <div class="user-avatar">
                    <img src="<?php echo APP_BASE ?>/resources/images/avatar/default.png"
                        onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIiBmaWxsPSIjY2MwMCI+PGNpcmNsZSBjeD0iNTAiIGN5PSI0MCIgcj0iMjAiLz48ZWxsaXBzZSBjeD0iNTAiIGN5PSI5NSIgcng9IjM1IiByeT0iMjUiLz48L3N2Zz4='"
                        alt="<?= htmlspecialchars($_SESSION['username'] ?? '用户') ?>">
                </div>
                <div class="user-info">
                    <div class="user-name"><?= htmlspecialchars($_SESSION['username'] ?? '未登录') ?></div>
                    <div class="user-type"><?php echo $isAdmin ? '管理员' : '普通用户' ?></div>
                </div>
            </div>
            <h3 class="sidebar-title"><i class="bi bi-person-circle me-1"></i> 个人中心</h3>
            <ul class="sidebar-list user-menu" id="user-menu">
                <li class="active"><a href="#orders" onclick="switchMenu(this, 'orders')">我的订单</a></li>
                <li><a href="#pending" onclick="switchMenu(this, 'pending')">待付款</a></li>
                <li><a href="#shipped" onclick="switchMenu(this, 'shipped')">待发货</a></li>
                <li><a href="#received" onclick="switchMenu(this, 'received')">待收货</a></li>
                <li><a href="#completed" onclick="switchMenu(this, 'completed')">已完成</a></li>
            </ul>

            <?php if (!$isAdmin): ?>
                <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-box-seam me-1"></i> 商品管理</h3>
                <ul class="sidebar-list" id="goods-menu">
                    <li><a href="#addGoods" onclick="switchMenu(this, 'addGoods')">上架商品</a></li>
                    <li><a href="#myGoods" onclick="switchMenu(this, 'myGoods')">我的商品</a></li>
                </ul>
            <?php endif; ?>

            <?php if ($isAdmin): ?>
                <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-gear me-1"></i> 管理中心</h3>
                <ul class="sidebar-list admin-menu" id="admin-menu">
                    <li><a href="#audit" onclick="switchMenu(this, 'audit')">商品审核</a></li>
                    <li><a href="#adminOrders" onclick="switchMenu(this, 'adminOrders')">订单管理</a></li>
                    <li><a href="#userManage" onclick="switchMenu(this, 'userManage')">用户管理</a></li>
                </ul>
            <?php endif; ?>

            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-heart me-1"></i> 我的收藏</h3>
            <ul class="sidebar-list" id="favorite-menu">
                <li><a href="#favorites" onclick="switchMenu(this, 'favorites')">我的收藏</a></li>
            </ul>

            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-gear-wide-connected me-1"></i> 账户设置</h3>
            <ul class="sidebar-list" id="account-menu">
                <li><a href="#address" onclick="switchMenu(this, 'address')">收货地址管理</a></li>
                <li><a href="#password" onclick="switchMenu(this, 'password')">修改登录密码</a></li>
                <li><a href="#phone" onclick="switchMenu(this, 'phone')">绑定手机号</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/logout">退出当前账号</a></li>
            </ul>
        </div>

        <div class="content-middle">
            <div id="content-orders" class="content-panel">
                <div class="goods-title">我的订单</div>
                <div id="order-list-container">
                    <div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">
                        正在加载订单...
                    </div>
                </div>
            </div>

            <div id="content-pending" class="content-panel" style="display:none;">
                <div class="goods-title">待付款订单</div>
                <div id="order-pending-container">
                    <div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">正在加载...</div>
                </div>
            </div>

            <div id="content-shipped" class="content-panel" style="display:none;">
                <div class="goods-title">待发货订单</div>
                <div id="order-shipped-container">
                    <div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">正在加载...</div>
                </div>
            </div>

            <div id="content-received" class="content-panel" style="display:none;">
                <div class="goods-title">待收货订单</div>
                <div id="order-received-container">
                    <div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">正在加载...</div>
                </div>
            </div>

            <div id="content-completed" class="content-panel" style="display:none;">
                <div class="goods-title">已完成订单</div>
                <div id="order-completed-container">
                    <div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">正在加载...</div>
                </div>
            </div>

            <div id="content-addGoods" class="content-panel" style="display:none;">
                <div class="goods-title">上架商品</div>
                <div id="goods-error-msg" style="color:#e1251b;text-align:center;margin-bottom:10px;display:none;"></div>
                <form id="add-goods-form" enctype="multipart/form-data">
                    <div class="form-item">
                        <label>商品名称：</label>
                        <input type="text" id="goods_name" name="goods_name" placeholder="请输入商品名称" required>
                    </div>
                    <div class="form-item">
                        <label>商品价格：</label>
                        <input type="number" id="goods_price" name="goods_price" placeholder="请输入商品价格" step="0.01" min="0" required>
                    </div>
                    <div class="form-item">
                        <label>库存数量：</label>
                        <input type="number" id="stock" name="stock" placeholder="请输入库存数量" min="1" value="100">
                    </div>
                    <div class="form-item">
                        <label>商品分类：</label>
                        <select id="cat_id" name="cat_id">
                            <option value="1">手机数码</option>
                            <option value="2">美妆护肤</option>
                            <option value="3">生活工具</option>
                            <option value="4">数码配件</option>
                            <option value="5">内衣服饰</option>
                            <option value="6">工具用品</option>
                            <option value="7">其他商品</option>
                        </select>
                    </div>
                    <div class="form-item">
                        <label>商品图片：</label>
                        <input type="file" id="goods_img" name="goods_img" accept="image/jpeg,image/png,image/gif">
                        <p style="color:#666;font-size:12px;margin-top:5px;">支持jpg、jpeg、png、gif格式</p>
                    </div>
                    <div class="form-item">
                        <label>商品描述：</label>
                        <textarea id="goods_desc" name="goods_desc" rows="5" placeholder="请输入商品描述"></textarea>
                    </div>
                    <div class="form-item">
                        <button type="submit" class="form-btn" id="submit-goods-btn">提交审核</button>
                    </div>
                </form>
            </div>

            <div id="content-myGoods" class="content-panel" style="display:none;">
                <div class="goods-title">我的商品</div>
                <div id="my-goods-list">
                    <div style="margin-top:30px;border:1px dashed #eee;padding:30px;border-radius:8px;text-align:center;color:#999;">
                        <p>暂无上架商品</p>
                        <a href="#addGoods" onclick="switchMenu(null, 'addGoods')" class="form-btn" style="margin-top:15px;display:inline-block;width:auto;padding:10px 24px;">去上架商品</a>
                    </div>
                </div>
            </div>

            <div id="content-audit" class="content-panel" style="display:none;">
                <div class="goods-title">商品审核</div>
                <div class="audit-stats">
                    <div class="stat-card pending">
                        <div class="stat-icon">⏳</div>
                        <div class="stat-info">
                            <div class="stat-count" id="stat-pending">0</div>
                            <div class="stat-label">待审核</div>
                        </div>
                    </div>
                    <div class="stat-card approved">
                        <div class="stat-icon">✅</div>
                        <div class="stat-info">
                            <div class="stat-count" id="stat-approved">0</div>
                            <div class="stat-label">已通过</div>
                        </div>
                    </div>
                    <div class="stat-card rejected">
                        <div class="stat-icon">❌</div>
                        <div class="stat-info">
                            <div class="stat-count" id="stat-rejected">0</div>
                            <div class="stat-label">已拒绝</div>
                        </div>
                    </div>
                </div>
                <div id="audit-list">
                    <div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">
                        暂无待审核商品
                    </div>
                </div>
            </div>

            <!-- 商品详情弹窗 -->
            <div class="modal" id="audit-detail-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="audit-detail-title">商品详情</h3>
                        <span class="modal-close" onclick="closeAuditDetail()">×</span>
                    </div>
                    <div class="modal-body">
                        <div id="audit-detail-content"></div>
                    </div>
                </div>
            </div>

            <div id="content-adminOrders" class="content-panel" style="display:none;">
                <div class="goods-title">订单管理</div>
                <div id="admin-order-list">
                    <div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">正在加载订单...</div>
                </div>
            </div>

            <div id="content-favorites" class="content-panel" style="display:none;">
                <div class="goods-title">我的收藏</div>
                <div id="favorite-list">
                    <div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">正在加载收藏...</div>
                </div>
            </div>

            <div id="content-userManage" class="content-panel" style="display:none;">
                <div class="goods-title">用户管理</div>
                <div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">
                    用户管理功能开发中
                </div>
            </div>

            <div id="content-address" class="content-panel" style="display:none;">
                <div class="goods-title">收货地址管理</div>
                <button class="form-btn" style="margin:20px 0;" onclick="showAddAddressForm()">+ 添加新地址</button>

                <div id="address-list">
                    <div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">
                        暂无收货地址
                    </div>
                </div>
            </div>

            <div id="content-password" class="content-panel" style="display:none;">
                <div class="goods-title">修改登录密码</div>
                <div id="pwd-error-msg" style="color:#e1251b;text-align:center;margin-bottom:10px;display:none;"></div>
                <form id="change-pwd-form">
                    <div class="form-item">
                        <label>原密码：</label>
                        <input type="password" id="old_pwd" placeholder="请输入原密码">
                    </div>
                    <div class="form-item">
                        <label>新密码：</label>
                        <input type="password" id="new_pwd" placeholder="请输入新密码">
                    </div>
                    <div class="form-item">
                        <label>确认密码：</label>
                        <input type="password" id="confirm_pwd" placeholder="请再次输入新密码">
                    </div>
                    <div class="form-item">
                        <button type="submit" class="form-btn">修改密码</button>
                    </div>
                </form>
            </div>

            <div id="content-phone" class="content-panel" style="display:none;">
                <div class="goods-title">绑定手机号</div>
                <div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">
                    当前手机号：<?= htmlspecialchars($userInfo['phone'] ?: '未绑定') ?>
                </div>
                <form id="bind-phone-form" style="margin-top:20px;">
                    <div class="form-item">
                        <label>手机号：</label>
                        <input type="tel" id="bind-phone" name="phone" placeholder="请输入手机号">
                    </div>
                    <div class="form-item">
                        <button type="submit" class="form-btn">绑定</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="sidebar-right">
            <h3 class="sidebar-title"><i class="bi bi-gift me-1"></i> 我的优惠券</h3>
            <ul class="sidebar-list">
                <li><a href="#">未使用优惠券(3张)</a></li>
                <li><a href="#">已使用优惠券</a></li>
                <li><a href="#">已过期优惠券</a></li>
            </ul>

            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-award me-1"></i> 积分中心</h3>
            <ul class="sidebar-list">
                <li><a href="#">当前可用积分</a></li>
                <li><a href="#">积分获取规则</a></li>
                <li><a href="#">积分兑换礼品</a></li>
            </ul>

            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-headset me-1"></i> 客户服务</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/help">帮助中心</a></li>
                <li><a href="#">订单问题咨询</a></li>
                <li><a href="#">售后退换货</a></li>
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

    <!-- 添加/编辑地址弹窗 -->
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
        // fallback: 3秒后强制隐藏loader，防止JS报错导致卡死
        setTimeout(function() {
            if (loader && !loader.classList.contains('hide')) {
                loader.classList.add('hide');
                mainBoxes.forEach(function(box) { box.classList.add('show'); });
            }
        }, 3000);
        window.addEventListener('load', function() {
            setTimeout(function() {
                if (loader) loader.classList.add('hide');
                mainBoxes.forEach(function(box) { box.classList.add('show'); });
            }, 800);
            fetchCartCount();
            loadOrderList('all');
            <?php if ($isAdmin): ?>
                loadAuditList();
            <?php endif; ?>
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

        // 增强版菜单切换 - 支持高亮激活项
        function switchMenu(linkEl, panelId) {
            // 清除所有菜单的active状态
            document.querySelectorAll('.sidebar-left .sidebar-list li').forEach(li => {
                li.classList.remove('active');
            });
            // 设置当前菜单项为active
            if (linkEl) {
                linkEl.parentElement.classList.add('active');
            }
            // 切换内容面板
            showContent(panelId);
        }

        function showContent(panelId) {
            document.querySelectorAll('.content-panel').forEach(panel => {
                panel.style.display = 'none';
            });
            var target = document.getElementById('content-' + panelId);
            if (target) {
                target.style.display = 'block';
            }

            if (panelId === 'audit') {
                loadAuditList();
            }
            if (panelId === 'myGoods') {
                loadMyGoods();
            }
            if (panelId === 'address') {
                loadAddressList();
            }
            if (panelId === 'orders') {
                loadOrderList('all');
            }
            if (panelId === 'pending') {
                loadOrderList('0');
            }
            if (panelId === 'shipped') {
                loadOrderList('2');
            }
            if (panelId === 'received') {
                loadOrderList('2');
            }
            if (panelId === 'completed') {
                loadOrderList('3');
            }
            if (panelId === 'adminOrders') {
                loadAdminOrderList();
            }
            if (panelId === 'favorites') {
                loadFavoriteList();
            }
        }

        function loadOrderList(status) {
            var url = status === 'all' 
                ? '<?php echo APP_BASE ?>/public/index.php?pathinfo=user/order_list'
                : '<?php echo APP_BASE ?>/public/index.php?pathinfo=user/order_list_by_status&status=' + status;
            
            fetch(url)
                .then(r => r.json())
                .then(data => {
                    var containerId = 'order-list-container';
                    if (status === '0') containerId = 'order-pending-container';
                    if (status === '2') {
                        if (document.getElementById('content-received').style.display === 'block') {
                            containerId = 'order-received-container';
                        } else {
                            containerId = 'order-shipped-container';
                        }
                    }
                    if (status === '3') containerId = 'order-completed-container';

                    var container = document.getElementById(containerId);
                    if (!container) return;

                    if (data.code === 200 && data.data && data.data.length > 0) {
                        var html = '<div class="order-list">';
                        data.data.forEach(function(order) {
                            var statusText = ['待付款', '已付款', '已发货', '已完成', '已取消'];
                            var statusClass = ['pending', 'paid', 'shipped', 'completed', 'cancelled'];
                            
                            html += '<div class="order-card">';
                            html += '<div class="order-header">';
                            html += '<div class="order-info">';
                            html += '<span class="order-sn">订单号：' + order.order_sn + '</span>';
                            html += '<span class="order-time">' + (order.create_time || '') + '</span>';
                            html += '</div>';
                            html += '<span class="order-status ' + statusClass[order.status] + '">' + statusText[order.status] + '</span>';
                            html += '</div>';

                            if (order.goods_list && order.goods_list.length > 0) {
                                html += '<div class="order-goods">';
                                order.goods_list.forEach(function(goods) {
                                    var imgPath = goods.goods_img ? goods.goods_img.split('/').pop() : 'default.jpg';
                                    html += '<div class="order-goods-item">';
                                    html += '<img src="<?php echo APP_BASE ?>/resources/images/goods/' + imgPath + '" ' +
                                             'onerror="this.src=\'<?php echo APP_BASE ?>/resources/images/goods/default.jpg\'" ' +
                                             'alt="' + goods.goods_name + '" class="order-goods-img">';
                                    html += '<div class="order-goods-info">';
                                    html += '<div class="order-goods-name">' + goods.goods_name + '</div>';
                                    html += '<div class="order-goods-price">¥' + parseFloat(goods.goods_price).toFixed(2) + '</div>';
                                    html += '<div class="order-goods-num">x' + goods.goods_num + '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                });
                                html += '</div>';
                            }

                            html += '<div class="order-footer">';
                            html += '<div class="order-total">合计：<span>¥' + parseFloat(order.total_amount).toFixed(2) + '</span></div>';
                            html += '<div class="order-actions">';
                            
                            if (order.status === 0) {
                                html += '<button class="order-btn" onclick="updateOrderStatus(' + order.order_id + ', 1)">立即支付</button>';
                                html += '<button class="order-btn cancel" onclick="updateOrderStatus(' + order.order_id + ', 4)">取消订单</button>';
                            } else if (order.status === 1) {
                                html += '<button class="order-btn" onclick="updateOrderStatus(' + order.order_id + ', 2)">确认发货</button>';
                            } else if (order.status === 2) {
                                html += '<button class="order-btn" onclick="updateOrderStatus(' + order.order_id + ', 3)">确认收货</button>';
                            } else if (order.status === 3) {
                                html += '<button class="order-btn disabled">交易完成</button>';
                            }

                            html += '</div></div></div>';
                        });
                        html += '</div>';
                        container.innerHTML = html;
                    } else {
                        container.innerHTML = '<div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;text-align:center;color:#999;">暂无相关订单</div>';
                    }
                })
                .catch(function(err) {
                    console.error('加载订单失败:', err);
                });
        }

        function updateOrderStatus(orderId, status) {
            var confirmText = '';
            if (status === 1) confirmText = '确认支付此订单？';
            else if (status === 2) confirmText = '确认发货？';
            else if (status === 3) confirmText = '确认收货？';
            else if (status === 4) confirmText = '确认取消订单？';

            if (!confirm(confirmText)) return;

            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=user/update_order_status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'order_id=' + orderId + '&status=' + status
            })
            .then(r => r.json())
            .then(data => {
                if (data.code === 200) {
                    showToast(data.msg);
                    loadOrderList('all');
                    loadOrderList('0');
                    loadOrderList('2');
                    loadOrderList('3');
                } else {
                    showToast(data.msg || '操作失败');
                }
            })
            .catch(err => {
                console.error('操作失败:', err);
                showToast('网络错误');
            });
        }

        // 加载我的商品列表
        function loadMyGoods() {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=user/my_goods')
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data && data.data.length > 0) {
                        var html = '<div class="my-goods-grid">';
                        data.data.forEach(function(item) {
                            var statusClass = '';
                            var statusText = '';
                            if (item.status == 0) { statusClass = 'pending'; statusText = '待审核'; }
                            else if (item.status == 1) { statusClass = 'approved'; statusText = '已通过'; }
                            else { statusClass = 'rejected'; statusText = '已拒绝'; }
                            var imgName = item.goods_img ? item.goods_img.split('/').pop() : 'default.jpg';
                            html += '<div class="my-goods-card">' +
                                '<img src="<?php echo APP_BASE ?>/resources/images/goods/' + imgName + '" ' +
                                'onerror="this.src=\'<?php echo APP_BASE ?>/resources/images/goods/default.jpg\'" ' +
                                'alt="' + item.goods_name + '" class="my-goods-card-img">' +
                                '<div class="my-goods-card-body">' +
                                '<div class="my-goods-card-name">' + item.goods_name + '</div>' +
                                '<div class="my-goods-card-price">¥' + parseFloat(item.goods_price).toFixed(2) + '</div>' +
                                '<span class="my-goods-card-status ' + statusClass + '">' + statusText + '</span>' +
                                '</div></div>';
                        });
                        html += '</div>';
                        document.getElementById('my-goods-list').innerHTML = html;
                    } else {
                        document.getElementById('my-goods-list').innerHTML =
                            '<div style="margin-top:30px;border:1px dashed #eee;padding:30px;border-radius:8px;text-align:center;color:#999;">' +
                            '<p>暂无上架商品</p>' +
                            "<a href=\"#addGoods\" onclick=\"switchMenu(null, 'addGoods')\" class=\"form-btn\" style=\"margin-top:15px;display:inline-block;width:auto;padding:10px 24px;\">去上架商品</a>" +
                            '</div>';
                    }
                })
                .catch(function(err) {
                    console.error('加载我的商品失败:', err);
                });
        }

        const addGoodsForm = document.getElementById('add-goods-form');
        if (addGoodsForm) {
            addGoodsForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const goodsName = document.getElementById('goods_name').value.trim();
                const goodsPrice = parseFloat(document.getElementById('goods_price').value);
                const stock = parseInt(document.getElementById('stock').value);
                const catId = parseInt(document.getElementById('cat_id').value);
                const goodsDesc = document.getElementById('goods_desc').value.trim();

                if (!goodsName || goodsPrice <= 0) {
                    document.getElementById('goods-error-msg').textContent = '商品名称和价格不能为空';
                    document.getElementById('goods-error-msg').style.display = 'block';
                    return;
                }

                const submitBtn = document.getElementById('submit-goods-btn');
                submitBtn.disabled = true;
                submitBtn.textContent = '提交中...';

                const formData = new FormData(this);

                fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=user/add_goods', {
                        method: 'POST',
                        body: formData
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.code === 200) {
                            showToast('提交成功，等待审核');
                            addGoodsForm.reset();
                        } else {
                            document.getElementById('goods-error-msg').textContent = data.msg || '提交失败';
                            document.getElementById('goods-error-msg').style.display = 'block';
                        }
                        submitBtn.disabled = false;
                        submitBtn.textContent = '提交审核';
                    })
                    .catch(err => {
                        console.error('提交商品错误:', err);
                        document.getElementById('goods-error-msg').textContent = '网络错误';
                        document.getElementById('goods-error-msg').style.display = 'block';
                        submitBtn.disabled = false;
                        submitBtn.textContent = '提交审核';
                    });
            });
        }

        function loadAuditList() {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=user/pending_list')
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data && data.data.length > 0) {
                        let html = '<table class="audit-table"><tr><th>商品图片</th><th>商品名称</th><th>价格</th><th>库存</th><th>分类</th><th>提交用户</th><th>提交时间</th><th>操作</th></tr>';
                        data.data.forEach(item => {
                            const imgPath = item.goods_img ? item.goods_img.split('/').pop() : 'default.jpg';
                            html += `<tr>
                                <td><img src="<?php echo APP_BASE ?>/resources/images/goods/${imgPath}" 
                                         onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                         alt="${item.goods_name}" class="audit-table-img"></td>
                                <td>${item.goods_name}</td>
                                <td>¥${item.goods_price}</td>
                                <td>${item.stock}</td>
                                <td>${item.cat_name || '-'}</td>
                                <td>${item.username || '未知'}</td>
                                <td>${item.create_time || '-'}</td>
                                <td>
                                    <button class="audit-btn detail" onclick="showAuditDetail(${item.goods_id})">查看详情</button>
                                    <button class="audit-btn" onclick="auditGoods(${item.goods_id}, 1)">通过</button>
                                    <button class="audit-btn reject" onclick="auditGoods(${item.goods_id}, 2)">拒绝</button>
                                </td>
                            </tr>`;
                        });
                        html += '</table>';
                        document.getElementById('audit-list').innerHTML = html;
                        document.getElementById('stat-pending').innerText = data.data.length;
                    } else {
                        document.getElementById('audit-list').innerHTML = '<div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">暂无待审核商品</div>';
                        document.getElementById('stat-pending').innerText = '0';
                    }
                })
                .catch(err => {
                    console.error('加载审核列表失败:', err);
                });
        }

        function showAuditDetail(goodsId) {
            fetch(`<?php echo APP_BASE ?>/public/index.php?pathinfo=goods/detail&goods_id=${goodsId}`)
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data) {
                        const item = data.data;
                        let html = `
                            <table class="audit-detail-table">
                                <tr>
                                    <th colspan="2">商品信息</th>
                                </tr>
                                <tr>
                                    <td class="detail-label">商品名称</td>
                                    <td class="detail-value">${item.goods_name || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">商品价格</td>
                                    <td class="detail-value">¥${item.goods_price || '0.00'}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">库存数量</td>
                                    <td class="detail-value">${item.stock || 0}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">商品分类</td>
                                    <td class="detail-value">${item.cat_name || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">商品图片</td>
                                    <td class="detail-value">
                                        <img src="<?php echo APP_BASE ?>/resources/images/goods/${item.goods_img ? item.goods_img.split('/').pop() : 'default.jpg'}" 
                                             onerror="this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
                                             alt="${item.goods_name}" class="audit-detail-img">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="detail-label">商品描述</td>
                                    <td class="detail-value">${item.goods_desc || '暂无描述'}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">提交用户</td>
                                    <td class="detail-value">${item.username || '未知'}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">提交时间</td>
                                    <td class="detail-value">${item.create_time || '-'}</td>
                                </tr>
                            </table>
                        `;
                        document.getElementById('audit-detail-content').innerHTML = html;
                        var modal = document.getElementById('audit-detail-modal');
                        var modalContent = modal.querySelector('.modal-content');
                        modal.style.display = 'flex';
                        document.getElementById('overlay').classList.add('show');

                        modalContent.onclick = function(e) {
                            e.stopPropagation();
                        };
                    } else {
                        showToast(data.msg || '获取商品详情失败');
                    }
                })
                .catch(err => {
                    console.error('获取商品详情失败:', err);
                    showToast('获取商品详情失败');
                });
        }

        function closeAuditDetail() {
            document.getElementById('audit-detail-modal').style.display = 'none';
            var ov = document.getElementById('overlay');
            if (ov) ov.classList.remove('show');
        }



        function auditGoods(goodsId, status) {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=user/check_goods', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `goods_id=${goodsId}&status=${status}`
                })
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200) {
                        showToast(status === 1 ? '审核通过' : '已拒绝');
                        loadAuditList();
                    } else {
                        showToast(data.msg || '审核失败');
                    }
                })
                .catch(err => {
                    console.error('审核错误:', err);
                    showToast('网络错误');
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
                            <img src="<?php echo APP_BASE ?>/resources/images/goods/${item.goods_img || 'default.jpg'}"
                                 onerror="this.onerror=null;this.src='<?php echo APP_BASE ?>/resources/images/goods/default.jpg'"
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

        overlay.addEventListener('click', function() {
            var auditModal = document.getElementById('audit-detail-modal');
            if (auditModal && auditModal.style.display === 'flex') {
                closeAuditDetail();
                return;
            }
            var addressModal = document.getElementById('address-modal');
            if (addressModal && addressModal.classList.contains('show')) {
                closeAddressModal();
            } else {
                cartFloatBox.classList.remove('show');
                overlay.classList.remove('show');
            }
        });

        // 地址管理相关功能
        function loadAddressList() {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=user/address_list')
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data && data.data.length > 0) {
                        let html = '<div class="address-list-container">';
                        data.data.forEach(item => {
                            html += `
                                <div class="address-item">
                                    <div class="address-header">
                                        <span class="address-consignee">${item.consignee}</span>
                                        <span class="address-phone">${item.phone}</span>
                                    </div>
                                    <div class="address-detail">
                                        ${item.province || ''}${item.city || ''}${item.district || ''}${item.detail_addr}
                                    </div>
                                    <div class="address-actions">
                                        <button class="address-btn edit" onclick="editAddress(${item.addr_id})">编辑</button>
                                        <button class="address-btn delete" onclick="deleteAddress(${item.addr_id})">删除</button>
                                    </div>
                                </div>
                            `;
                        });
                        html += '</div>';
                        document.getElementById('address-list').innerHTML = html;
                    } else {
                        document.getElementById('address-list').innerHTML = '<div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;">暂无收货地址</div>';
                    }
                })
                .catch(err => {
                    console.error('加载地址列表失败:', err);
                });
        }

        function showAddAddressForm() {
            document.getElementById('modal-title').textContent = '添加收货地址';
            document.getElementById('address-form').reset();
            document.getElementById('addr_id').value = '';
            document.getElementById('address-modal').classList.add('show');
            overlay.classList.add('show');
        }

        function editAddress(addrId) {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=user/address_list')
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data) {
                        const address = data.data.find(item => item.addr_id === addrId);
                        if (address) {
                            document.getElementById('modal-title').textContent = '编辑收货地址';
                            document.getElementById('addr_id').value = address.addr_id;
                            document.getElementById('consignee').value = address.consignee;
                            document.getElementById('phone').value = address.phone;
                            document.getElementById('province').value = address.province || '';
                            document.getElementById('city').value = address.city || '';
                            document.getElementById('district').value = address.district || '';
                            document.getElementById('detail_addr').value = address.detail_addr;
                            document.getElementById('address-modal').classList.add('show');
                            overlay.classList.add('show');
                        }
                    }
                })
                .catch(err => {
                    console.error('获取地址信息失败:', err);
                });
        }

        function closeAddressModal() {
            document.getElementById('address-modal').classList.remove('show');
            document.getElementById('address-form').reset();
            document.getElementById('addr_id').value = '';
            overlay.classList.remove('show');
        }

        const addressForm = document.getElementById('address-form');
        if (addressForm) {
            addressForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const addrId = document.getElementById('addr_id').value;
                const consignee = document.getElementById('consignee').value.trim();
                const phone = document.getElementById('phone').value.trim();
                const province = document.getElementById('province').value.trim();
                const city = document.getElementById('city').value.trim();
                const district = document.getElementById('district').value.trim();
                const detailAddr = document.getElementById('detail_addr').value.trim();

                if (!consignee || !phone || !detailAddr) {
                    showToast('收货人、电话和详细地址不能为空');
                    return;
                }

                const url = addrId ? '<?php echo APP_BASE ?>/public/index.php?pathinfo=user/edit_address' : '<?php echo APP_BASE ?>/public/index.php?pathinfo=user/add_address';

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'consignee=' + encodeURIComponent(consignee) +
                            '&phone=' + encodeURIComponent(phone) +
                            '&province=' + encodeURIComponent(province) +
                            '&city=' + encodeURIComponent(city) +
                            '&district=' + encodeURIComponent(district) +
                            '&detail_addr=' + encodeURIComponent(detailAddr) +
                            (addrId ? '&addr_id=' + encodeURIComponent(addrId) : '')
                    })
                    .then(r => {
                        if (!r.ok) {
                            throw new Error('HTTP error ' + r.status);
                        }
                        return r.json();
                    })
                    .then(data => {
                        if (data.code === 200) {
                            showToast(addrId ? '修改成功' : '添加成功');
                            closeAddressModal();
                            loadAddressList();
                        } else {
                            showToast(data.msg || '操作失败');
                        }
                    })
                    .catch(err => {
                        console.error('保存地址失败:', err);
                        showToast('网络错误: ' + err.message);
                    });
            });
        }

        function deleteAddress(addrId) {
            if (!confirm('确定要删除这个地址吗？')) {
                return;
            }

            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=user/delete_address', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'addr_id=' + addrId
                })
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200) {
                        showToast('删除成功');
                        loadAddressList();
                    } else {
                        showToast(data.msg || '删除失败');
                    }
                })
                .catch(err => {
                    console.error('删除地址失败:', err);
                    showToast('网络错误');
                });
        }

        function loadAdminOrderList() {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=user/admin_order_list')
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data && data.data.length > 0) {
                        var html = '<div class="order-list">';
                        data.data.forEach(function(order) {
                            var statusText = ['待付款', '已付款', '已发货', '已完成', '已取消'];
                            var statusClass = ['pending', 'paid', 'shipped', 'completed', 'cancelled'];
                            
                            html += '<div class="order-card">';
                            html += '<div class="order-header">';
                            html += '<div class="order-info">';
                            html += '<span class="order-sn">订单号：' + order.order_sn + '</span>';
                            html += '<span>用户：' + (order.username || '未知') + '</span>';
                            html += '<span class="order-time">' + (order.create_time || '') + '</span>';
                            html += '</div>';
                            html += '<span class="order-status ' + statusClass[order.status] + '">' + statusText[order.status] + '</span>';
                            html += '</div>';

                            if (order.consignee) {
                                html += '<div style="padding:10px;background:#f9f9f9;margin:10px 0;border-radius:4px;">';
                                html += '<div>收货人：' + order.consignee + '</div>';
                                html += '<div>电话：' + (order.phone || '') + '</div>';
                                html += '<div>地址：' + (order.address || '') + '</div>';
                                html += '</div>';
                            }

                            if (order.goods_list && order.goods_list.length > 0) {
                                html += '<div class="order-goods">';
                                order.goods_list.forEach(function(goods) {
                                    var imgPath = goods.goods_img ? goods.goods_img.split('/').pop() : 'default.jpg';
                                    html += '<div class="order-goods-item">';
                                    html += '<img src="<?php echo APP_BASE ?>/resources/images/goods/' + imgPath + '" ' +
                                             'onerror="this.src=\'<?php echo APP_BASE ?>/resources/images/goods/default.jpg\'" ' +
                                             'alt="' + goods.goods_name + '" class="order-goods-img">';
                                    html += '<div class="order-goods-info">';
                                    html += '<div class="order-goods-name">' + goods.goods_name + '</div>';
                                    html += '<div class="order-goods-price">¥' + parseFloat(goods.goods_price).toFixed(2) + '</div>';
                                    html += '<div class="order-goods-num">x' + goods.goods_num + '</div>';
                                    html += '</div></div>';
                                });
                                html += '</div>';
                            }

                            html += '<div class="order-footer">';
                            html += '<div class="order-total">合计：<span>¥' + parseFloat(order.total_amount).toFixed(2) + '</span></div>';
                            html += '<div class="order-actions">';
                            
                            if (order.status === 1) {
                                html += '<button class="order-btn" onclick="updateOrderStatus(' + order.order_id + ', 2)">确认发货</button>';
                            }

                            html += '</div></div></div>';
                        });
                        html += '</div>';
                        document.getElementById('admin-order-list').innerHTML = html;
                    } else {
                        document.getElementById('admin-order-list').innerHTML = '<div style="margin-top:30px;border:1px dashed #eee;padding:20px;border-radius:8px;text-align:center;color:#999;">暂无订单</div>';
                    }
                })
                .catch(err => {
                    console.error('加载订单失败:', err);
                });
        }

        function loadFavoriteList() {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=favorite/list')
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200 && data.data && data.data.length > 0) {
                        var html = '<div class="my-goods-grid">';
                        data.data.forEach(function(item) {
                            var imgName = item.goods_img ? item.goods_img.split('/').pop() : 'default.jpg';
                            html += '<div class="my-goods-card">' +
                                '<img src="<?php echo APP_BASE ?>/resources/images/goods/' + imgName + '" ' +
                                'onerror="this.src=\'<?php echo APP_BASE ?>/resources/images/goods/default.jpg\'" ' +
                                'alt="' + item.goods_name + '" class="my-goods-card-img">' +
                                '<div class="my-goods-card-body">' +
                                '<div class="my-goods-card-name"><a href="<?php echo APP_BASE ?>/index/goods_detail?id=' + item.goods_id + '" style="color:#333;">' + item.goods_name + '</a></div>' +
                                '<div class="my-goods-card-price">¥' + parseFloat(item.goods_price).toFixed(2) + '</div>' +
                                '<button class="form-btn" style="margin-top:5px;padding:5px 10px;font-size:12px;background:#ff6b6b;" onclick="removeFavorite(' + item.goods_id + ', this)">取消收藏</button>' +
                                '</div></div>';
                        });
                        html += '</div>';
                        document.getElementById('favorite-list').innerHTML = html;
                    } else {
                        document.getElementById('favorite-list').innerHTML =
                            '<div style="margin-top:30px;border:1px dashed #eee;padding:30px;border-radius:8px;text-align:center;color:#999;">' +
                            '<p>暂无收藏商品</p>' +
                            '</div>';
                    }
                })
                .catch(err => {
                    console.error('加载收藏失败:', err);
                });
        }

        function removeFavorite(goodsId, btn) {
            fetch('<?php echo APP_BASE ?>/public/index.php?pathinfo=favorite/remove', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'goods_id=' + goodsId
            })
            .then(r => r.json())
            .then(data => {
                if (data.code === 200) {
                    showToast('取消收藏成功');
                    btn.closest('.my-goods-card').remove();
                } else {
                    showToast(data.msg || '操作失败');
                }
            })
            .catch(err => {
                console.error('取消收藏失败:', err);
                showToast('网络错误');
            });
        }
    </script>
</body>

</html>