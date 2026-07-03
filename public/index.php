<?php
session_start();
define('VIEW_PATH', '../resources/views/');
// 部署时通过环境变量设置，本地开发默认 /shop_mvc ?:空值合并预算符
define('APP_BASE', rtrim(getenv('APP_BASE') ?: '/shop_mvc', '/'));

try {
    // 引入 Composer 自动加载
    require "../vendor/autoload.php";

    require "../framework/app.php";

    $app = new framework\app();
    $app->run();
} catch (Exception $e) {
    echo json_encode(['code' => 500, 'msg' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
}
