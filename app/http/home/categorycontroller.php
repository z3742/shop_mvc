<?php
/**
 * 分类API控制器
 *
 * 负责处理分类相关接口：
 * - 分类列表
 */

namespace app\http\home;

class categorycontroller
{
    /**
     * API入口方法
     */
    public function index()
    {
        $pathinfo = $_SERVER['PATH_INFO'] ?? $_GET['pathinfo'] ?? '';

        // 兼容旧格式 ?action=xxx
        if (empty($pathinfo) && isset($_GET['action'])) {
            $pathinfo = str_replace('_', '/', $_GET['action']);
        }

        $pathinfo = trim($pathinfo, '/');

        // 根据方法名分发请求
        switch ($pathinfo) {
            case 'category':
                $this->getCategoryList();
                break;
            default:
                $this->jsonReturn(['code' => 404, 'msg' => 'API not found']);
        }
    }

    /**
     * 获取分类模型实例
     */
    private function getCategoryModel()
    {
        static $model = null;
        if ($model === null) {
            require '../app/model/categorymodel.php';
            $model = new \app\model\categorymodel();
        }
        return $model;
    }

    /**
     * 获取分类列表
     */
    public function getCategoryList()
    {
        $category = $this->getCategoryModel()->getCategoryList();
        $this->jsonReturn(['code' => 200, 'data' => $category]);
    }

    /**
     * 返回JSON响应
     */
    private function jsonReturn($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
