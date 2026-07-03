<?php
return [
    'db' => [
        'host'     => getenv('DB_HOST')     ?: 'localhost',
        'dbname'   => getenv('DB_NAME')     ?: 'shop_db', // 你的数据库名
        'username' => getenv('DB_USER')     ?: 'root',    // 你的数据库账号
        'password' => getenv('DB_PASS')     ?: '',        // 你的数据库密码
        'charset'  => 'utf8mb4',
        'port'     => getenv('DB_PORT')     ?: '3306',    // 端口号
    ],
    'goods' => [
        'random_count'    => 20,   // 首页随机商品数量
        'hot_count'       => 8,    // 首页热门商品数量
        'page_size'       => 12,   // 分页大小
        'hot_goods_limit' => 6,    // API热门商品默认数量
    ]
];