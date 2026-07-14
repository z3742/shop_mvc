<?php

namespace app\http\home;

use app\model\favoriteModel;

class favoritecontroller
{
    private $favoriteModel;

    public function __construct()
    {
        $this->favoriteModel = new favoriteModel();
    }

    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $goodsId = isset($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;

        if (!$goodsId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        if ($this->favoriteModel->isFavorite($_SESSION['user_id'], $goodsId)) {
            $this->jsonReturn(['code' => 400, 'msg' => '已收藏该商品']);
            return;
        }

        $result = $this->favoriteModel->addFavorite($_SESSION['user_id'], $goodsId);
        if ($result !== false) {
            $favoriteCount = $this->favoriteModel->getFavoriteCount($_SESSION['user_id']);
            $this->jsonReturn(['code' => 200, 'msg' => '收藏成功', 'favorite_count' => $favoriteCount]);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '收藏失败']);
        }
    }

    public function remove()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $goodsId = isset($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;

        if (!$goodsId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $result = $this->favoriteModel->removeFavorite($_SESSION['user_id'], $goodsId);
        if ($result !== false) {
            $favoriteCount = $this->favoriteModel->getFavoriteCount($_SESSION['user_id']);
            $this->jsonReturn(['code' => 200, 'msg' => '取消收藏成功', 'favorite_count' => $favoriteCount]);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '取消收藏失败']);
        }
    }

    public function list()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = 10;
        $offset = ($page - 1) * $pageSize;

        $favorites = $this->favoriteModel->getFavoriteList($_SESSION['user_id'], $pageSize, $offset);
        $total = $this->favoriteModel->getFavoriteCount($_SESSION['user_id']);

        $this->jsonReturn(['code' => 200, 'data' => $favorites, 'total' => $total]);
    }

    public function check()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $goodsId = isset($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;

        if (!$goodsId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $isFavorite = $this->favoriteModel->isFavorite($_SESSION['user_id'], $goodsId);
        $this->jsonReturn(['code' => 200, 'data' => ['is_favorite' => $isFavorite]]);
    }

    public function count()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        $count = 0;

        if ($userId) {
            $count = $this->favoriteModel->getFavoriteCount($userId);
        }

        $this->jsonReturn(['code' => 200, 'favorite_count' => $count]);
    }

    private function jsonReturn($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
