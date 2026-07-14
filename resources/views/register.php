<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>账号注册 - 热卖商城</title>
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
                <a href="<?php echo APP_BASE ?>/index/login">请登录</a>
                <a href="<?php echo APP_BASE ?>/index/register" style="color:#e1251b;">免费注册</a>
                <a href="<?php echo APP_BASE ?>/index/user">个人中心</a>
                <a href="<?php echo APP_BASE ?>/index/cart">购物车</a>
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
            <div class="head-cart"><i class="bi bi-cart3 me-1"></i>购物车<span class="cart-num">0</span></div>
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

    <div class="main-layout main-content">
        <div class="sidebar-left">
            <h3 class="sidebar-title"><i class="bi bi-map me-1"></i> 商城导航</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/index">商城首页</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/category">商品全部分类</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">精选特惠商品</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/cart">我的购物车</a></li>
            </ul>

            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-gift me-1"></i> 新用户专享</h3>
            <ul class="sidebar-list">
                <li><a href="#">注册送50元新人券</a></li>
                <li><a href="#">首单购物立减优惠</a></li>
                <li><a href="#">专属会员权益</a></li>
            </ul>

            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-clipboard-check me-1"></i> 注册须知</h3>
            <ul class="sidebar-list">
                <li><a href="#">账号使用协议</a></li>
                <li><a href="#">隐私保护政策</a></li>
            </ul>
        </div>

        <div class="content-middle">
            <div class="form-wrap">
                <h2 class="form-title"><i class="bi bi-person-plus me-2"></i>新用户注册</h2>
                <div id="error-msg" style="color:#e1251b;text-align:center;margin-bottom:10px;display:none;"></div>
                <div class="form-item">
                    <input type="text" id="username" placeholder="请设置登录账号">
                </div>
                <div class="form-item">
                    <input type="text" id="phone" placeholder="请输入手机号码">
                </div>
                <div class="form-item">
                    <input type="password" id="password" placeholder="请设置登录密码">
                </div>
                <div class="form-item">
                    <input type="password" id="password2" placeholder="请再次确认密码">
                </div>
                <div class="form-item captcha-item">
                    <input type="text" id="captcha" placeholder="请输入验证码">
                    <img id="captcha-img" src="<?php echo APP_BASE ?>/index/captcha" alt="验证码" onclick="refreshCaptcha()">
                    <a href="javascript:void(0)" onclick="refreshCaptcha()" class="refresh-captcha">换一张</a>
                </div>
                <div class="form-item">
                    <button class="form-btn btn-bs-primary" id="register-btn"><i class="bi bi-check2-circle me-1"></i>完成注册</button>
                </div>
                <div style="text-align:center;margin-top:15px;">
                    已有账号？<a href="<?php echo APP_BASE ?>/index/login" style="color:#e1251b;">前往登录</a>
                </div>
            </div>
        </div>

        <div class="sidebar-right">
            <h3 class="sidebar-title"><i class="bi bi-fire me-1"></i> 当下热卖</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">智能数码好物</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">家居日用百货</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/goods_list">潮流服饰鞋包</a></li>
            </ul>

            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-ticket-perforated me-1"></i> 优惠券专区</h3>
            <ul class="sidebar-list">
                <li><a href="#">大额满减优惠券</a></li>
                <li><a href="#">品类专属优惠券</a></li>
            </ul>

            <h3 class="sidebar-title" style="margin-top:20px;"><i class="bi bi-life-preserver me-1"></i> 帮助支持</h3>
            <ul class="sidebar-list">
                <li><a href="<?php echo APP_BASE ?>/index/help">帮助中心</a></li>
                <li><a href="#">在线客服</a></li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>热卖商城 &copy;2026 版权所有 | 客服热线：00-123-4567 | 地址：线上电商产业园</p>
    </div>
    <div class="back-top"><i class="bi bi-arrow-up"></i></div>

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
            }, 1000);
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

        function refreshCaptcha() {
            const captchaImg = document.getElementById('captcha-img');
            captchaImg.src = '<?php echo APP_BASE ?>/index/captcha?' + Date.now();
        }

        const registerBtn = document.getElementById('register-btn');
        const errorMsg = document.getElementById('error-msg');
        registerBtn.addEventListener('click', () => {
            const username = document.getElementById('username').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const password = document.getElementById('password').value;
            const password2 = document.getElementById('password2').value;
            const captcha = document.getElementById('captcha').value.trim();

            if (!username || !password) {
                errorMsg.textContent = '用户名和密码不能为空';
                errorMsg.style.display = 'block';
                return;
            }

            if (password !== password2) {
                errorMsg.textContent = '两次密码不一致';
                errorMsg.style.display = 'block';
                return;
            }

            if (username.length < 3 || username.length > 20) {
                errorMsg.textContent = '用户名长度3-20位';
                errorMsg.style.display = 'block';
                return;
            }

            if (password.length < 6) {
                errorMsg.textContent = '密码至少6位';
                errorMsg.style.display = 'block';
                return;
            }

            if (!captcha) {
                errorMsg.textContent = '请输入验证码';
                errorMsg.style.display = 'block';
                return;
            }

            registerBtn.disabled = true;
            registerBtn.textContent = '注册中...';

            fetch('<?php echo APP_BASE ?>/index/user/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password) + '&password2=' + encodeURIComponent(password2) + '&phone=' + encodeURIComponent(phone) + '&captcha=' + encodeURIComponent(captcha)
                })
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200) {
                        errorMsg.style.display = 'none';
                        alert('注册成功');
                        location.href = '<?php echo APP_BASE ?>/index/login';
                    } else {
                        errorMsg.textContent = data.msg;
                        errorMsg.style.display = 'block';
                        registerBtn.disabled = false;
                        registerBtn.textContent = '完成注册';
                        if (data.code === 400 && data.msg.includes('验证码')) {
                            refreshCaptcha();
                            document.getElementById('captcha').value = '';
                        }
                    }
                })
                .catch(() => {
                    errorMsg.textContent = '网络错误，请重试';
                    errorMsg.style.display = 'block';
                    registerBtn.disabled = false;
                    registerBtn.textContent = '完成注册';
                });
        });
    </script>
</body>

</html>