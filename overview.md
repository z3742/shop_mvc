# 热卖商城 - Bootstrap 5 前端样式优化

## 完成概述

使用 Bootstrap 5.3.3 全面优化了网站前端样式，着重提升了用户交互体验。在保持原有深蓝玻璃拟态主题的基础上，融合 Bootstrap 组件系统，实现了现代化的 UI 升级。

## 主要改动

### 1. 新建自定义样式文件
- **文件**: `resources/css/bootstrap-custom.css`
- 将 Bootstrap 5 变量映射到现有深蓝主题变量
- 定制 Navbar、Offcanvas、List Group、Button 等组件样式
- 深色模式完整适配
- 磁吸动画、玻璃拟态效果增强

### 2. 全站 9 个页面 Bootstrap 集成

| 页面 | 主要升级内容 |
|------|-------------|
| index.php | Bootstrap Navbar + Offcanvas + Icons + Tooltip + 主题切换图标 |
| goods_list.php | Navbar + Icons + btn-bs-outline按钮 + 侧边栏图标 |
| goods_detail.php | Navbar + 收藏/购物车按钮图标 + 侧边栏图标 |
| cart.php | Navbar + 空状态图标 + 侧边栏图标 |
| login.php | Navbar + 登录按钮图标 + 表单标题图标 |
| register.php | Navbar + 注册按钮图标 + 验证码区域图标 |
| category.php | Navbar + 分类侧边栏图标 |
| help.php | Navbar + 帮助分类图标 |
| user.php | Navbar + 个人中心菜单图标 + 优惠券/积分图标 |

### 3. 交互体验提升
- **Bootstrap Navbar**: 粘性定位 + 移动端 Offcanvas 侧滑菜单
- **Bootstrap Icons**: 全站 emoji 替换为矢量图标（搜索、购物车、导航、侧边栏等）
- **Tooltip**: 购物车图标添加悬浮提示
- **按钮增强**: btn-bs-primary / btn-bs-outline 自定义按钮样式
- **主题切换**: 使用 Bootstrap Icons 月亮/太阳图标动态切换
- **返回顶部**: Bootstrap Icons 上箭头图标

### 4. 技术栈
- Bootstrap 5.3.3 (CSS + JS Bundle)
- Bootstrap Icons 1.11.3
- 自定义 bootstrap-custom.css 覆盖层
- CDN 引入，无需本地安装

## 文件变更清单
- 新增: `resources/css/bootstrap-custom.css`
- 修改: `resources/views/index.php`
- 修改: `resources/views/goods_list.php`
- 修改: `resources/views/goods_detail.php`
- 修改: `resources/views/cart.php`
- 修改: `resources/views/login.php`
- 修改: `resources/views/register.php`
- 修改: `resources/views/category.php`
- 修改: `resources/views/help.php`
- 修改: `resources/views/user.php`
