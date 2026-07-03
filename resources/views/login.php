<?php
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录 - 热卖商城</title>
    <link rel="stylesheet" href="<?php echo APP_BASE ?>/resources/css/style.css">
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
                <a href="<?php echo APP_BASE ?>/index/login" style="color:#e1251b;">请登录</a>
                <a href="<?php echo APP_BASE ?>/index/register">免费注册</a>
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
            <div class="search-box">
                <input type="text" class="search-input" placeholder="请输入商品名称">
                <button class="search-btn">搜索</button>
            </div>
            <div class="head-cart">购物车<span class="cart-num">0</span></div>
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
            <h3 class="sidebar-title">📋 用户中心</h3>
            <ul class="sidebar-list">
                <li class="active"><a href="<?php echo APP_BASE ?>/index/login">用户登录</a></li>
                <li><a href="<?php echo APP_BASE ?>/index/register">用户注册</a></li>
            </ul>
        </div>

        <div class="content-middle">
            <div class="goods-header">
                <div class="goods-title">
                    <span class="title-icon">🔐</span>
                    <span>用户登录</span>
                </div>
            </div>

            <div class="form-wrap">
                <h2 class="form-title">🔐 用户登录</h2>
                <div class="form-item">
                    <label for="username">用户名</label>
                    <input type="text" id="username" name="username" placeholder="请输入用户名">
                </div>
                <div class="form-item">
                    <label for="password">密码</label>
                    <input type="password" id="password" name="password" placeholder="请输入密码">
                </div>
                <div class="error-msg" id="error-msg" style="display: none;"></div>
                <button id="login-btn" class="form-btn">立即登录</button>
                <p class="link-text" style="text-align: center; margin-top: 15px;">
                    还没有账号？<a href="<?php echo APP_BASE ?>/index/register">立即注册</a>
                </p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>热卖商城 ©2026 版权所有 | 客服热线：400-123-4567 | 地址：线上电商产业园</p>
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
        });

        function showToast(text) {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.innerText = text;
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2000);
            }
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

        const loginBtn = document.getElementById('login-btn');
        const errorMsg = document.getElementById('error-msg');
        loginBtn.addEventListener('click', () => {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;

            if (!username || !password) {
                errorMsg.textContent = '请输入用户名和密码';
                errorMsg.style.display = 'block';
                return;
            }

            fetch('<?php echo APP_BASE ?>/index/user/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password)
                })
                .then(r => r.text())
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        throw new Error('解析响应失败');
                    }

                    if (data.code === 200) {
                        showToast('登录成功');
                        setTimeout(() => {
                            window.location.href = '<?php echo APP_BASE ?>/index/index';
                        }, 1000);
                    } else {
                        errorMsg.textContent = data.msg || '登录失败';
                        errorMsg.style.display = 'block';
                    }
                })
                .catch(err => {
                    console.error('登录错误', err);
                    errorMsg.textContent = '网络错误，请稍后重试';
                    errorMsg.style.display = 'block';
                });
        });
    </script>
</body>

</html>