<?php

namespace app\http\home;

use app\model\commentmodel;

class commentcontroller
{
    private $commentModel;

    public function __construct()
    {
        $this->commentModel = new commentmodel();
    }

    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $goodsId = isset($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;
        $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $content = isset($_POST['content']) ? trim($_POST['content']) : '';
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5;

        if (!$goodsId || empty($content)) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        if ($rating < 1 || $rating > 5) {
            $this->jsonReturn(['code' => 400, 'msg' => '评分必须在1-5之间']);
            return;
        }

        if ($this->commentModel->hasCommented($goodsId, $_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 400, 'msg' => '您已经评价过该商品']);
            return;
        }

        $result = $this->commentModel->addComment($goodsId, $_SESSION['user_id'], $orderId, $content, $rating);
        if ($result !== false) {
            $this->jsonReturn(['code' => 200, 'msg' => '评价成功']);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '评价失败']);
        }
    }

    public function list()
    {
        $goodsId = isset($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = 10;
        $offset = ($page - 1) * $pageSize;

        if (!$goodsId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $comments = $this->commentModel->getCommentsByGoods($goodsId, $pageSize, $offset);
        $total = $this->commentModel->getCommentCount($goodsId);

        $this->jsonReturn(['code' => 200, 'data' => $comments, 'total' => $total]);
    }

    public function rating()
    {
        $goodsId = isset($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;

        if (!$goodsId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $rating = $this->commentModel->getGoodsRating($goodsId);
        $this->jsonReturn(['code' => 200, 'data' => $rating]);
    }

    public function delete()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $commentId = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0;

        if (!$commentId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $result = $this->commentModel->deleteComment($commentId);
        if ($result !== false) {
            $this->jsonReturn(['code' => 200, 'msg' => '删除成功']);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '删除失败']);
        }
    }

    private function jsonReturn($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
