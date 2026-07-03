<?php
/**
 * Database Connection Class
 * 数据库连接类 - 基于PDO实现的数据库操作封装
 * 
 * 提供单例模式的数据库连接，支持常用的数据库操作方法：
 * - fetchRow: 获取单行记录
 * - fetchAll: 获取多行记录
 * - execute: 执行增删改操作
 * - lastInsertId: 获取最后插入记录的ID
 * 
 * @author Shop MVC Framework
 * @version 1.0.0
 */

namespace framework;

use PDO;
use PDOException;
use Exception;

/**
 * Database Class
 * 数据库操作类，封装PDO数据库连接和操作方法
 */
class db
{
    /**
     * @var array $initConfig 初始化配置（用于单例模式）
     */
    protected static $initConfig = [];

    /**
     * @var db $instance 数据库实例（单例模式）
     */
    protected static $instance;

    /**
     * @var PDO $pdo PDO数据库连接对象
     */
    protected $pdo;

    /**
     * 默认数据库配置
     * 
     * @var array $config
     */
    protected $config = [
        'type' => 'mysql',          // 数据库类型
        'host' => '127.0.0.1',      // 主机名
        'port' => '3306',           // 端口号
        'dbname' => '',             // 数据库名
        'charset' => 'utf8mb4',     // 字符集（支持emoji）
        'user' => 'root',           // 用户名
        'password' => '',           // 密码（config.php用的是password）
        'pwd' => '',                // 备用密码字段
        'prefix' => ''              // 表前缀
    ];
    
    /**
     * Constructor
     * 构造函数 - 初始化数据库连接
     * 
     * @param array $config 数据库配置数组
     */
    public function __construct(array $config = [])
    {
        // 合并用户配置与默认配置
        $this->config = array_merge($this->config, $config);
        
        // 初始化PDO连接
        $this->initPDO();
    }
    
    /**
     * Initialize PDO connection
     * 初始化PDO数据库连接
     * 
     * @return void
     * @throws Exception 如果连接失败抛出异常
     */
    protected function initPDO()
    {
        // 取出数据库连接信息
        $type = $this->config['type'];
        $host = $this->config['host'];
        $port = $this->config['port'];
        $dbname = $this->config['dbname'];
        $charset = $this->config['charset'];
        
        // 拼接数据库连接的DSN（数据源名称）
        $dsn = "$type:host=$host;port=$port;dbname=$dbname;charset=$charset";
        
        try {
            // 优先使用password字段，备用pwd字段
            $pwd = $this->config['password'] ?? $this->config['pwd'];
            $user = $this->config['username'] ?? $this->config['user'];
            
            // 创建PDO实例，连接数据库
            $this->pdo = new PDO($dsn, $user, $pwd);
            
        } catch (PDOException $e) {
            // 连接失败时抛出异常
            throw new Exception('数据库连接失败，错误信息：' . $e->getMessage());
        }
        
        // 设置PDO的错误模式为抛出异常（便于调试）
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // 关闭模拟预处理，解决LIMIT参数绑定问题（MySQL特有）
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * Get singleton instance
     * 获取数据库单例实例
     * 
     * @return db 数据库实例
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static(static::$initConfig);
        }
        return self::$instance;
    }

    /**
     * Initialize configuration for singleton
     * 初始化单例配置（在应用启动时调用）
     * 
     * @param array $config 数据库配置
     * @return void
     */
    public static function init(array $config = [])
    {
        static::$initConfig = $config;
    }

    /**
     * Fetch single row from result set
     * 获取单行记录
     * 
     * @param string $sql SQL查询语句
     * @param array $bind 绑定参数数组
     * @return array|false 返回关联数组形式的单行记录，无数据返回false
     * @throws Exception 如果执行失败抛出异常
     */
    public function fetchRow($sql, array $bind = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bind);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = $this->errorMsg($e, $sql);
            throw new Exception($error);
        }
    }

    /**
     * Generate error message
     * 生成错误信息（包含SQL语句便于调试）
     * 
     * @param PDOException $e PDO异常对象
     * @param string $sql 执行的SQL语句
     * @return string 完整的错误信息
     */
    protected function errorMsg($e, $sql = '')
    {
        $error = $e->getMessage();
        if ($sql != '') {
            $error .= ' SQL语句执行失败：' . $sql;
        }
        return $error;
    }

    /**
     * Fetch all rows from result set
     * 获取多行记录
     * 
     * @param string $sql SQL查询语句
     * @param array $bind 绑定参数数组
     * @return array 返回关联数组形式的记录列表，无数据返回空数组
     * @throws Exception 如果执行失败抛出异常
     */
    public function fetchAll($sql, array $bind = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bind);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = $this->errorMsg($e, $sql);
            throw new Exception($error);
        }
    }

    /**
     * Execute INSERT/UPDATE/DELETE statement
     * 执行增删改操作
     * 
     * @param string $sql SQL语句
     * @param array $bind 绑定参数数组
     * @return int 受影响的行数
     * @throws Exception 如果执行失败抛出异常
     */
    public function execute($sql, array $bind = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bind);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $error = $this->errorMsg($e, $sql);
            throw new Exception($error);
        }
    }

    /**
     * Get last inserted ID
     * 获取最后插入记录的自增ID
     * 
     * @return string|false 自增ID值
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
