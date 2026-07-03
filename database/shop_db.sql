-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2026-06-02 11:23:40
-- 服务器版本： 9.1.0
-- PHP 版本： 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `shop_db`
--

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `goods_id` int DEFAULT NULL,
  `goods_num` int DEFAULT '1',
  PRIMARY KEY (`cart_id`),
  UNIQUE KEY `uk_user_goods` (`user_id`,`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(50) DEFAULT NULL,
  `is_show` tinyint DEFAULT '1',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `is_show`) VALUES
(1, '手机数码', 1),
(2, '美妆护肤', 1),
(3, '生活工具', 1),
(4, '数码配件', 1),
(5, '内衣服饰', 1),
(6, '工具用品', 1),
(7, '其他商品', 1);

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

DROP TABLE IF EXISTS `goods`;
CREATE TABLE IF NOT EXISTS `goods` (
  `goods_id` int NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(100) DEFAULT NULL,
  `goods_img` varchar(100) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `stock` int DEFAULT '100',
  `goods_desc` text,
  `cat_id` int DEFAULT NULL,
  `is_hot` tinyint DEFAULT '0',
  `is_sale` tinyint DEFAULT '1',
  `status` tinyint DEFAULT '1' COMMENT '0-待审核, 1-已上架, 2-已下架',
  `user_id` int DEFAULT '0' COMMENT '上架商品的用户ID',
  `audit_time` datetime DEFAULT NULL COMMENT '审核时间',
  `audit_user_id` int DEFAULT NULL COMMENT '审核用户ID',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `goods`
--

INSERT INTO `goods` (`goods_id`, `goods_name`, `goods_img`, `goods_price`, `stock`, `goods_desc`, `cat_id`, `is_hot`, `is_sale`, `status`, `user_id`, `audit_time`, `audit_user_id`) VALUES
(1, '智能手机', 'goods-phones/goods-phone.jpg', 2999.00, 100, '高性能智能手机，搭载最新处理器', 1, 1, 1, 1, 1, '2026-06-01 10:00:00', 1),
(2, '智能手机Pro', 'goods-phones/goods-phone1.jpg', 3999.00, 100, 'Pro版智能手机，更大屏幕', 1, 1, 1, 1, 1, '2026-06-01 10:01:00', 1),
(3, '智能手机Max', 'goods-phones/goods-phone2.jpg', 4999.00, 100, 'Max版智能手机，顶级配置', 1, 0, 1, 1, 1, '2026-06-01 10:02:00', 1),
(4, '智能手机Ultra', 'goods-phones/goods-phone3.jpg', 5999.00, 100, 'Ultra版智能手机，旗舰体验', 1, 1, 1, 1, 1, '2026-06-01 10:03:00', 1),
(5, '智能手机Plus', 'goods-phones/goods-phone4.jpg', 3499.00, 100, 'Plus版智能手机，性价比之选', 1, 0, 1, 1, 1, '2026-06-01 10:04:00', 1),
(6, '护肤套装', 'goods-meizhuangs/goods-meizhuang.jpg', 299.00, 100, '精选护肤套装，滋养肌肤', 2, 1, 1, 1, 2, '2026-06-01 10:05:00', 1),
(7, '美容精华', 'goods-meizhuangs/goods-meizhuang1.jpg', 399.00, 100, '高浓度美容精华液', 2, 0, 1, 1, 2, '2026-06-01 10:06:00', 1),
(8, '彩妆套装', 'goods-meizhuangs/goods-meizhuang2.jpg', 199.00, 100, '专业彩妆套装', 2, 1, 1, 1, 2, '2026-06-01 10:07:00', 1),
(9, '面膜套装', 'goods-meizhuangs/goods-meizhuang3.jpg', 159.00, 100, '补水保湿面膜套装', 2, 0, 1, 1, 2, '2026-06-01 10:08:00', 1),
(10, '护肤礼盒', 'goods-meizhuangs/goods-meizhuang4.jpg', 499.00, 100, '精美护肤礼盒', 2, 1, 1, 1, 2, '2026-06-01 10:09:00', 1),
(11, '生活工具套装', 'goods-lifetools/goods-lifetool.jpg', 99.00, 100, '多功能生活工具套装', 3, 0, 1, 1, 2, '2026-06-01 10:10:00', 1),
(12, '多功能工具', 'goods-lifetools/goods-lifetool1.jpg', 129.00, 100, '家用多功能工具', 3, 1, 1, 1, 2, '2026-06-01 10:11:00', 1),
(13, '家用工具组', 'goods-lifetools/goods-lifetool2.jpg', 199.00, 100, '专业家用工具组', 3, 0, 1, 1, 2, '2026-06-01 10:12:00', 1),
(14, '厨房工具', 'goods-lifetools/goods-lifetool3.jpg', 89.00, 100, '实用厨房工具', 3, 1, 1, 1, 2, '2026-06-01 10:13:00', 1),
(15, '清洁工具套装', 'goods-lifetools/goods-lifetool4.jpg', 79.00, 100, '家庭清洁工具套装', 3, 0, 1, 1, 2, '2026-06-01 10:14:00', 1),
(16, '无线耳机', 'goods-erjis/goods-erji.jpg', 299.00, 100, '高品质无线蓝牙耳机', 4, 1, 1, 1, 1, '2026-06-01 10:15:00', 1),
(17, '降噪耳机', 'goods-erjis/goods-erji1.jpg', 499.00, 100, '主动降噪耳机', 4, 1, 1, 1, 1, '2026-06-01 10:16:00', 1),
(18, '运动耳机', 'goods-erjis/goods-erji2.jpg', 199.00, 100, '防水运动蓝牙耳机', 4, 0, 1, 1, 1, '2026-06-01 10:17:00', 1),
(19, '入耳式耳机', 'goods-erjis/goods-erji3.jpg', 159.00, 100, '高品质入耳式耳机', 4, 0, 1, 1, 1, '2026-06-01 10:18:00', 1),
(20, '头戴式耳机', 'goods-erjis/goods-erji4.jpg', 399.00, 100, '舒适头戴式耳机', 4, 1, 1, 1, 1, '2026-06-01 10:19:00', 1),
(21, '舒适内衣', 'goods-neikus/goods-neiku.jpg', 99.00, 100, '柔软舒适内衣', 5, 0, 1, 1, 2, '2026-06-01 10:20:00', 1),
(22, '纯棉内衣', 'goods-neikus/goods-neiku1.jpg', 129.00, 100, '100%纯棉内衣', 5, 1, 1, 1, 2, '2026-06-01 10:21:00', 1),
(23, '莫代尔内衣', 'goods-neikus/goods-neiku2.jpg', 149.00, 100, '莫代尔面料内衣', 5, 0, 1, 1, 2, '2026-06-01 10:22:00', 1),
(24, '保暖内衣', 'goods-neikus/goods-neiku3.jpg', 199.00, 100, '加厚保暖内衣', 5, 1, 1, 1, 2, '2026-06-01 10:23:00', 1),
(25, '无痕内衣', 'goods-neikus/goods-neiku4.jpg', 169.00, 100, '无痕设计内衣', 5, 0, 1, 1, 2, '2026-06-01 10:24:00', 1),
(26, '运动内衣', 'goods-neikus/goods-neiku5.jpg', 179.00, 100, '专业运动内衣', 5, 1, 1, 1, 2, '2026-06-01 10:25:00', 1),
(27, '工具箱', 'goods-tools/goods-tool.jpg', 299.00, 100, '多功能工具箱', 6, 0, 1, 1, 1, '2026-06-01 10:26:00', 1),
(28, '电工工具', 'goods-tools/goods-tool1.jpg', 399.00, 100, '专业电工工具组', 6, 1, 1, 1, 1, '2026-06-01 10:27:00', 1),
(29, '木工工具', 'goods-tools/goods-tool2.jpg', 349.00, 100, '专业木工工具组', 6, 0, 1, 1, 1, '2026-06-01 10:28:00', 1),
(30, '维修工具', 'goods-tools/goods-tool3.jpg', 199.00, 100, '家用维修工具组', 6, 1, 1, 1, 1, '2026-06-01 10:29:00', 1),
(31, '测量工具', 'goods-tools/goods-tool4.jpg', 159.00, 100, '精密测量工具组', 6, 0, 1, 1, 1, '2026-06-01 10:30:00', 1),
(32, '办公桌', 'goods/banggongzhuo.jpg', 899.00, 100, '简约办公书桌', 7, 0, 1, 1, 2, '2026-06-01 10:31:00', 1),
(33, '台灯', 'goods/dengju.jpg', 199.00, 100, '护眼LED台灯', 7, 1, 1, 1, 2, '2026-06-01 10:32:00', 1),
(34, '防晒霜', 'goods/fengsai.jpg', 129.00, 100, '高倍防晒霜', 2, 0, 1, 1, 2, '2026-06-01 10:33:00', 1),
(35, '轮胎', 'goods/luntai1.jpg', 599.00, 100, '高性能汽车轮胎', 7, 1, 1, 1, 1, '2026-06-01 10:34:00', 1),
(36, '轮胎Pro', 'goods/goods-luntai1.jpg', 799.00, 100, '顶级性能轮胎', 7, 0, 1, 1, 1, '2026-06-01 10:35:00', 1),
(37, '墨镜', 'goods/maojing.jpg', 299.00, 100, '时尚太阳镜', 7, 1, 1, 1, 2, '2026-06-01 10:36:00', 1),
(38, '内衣', 'goods/neiyi.jpg', 159.00, 100, '舒适内衣', 5, 0, 1, 1, 2, '2026-06-01 10:37:00', 1),
(39, '牛仔裤', 'goods/niuzaiku.jpg', 259.00, 100, '经典牛仔裤', 5, 1, 1, 1, 2, '2026-06-01 10:38:00', 1),
(40, '相机', 'goods/xiangji.jpg', 3999.00, 100, '高清数码相机', 1, 1, 1, 1, 1, '2026-06-01 10:39:00', 1),
(41, '转接器', 'goods/zhuangjieqi.jpg', 99.00, 100, '多功能转接器', 7, 0, 1, 1, 1, '2026-06-01 10:40:00', 1),
(42, '智能手表', 'goods-phones/goods-phone.jpg', 1599.00, 50, '智能运动手表', 1, 1, 1, 1, 1, '2026-06-02 09:00:00', 1),
(43, '平板电脑', 'goods-phones/goods-phone1.jpg', 2999.00, 50, '轻薄便携平板电脑', 1, 1, 1, 1, 1, '2026-06-02 09:01:00', 1),
(44, '蓝牙音箱', 'goods-phones/goods-phone2.jpg', 399.00, 80, '便携式蓝牙音箱', 1, 0, 1, 1, 1, '2026-06-02 09:02:00', 1),
(45, '充电宝', 'goods-phones/goods-phone3.jpg', 199.00, 100, '大容量移动电源', 1, 0, 1, 1, 1, '2026-06-02 09:03:00', 1),
(46, '手机壳', 'goods-phones/goods-phone4.jpg', 49.00, 200, '防摔手机壳', 4, 0, 1, 1, 2, '2026-06-02 09:04:00', 1),
(47, '口红套装', 'goods-meizhuangs/goods-meizhuang.jpg', 259.00, 80, '多色口红套装', 2, 1, 1, 1, 2, '2026-06-02 09:05:00', 1),
(48, '粉底液', 'goods-meizhuangs/goods-meizhuang1.jpg', 299.00, 60, '遮瑕粉底液', 2, 0, 1, 1, 2, '2026-06-02 09:06:00', 1),
(49, '眼影盘', 'goods-meizhuangs/goods-meizhuang2.jpg', 169.00, 80, '大地色眼影盘', 2, 0, 1, 1, 2, '2026-06-02 09:07:00', 1),
(50, '卸妆水', 'goods-meizhuangs/goods-meizhuang3.jpg', 89.00, 100, '温和卸妆水', 2, 0, 1, 1, 2, '2026-06-02 09:08:00', 1),
(51, '精华液', 'goods-meizhuangs/goods-meizhuang4.jpg', 359.00, 50, '保湿精华液', 2, 1, 1, 1, 2, '2026-06-02 09:09:00', 1),
(52, '洗衣液', 'goods-lifetools/goods-lifetool.jpg', 49.00, 150, '浓缩洗衣液', 3, 0, 1, 1, 2, '2026-06-02 09:10:00', 1),
(53, '洗洁精', 'goods-lifetools/goods-lifetool1.jpg', 29.00, 200, '食品级洗洁精', 3, 0, 1, 1, 2, '2026-06-02 09:11:00', 1),
(54, '拖把', 'goods-lifetools/goods-lifetool2.jpg', 89.00, 100, '旋转拖把', 3, 0, 1, 1, 2, '2026-06-02 09:12:00', 1),
(55, '垃圾桶', 'goods-lifetools/goods-lifetool3.jpg', 59.00, 100, '分类垃圾桶', 3, 0, 1, 1, 2, '2026-06-02 09:13:00', 1),
(56, '收纳盒', 'goods-lifetools/goods-lifetool4.jpg', 39.00, 150, '多功能收纳盒', 3, 1, 1, 1, 2, '2026-06-02 09:14:00', 1),
(57, '数据线', 'goods-erjis/goods-erji.jpg', 39.00, 200, '快充数据线', 4, 0, 1, 1, 1, '2026-06-02 09:15:00', 1),
(58, '充电器', 'goods-erjis/goods-erji1.jpg', 79.00, 100, '快速充电器', 4, 0, 1, 1, 1, '2026-06-02 09:16:00', 1),
(59, '充电宝', 'goods-erjis/goods-erji2.jpg', 159.00, 100, '迷你充电宝', 4, 1, 1, 1, 1, '2026-06-02 09:17:00', 1),
(60, '手机支架', 'goods-erjis/goods-erji3.jpg', 29.00, 150, '桌面手机支架', 4, 0, 1, 1, 1, '2026-06-02 09:18:00', 1),
(61, '耳机套', 'goods-erjis/goods-erji4.jpg', 25.00, 200, '耳机保护套', 4, 0, 1, 1, 1, '2026-06-02 09:19:00', 1),
(62, '男士内裤', 'goods-neikus/goods-neiku.jpg', 69.00, 100, '纯棉男士内裤', 5, 0, 1, 1, 2, '2026-06-02 09:20:00', 1),
(63, '女士内裤', 'goods-neikus/goods-neiku1.jpg', 59.00, 100, '无痕女士内裤', 5, 1, 1, 1, 2, '2026-06-02 09:21:00', 1),
(64, '袜子套装', 'goods-neikus/goods-neiku2.jpg', 39.00, 150, '纯棉袜子套装', 5, 0, 1, 1, 2, '2026-06-02 09:22:00', 1),
(65, '睡衣', 'goods-neikus/goods-neiku3.jpg', 129.00, 80, '纯棉睡衣套装', 5, 1, 1, 1, 2, '2026-06-02 09:23:00', 1),
(66, '毛巾', 'goods-neikus/goods-neiku4.jpg', 29.00, 200, '纯棉毛巾', 5, 0, 1, 1, 2, '2026-06-02 09:24:00', 1),
(67, '浴巾', 'goods-neikus/goods-neiku5.jpg', 69.00, 100, '纯棉浴巾', 5, 0, 1, 1, 2, '2026-06-02 09:25:00', 1),
(68, '扳手套装', 'goods-tools/goods-tool.jpg', 199.00, 80, '多功能扳手套装', 6, 0, 1, 1, 1, '2026-06-02 09:26:00', 1),
(69, '螺丝刀组', 'goods-tools/goods-tool1.jpg', 129.00, 100, '精密螺丝刀组', 6, 1, 1, 1, 1, '2026-06-02 09:27:00', 1),
(70, '电钻', 'goods-tools/goods-tool2.jpg', 499.00, 50, '充电电钻', 6, 1, 1, 1, 1, '2026-06-02 09:28:00', 1),
(71, '钳子套装', 'goods-tools/goods-tool3.jpg', 89.00, 100, '多功能钳子套装', 6, 0, 1, 1, 1, '2026-06-02 09:29:00', 1),
(72, '卷尺', 'goods-tools/goods-tool4.jpg', 39.00, 150, '钢卷尺', 6, 0, 1, 1, 1, '2026-06-02 09:30:00', 1),
(73, '显示器', 'goods/goods1.jpg', 1299.00, 50, '27英寸显示器', 7, 1, 1, 1, 1, '2026-06-02 09:31:00', 1),
(74, '键盘', 'goods/goods2.jpg', 299.00, 80, '机械键盘', 7, 1, 1, 1, 1, '2026-06-02 09:32:00', 1),
(75, '鼠标', 'goods/goods3.jpg', 149.00, 100, '无线鼠标', 7, 0, 1, 1, 1, '2026-06-02 09:33:00', 1),
(76, '路由器', 'goods/banggongzhuo.jpg', 199.00, 80, '千兆路由器', 7, 0, 1, 1, 2, '2026-06-02 09:34:00', 1),
(77, '插座', 'goods/dengju.jpg', 49.00, 150, '智能插座', 7, 0, 1, 1, 2, '2026-06-02 09:35:00', 1),
(78, '硬盘', 'goods/fengsai.jpg', 499.00, 60, '移动硬盘', 7, 1, 1, 1, 2, '2026-06-02 09:36:00', 1);

-- --------------------------------------------------------

--
-- 表的结构 `banner`
--

DROP TABLE IF EXISTS `banner`;
CREATE TABLE IF NOT EXISTS `banner` (
  `banner_id` int NOT NULL AUTO_INCREMENT,
  `banner_title` varchar(100) DEFAULT NULL,
  `banner_img` varchar(200) DEFAULT NULL,
  `banner_url` varchar(200) DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_show` tinyint DEFAULT '1',
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `banner`
--

INSERT INTO `banner` (`banner_id`, `banner_title`, `banner_img`, `banner_url`, `sort_order`, `is_show`) VALUES
(1, '数码好物 限时特惠', 'banner/banner1.jpg', '/shop_mvc/index/goods_list?cat_id=1', 1, 1),
(2, '美妆护肤 品质优选', 'banner/banner2.jpg', '/shop_mvc/index/goods_list?cat_id=2', 2, 1),
(3, '生活工具 超值特惠', 'banner/banner3.jpg', '/shop_mvc/index/goods_list?cat_id=3', 3, 1),
(4, '内衣服饰 新品上架', 'banner/banner4.jpg', '/shop_mvc/index/goods_list?cat_id=5', 4, 1),
(5, '工具用品 精选好货', 'banner/banner5.jpg', '/shop_mvc/index/goods_list?cat_id=6', 5, 1);

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(32) NOT NULL,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` tinyint DEFAULT '0' COMMENT '0待付款 1已付款 2已发货 3已完成 4已取消',
  `consignee` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_sn` (`order_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 表的结构 `order_goods`
--

DROP TABLE IF EXISTS `order_goods`;
CREATE TABLE IF NOT EXISTS `order_goods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `goods_id` int NOT NULL,
  `goods_name` varchar(100) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `goods_num` int DEFAULT NULL,
  `goods_img` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `type` tinyint DEFAULT '0' COMMENT '0-普通用户, 1-管理员',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 插入测试用户数据
--

INSERT INTO `user` (`user_id`, `username`, `password`, `phone`, `type`) VALUES
(1, 'admin', '$2y$10$e9VYssmeLwdy5qCy8Yty6O9SQs6aG7aSsmQnIUOXz0n5HsYSoWmo.', '', 1),
(2, 'testuser', '$2y$10$TOkL8Ht5RbqhIzV4AZBiLePYy/QEUW.HSmAi.pH9cOm3C4eT5kE6cC', '13800138000', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user_address`
--

DROP TABLE IF EXISTS `user_address`;
CREATE TABLE IF NOT EXISTS `user_address` (
  `addr_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `consignee` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `province` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `district` varchar(20) DEFAULT NULL,
  `detail_addr` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`addr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
