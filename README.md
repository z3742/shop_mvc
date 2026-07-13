# 热卖商城 - PHP原生MVC电商系统

## 项目简介

热卖商城是一个基于 **PHP原生MVC框架** 开发的电商系统，采用面向对象设计思想，实现了商品展示、购物车、订单管理、用户注册登录等完整的电商功能。

## 技术栈

| 分类 | 技术 | 版本 |
|------|------|------|
| 语言 | PHP | 7.4+ |
| 数据库 | MySQL | 5.7+ |
| 服务器 | Apache | 2.4+ |
| 验证码 | Gregwar/Captcha | ^1.2 |
| 前端 | HTML/CSS/JavaScript | - |

## 项目结构

```
shop_mvc/
├── app/                    # 应用目录
│   ├── config/            # 配置文件
│   │   ├── config.php     # 全局配置（数据库、商品参数）
│   │   └── router.php     # 路由规则
│   ├── http/              # 控制器层
│   │   └── home/          # 前台控制器
│   │       ├── indexcontroller.php   # 首页控制器
│   │       ├── usercontroller.php    # 用户控制器
│   │       ├── goodscontroller.php   # 商品控制器
│   │       ├── cartcontroller.php    # 购物车控制器
│   │       └── categorycontroller.php # 分类控制器
│   └── model/             # 模型层
│       ├── usermodel.php      # 用户模型
│       ├── goodsmodel.php     # 商品模型
│       ├── cartmodel.php      # 购物车模型
│       ├── categorymodel.php  # 分类模型
│       ├── ordermodel.php     # 订单模型
│       ├── addressmodel.php   # 地址模型
│       └── indexmodel.php     # 首页模型
├── framework/             # 框架核心
│   ├── app.php            # 应用入口类（路由分发）
│   ├── db.php             # 数据库操作类（PDO封装）
│   └── model.php          # 模型基类
├── public/                # 公共目录（Web根目录）
│   ├── .htaccess          # URL重写规则
│   └── index.php          # 项目入口文件
├── resources/             # 资源目录
│   ├── css/               # 样式文件
│   ├── images/            # 图片资源
│   │   ├── banner/        # 轮播图
│   │   ├── goods/         # 商品图片（用户上传）
│   │   └── avatar/        # 用户头像
│   └── views/             # 视图模板
├── database/              # 数据库脚本
│   └── shop_db.sql        # 数据库初始化脚本
├── composer.json          # Composer配置
├── Dockerfile             # Docker配置
└── .htaccess              # 根目录重写规则
```

## 安装步骤

### 1. 环境要求

- PHP 7.4+（开启PDO、GD扩展）
- MySQL 5.7+
- Apache 2.4+（开启mod_rewrite）
- Composer

### 2. 克隆项目

```bash
git clone <repository-url>
cd shop_mvc
```

### 3. 安装依赖

```bash
composer install
```

### 4. 配置数据库

创建数据库并导入初始化脚本：

```bash
mysql -u root -p
CREATE DATABASE shop_db DEFAULT CHARACTER SET utf8mb4;
USE shop_db;
source database/shop_db.sql;
```

修改数据库配置 [app/config/config.php](file:///C:/wamp64/www/shop_mvc/app/config/config.php)：

```php
return [
    'db' => [
        'host'     => 'localhost',
        'dbname'   => 'shop_db',
        'username' => 'root',
        'password' => '',
        'charset'  => 'utf8mb4',
        'port'     => '3306',
    ],
    // ...
];
```

### 5. 配置Apache虚拟主机

编辑 `httpd-vhosts.conf`：

```apache
<VirtualHost *:80>
    ServerName shop-mvc.local
    DocumentRoot "c:/wamp64/www/shop_mvc/public"
    <Directory "c:/wamp64/www/shop_mvc/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

修改 `hosts` 文件：

```
127.0.0.1 shop-mvc.local
```

### 6. 启动服务

```bash
# 重启Apache
service apache2 restart  # Linux
# 或
httpd -k restart         # Windows
```

访问：`http://shop-mvc.local`

## 功能模块

### 1. 用户模块
- 用户注册（含验证码验证）
- 用户登录（密码哈希验证）
- 用户信息管理
- 管理员权限控制

### 2. 商品模块
- 商品分类展示
- 商品列表分页
- 商品详情页
- 商品搜索（支持名称搜索）
- 用户上传商品（需管理员审核）

### 3. 购物车模块
- 添加商品到购物车
- 修改购物车数量
- 删除购物车商品
- 购物车结算

### 4. 订单模块
- 创建订单
- 订单列表
- 订单状态管理

### 5. 首页模块
- Banner轮播
- 热门商品
- 分类导航

## 核心技术实现

### URL重写

通过 `.htaccess` 实现URL重写，隐藏入口文件：

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?pathinfo=$1 [QSA,L]
```

### 路由分发

路由规则配置在 [app/config/router.php](file:///C:/wamp64/www/shop_mvc/app/config/router.php)，框架自动匹配控制器和方法：

```php
$GLOBALS['route'] = [
    'index/index' => 'home/indexcontroller/index',
    'index/login' => 'home/indexcontroller/login',
    // ...
];
```

### 密码安全

注册时使用 `password_hash()` 加密：

```php
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
```

登录时使用 `password_verify()` 验证：

```php
password_verify($password, $user['password']);
```

### 验证码验证

使用 `Gregwar/Captcha` 生成验证码图片，存储在Session中进行双端验证。

### 分页查询

使用 `LIMIT ? OFFSET ?` 实现分页：

```php
$offset = ($page - 1) * $pageSize;
$sql = "SELECT * FROM goods LIMIT ? OFFSET ?";
```

## 数据库表结构

| 表名 | 说明 | 核心字段 |
|------|------|----------|
| `user` | 用户表 | user_id, username, password, type |
| `goods` | 商品表 | goods_id, goods_name, price, cat_id, status |
| `cart` | 购物车表 | cart_id, user_id, goods_id, quantity |
| `category` | 分类表 | cat_id, cat_name, parent_id |
| `order` | 订单表 | order_id, order_sn, user_id, total_amount, status |
| `address` | 收货地址表 | address_id, user_id, province, city, detail |

## 访问方式

### 本地访问

```
http://localhost/shop_mvc/
```

### 局域网访问

```
http://[本机IP]/shop_mvc/
```

### 默认账号

- 管理员：admin / admin123
- 普通用户：可自行注册

## Docker部署

```bash
# 构建镜像
docker build -t shop-mvc .

# 运行容器
docker run -p 80:80 \
  -e DB_HOST=mysql_host \
  -e DB_NAME=shop_db \
  -e DB_USER=root \
  -e DB_PASS=password \
  -e APP_BASE=/ \
  shop-mvc
```

## 注意事项

1. **文件权限**：确保 `resources/images/goods/` 目录有写入权限
2. **Session配置**：确保PHP Session目录可写
3. **安全配置**：生产环境需禁用错误输出，配置HTTPS
4. **防火墙**：局域网访问需开放80端口

## License

MIT License