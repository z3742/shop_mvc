<?php

/**
 * 购物车控制器
 * 
 * 处理购物车相关的业务逻辑，包括：
 * - 获取购物车列表
 * - 添加商品到购物车
 * - 更新购物车商品数量
 * - 删除购物车商品
 * - 清空购物车
 * - 获取购物车商品数量
 * - 结算下单
 */

namespace app\http\home;

use app\model\cartmodel;
use app\model\ordermodel;

class cartcontroller
{
    /** @var cartmodel 购物车模型实例 */
    private $cartModel;

    /**
     * 构造函数 - 初始化购物车模型
     */
    public function __construct()
    {
        $this->cartModel = new cartmodel();
    }

    /**
     * 获取购物车列表
     * 
     * @return void 返回JSON响应
     */
    public function index()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        if (!$userId) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $cartList = $this->cartModel->getCartList($userId);
        $cartTotal = $this->cartModel->getCartTotal($userId);

        $this->jsonReturn(['code' => 200, 'data' => $cartList, 'total' => $cartTotal]);
    }

    /**
     * 添加商品到购物车
     * 
     * @return void 返回JSON响应
     */
    public function add()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        if (!$userId) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $goodsId = isset($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;
        $num = isset($_POST['num']) ? intval($_POST['num']) : 1;

        if (!$goodsId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $result = $this->cartModel->addToCart($userId, $goodsId, $num);
        if ($result !== false) {
            $cartCount = $this->cartModel->getCartCount($userId);
            $this->jsonReturn(['code' => 200, 'msg' => '添加成功', 'cart_count' => $cartCount]);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '添加失败']);
        }
    }

    /**
     * 更新购物车商品数量
     * 
     * @return void 返回JSON响应
     */
    public function update()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        if (!$userId) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $cartId = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
        $num = isset($_POST['num']) ? intval($_POST['num']) : 1;

        if (!$cartId || $num < 1) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $result = $this->cartModel->updateCartNum($cartId, $num, $userId);
        if ($result !== false) {
            $cartTotal = $this->cartModel->getCartTotal($userId);
            $this->jsonReturn(['code' => 200, 'msg' => '更新成功', 'cart_total' => $cartTotal]);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '更新失败']);
        }
    }

    /**
     * 删除购物车商品
     * 
     * @return void 返回JSON响应
     */
    public function delete()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        if (!$userId) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $cartId = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;

        if (!$cartId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $result = $this->cartModel->deleteCart($cartId, $userId);
        if ($result !== false) {
            $cartTotal = $this->cartModel->getCartTotal($userId);
            $cartCount = $this->cartModel->getCartCount($userId);
            $this->jsonReturn(['code' => 200, 'msg' => '删除成功', 'cart_total' => $cartTotal, 'cart_count' => $cartCount]);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '删除失败']);
        }
    }

    /**
     * 清空购物车
     * 
     * @return void 返回JSON响应
     */
    public function clear()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        if (!$userId) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $result = $this->cartModel->clearCart($userId);
        if ($result !== false) {
            $this->jsonReturn(['code' => 200, 'msg' => '清空成功']);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '清空失败']);
        }
    }

    /**
     * 获取购物车商品数量
     * 
     * @return void 返回JSON响应
     */
    public function count()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        $cartCount = 0;

        if ($userId) {
            $cartCount = $this->cartModel->getCartCount($userId);
        }

        $this->jsonReturn(['code' => 200, 'cart_count' => $cartCount]);
    }

    /**
     * 结算下单
     * 
     * 将购物车商品转为订单，然后清空购物车
     * 
     * @return void 返回JSON响应
     */
    public function checkout()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        if (!$userId) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $addrId = isset($_POST['addr_id']) ? intval($_POST['addr_id']) : 0;

        $cartList = $this->cartModel->getCartList($userId);
        if (empty($cartList)) {
            $this->jsonReturn(['code' => 400, 'msg' => '购物车为空']);
            return;
        }

        $totalAmount = $this->cartModel->getCartTotal($userId);

        $orderModel = new ordermodel();
        $orderId = $orderModel->createOrder($userId, $cartList, $totalAmount, $addrId);

        if ($orderId !== false) {
            $this->cartModel->clearCart($userId);
            $this->jsonReturn(['code' => 200, 'msg' => '下单成功', 'order_id' => $orderId]);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '下单失败']);
        }
    }

    /**
     * 返回JSON响应
     * 
     * @param array $data 要返回的数据
     */
    private function jsonReturn($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}