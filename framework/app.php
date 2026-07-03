<?php
/**
 * Framework Core Application Class
 * 框架核心应用类 - 负责请求路由分发和控制器调用
 * 
 * @author Shop MVC Framework
 * @version 1.0.0
 */

namespace framework;

/**
 * Application Class
 * 应用程序核心类，处理HTTP请求的路由分发和控制器执行
 */
class app
{
    /**
     * Run the application
     * 启动应用程序，执行完整的请求处理流程
     * 
     * @return void
     */
    public function run()
    {
        // 1. 加载配置文件（数据库配置、路由配置等）
        $this->loadConfig();

        // 2. 路由检查，确定要执行的控制器和方法
        $dispatch = $this->routeCheck();

        // 3. 分发请求，调用对应的控制器方法
        return $this->dispatch($dispatch);
    }

    /**
     * Load configuration files
     * 加载应用配置文件
     * 
     * 从 app/config/ 目录加载配置文件，包括：
     * - config.php: 数据库连接配置等系统配置
     * - router.php: 自定义路由规则配置
     * 
     * @return void
     */
    private function loadConfig()
    {
        // 使用全局变量保存配置，方便全局访问
        $GLOBALS['config'] = require "../app/config/config.php";
        $GLOBALS['route'] = require "../app/config/router.php";
    }

    /**
     * Route checking and matching
     * 路由检查与匹配
     * 
     * 根据请求的pathinfo，按照以下优先级匹配路由：
     * 1. 完整路径匹配（从路由配置中查找）
     * 2. index/xxx 格式匹配
     * 3. user/xxx 格式匹配（用户相关操作）
     * 4. cart/xxx 格式匹配（购物车相关操作）
     * 5. 默认路由（返回首页）
     * 
     * @return array [controller, action] - 控制器类名和方法名
     */
    public function routeCheck()
    {
        $pathinfo = isset($_GET['pathinfo']) ? $_GET['pathinfo'] : '';

        // 去除首尾斜杠
        $pathinfo = trim($pathinfo, '/');

        // 如果pathinfo为空，返回首页控制器
        if (empty($pathinfo)) {
            return ['\\app\\http\\home\\indexcontroller', 'index'];
        }

        // 检查路由配置 - 先尝试完整路径匹配（自定义路由）
        if (isset($GLOBALS['route'][$pathinfo])) {
            $routePath = $GLOBALS['route'][$pathinfo];
            $parts = explode('/', $routePath);
            if (count($parts) >= 3) {
                $controller = '\\app\\http\\' . $parts[0] . '\\' . $parts[1] . 'controller';
                $action = $parts[2];
                return [$controller, $action];
            }
        }

        // 尝试匹配 index/xxx 格式（去掉 index/ 前缀后查找路由）
        if (strpos($pathinfo, 'index/') === 0) {
            $actionName = substr($pathinfo, 6); // 去掉 "index/" 前缀
            if (isset($GLOBALS['route'][$actionName])) {
                $routePath = $GLOBALS['route'][$actionName];
                $parts = explode('/', $routePath);
                if (count($parts) >= 3) {
                    $controller = '\\app\\http\\' . $parts[0] . '\\' . $parts[1] . 'controller';
                    $action = $parts[2];
                    return [$controller, $action];
                }
            }
        }

        // 尝试匹配 user/xxx 格式（用户控制器路由）
        if (strpos($pathinfo, 'user/') === 0) {
            return ['\\app\\http\\home\\usercontroller', 'index'];
        }

        // 尝试匹配 cart/xxx 格式（购物车控制器路由）
        if (strpos($pathinfo, 'cart/') === 0) {
            return ['\\app\\http\\home\\cartcontroller', 'index'];
        }

        // 默认处理：返回首页控制器
        return ['\\app\\http\\home\\indexcontroller', 'index'];
    }

    /**
     * Dispatch request to controller
     * 请求分发 - 根据路由结果调用对应的控制器和方法
     * 
     * @param array $dispatch [controllerName, action]
     * @return void
     */
    public function dispatch(array $dispatch)
    {
        // 解析路由结果
        list($controllerName, $action) = $dispatch;

        // 将控制器类名转换为文件路径
        $controllerFile = str_replace('\\', '/', ltrim($controllerName, '\\')) . '.php';
        $controllerPath = '../' . $controllerFile;

        // 检查控制器文件是否存在
        if (!file_exists($controllerPath)) {
            // API请求返回JSON错误，普通请求返回HTML错误
            if (strpos($_SERVER['REQUEST_URI'], 'api') !== false) {
                echo json_encode(['code' => 500, 'msg' => 'Controller file not found: ' . $controllerPath]);
                exit;
            }
            exit('控制器文件不存在: ' . $controllerPath);
        }

        // 引入控制器文件
        require_once $controllerPath;

        // 检查控制器类是否存在
        if (!class_exists($controllerName)) {
            if (strpos($_SERVER['REQUEST_URI'], 'api') !== false) {
                echo json_encode(['code' => 500, 'msg' => 'Controller not found: ' . $controllerName]);
                exit;
            }
            exit('请求的控制器不存在: ' . $controllerName);
        }

        // 实例化控制器对象
        $controller = new $controllerName();

        // 检查方法是否存在
        if (!method_exists($controller, $action)) {
            // strpos 查用于查找字符串位置 substr 用于截取字符串 strlen 用于获取字符串长度
            if (strpos($_SERVER['REQUEST_URI'], 'api') !== false) {
                echo json_encode(['code' => 500, 'msg' => 'Method not found: ' . $action . ' in ' . $controllerName]);
                exit;
            }
            exit('请求的方法不存在: ' . $action);
        }

        // 调用控制器方法处理请求
        $controller->$action();
    }
}
