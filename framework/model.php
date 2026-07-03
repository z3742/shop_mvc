<?php
/**
 * Model Base Class
 * 模型基类 - 所有业务模型的父类
 * 
 * 负责初始化数据库连接，提供统一的数据库访问入口。
 * 所有业务模型（如 UserModel、GoodsModel）都继承此类，
 * 从而自动获得数据库操作能力。
 * 
 * @author Shop MVC Framework
 * @version 1.0.0
 */

namespace framework;

/**
 * Model Base Class
 * 模型基类，提供数据库连接初始化
 */
class model
{
    /**
     * @var db $db 数据库操作对象
     */
    protected $db;

    /**
     * Constructor
     * 构造函数 - 初始化数据库连接
     */
    public function __construct()
    {
        // 初始化数据库连接
        $this->initDB();        
    }

    /**
     * Initialize database connection
     * 初始化数据库连接
     * 
     * 从全局配置中获取数据库配置，初始化单例数据库实例，
     * 将数据库操作对象赋值给 $db 属性，供子类使用。
     * 
     * @return void
     */
    protected function initDB()
    {
        // 从全局配置中获取数据库连接信息
        // 配置文件路径：app/config/config.php
        $dbConfig = $GLOBALS['config']['db'];
        
        // 初始化数据库单例配置
        db::init($dbConfig);
        
        // 获取数据库单例实例
        $this->db = db::getInstance();
    }
}
