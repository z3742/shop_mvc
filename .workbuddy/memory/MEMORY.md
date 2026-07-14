# 热卖商城 - 项目长期记忆

## 项目架构
- PHP 8.2 + MySQL + Apache (WAMP环境, 端口80)
- 自定义MVC框架: framework/ (app.php, db.php, model.php)
- 二级路由: app/config/router.php (如 user/login, cart/add, goods/hot)
- 控制器: app/http/home/ (indexcontroller, goodscontroller, usercontroller, cartcontroller)
- 模型: app/model/ (小写命名如 goodsmodel.php)
- 视图: resources/views/ (纯PHP, 内联JS)
- 样式: resources/css/style.css (单文件CSS系统)

## 2026-07-13 网站完善
- 样式从红色传统电商升级为深蓝玻璃拟态+深色模式
- 新增核心功能: 限时秒杀(含倒计时)、热销排行榜、最近浏览记录
- 商品列表新增排序(价格/销量)和价格筛选功能
- 商品详情新增相关推荐和最近浏览
- 新增模型: flashsalemodel, recentlyviewedmodel
- goods表新增sales字段

## 设计偏好
- 用户偏好深蓝+白简洁专业风格
- 深色模式切换为必备功能
