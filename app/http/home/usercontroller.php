<?php

/**
 * 用户控制器
 * 
 * 处理用户相关的业务逻辑，包括：
 * - 用户登录、注册、登出
 * - 用户中心展示
 * - 商品上架（普通用户）
 * - 商品审核（管理员）
 * - 收货地址管理
 * - 验证码生成
 */

namespace app\http\home;

use app\model\usermodel;
use app\model\addressmodel;
use app\model\ordermodel;
use Gregwar\Captcha\CaptchaBuilder;

class usercontroller
{
    /** @var usermodel 用户模型实例 */
    private $userModel;

    /**
     * 构造函数 - 初始化用户模型
     */
    public function __construct()
    {
        $this->userModel = new usermodel();
    }

    /**
     * 显示用户中心页面
     */
    public function index()
    {
        $this->showUserCenter();
    }

    /**
     * 显示登录页面
     */
    public function login()
    {
        require VIEW_PATH . 'login.php';
    }

    /**
     * 处理用户登录请求
     * 
     * @return void 返回JSON响应
     */
    public function doLogin()
    {
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $this->jsonReturn(['code' => 400, 'msg' => '用户名和密码不能为空']);
            return;
        }

        $user = $this->userModel->login($username, $password);
        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['type'];
            $this->jsonReturn([
                'code' => 200,
                'msg' => '登录成功',
                'data' => ['user_id' => $user['user_id'], 'username' => $user['username'], 'type' => $user['type']]
            ]);
        } else {
            $this->jsonReturn(['code' => 401, 'msg' => '用户名或密码错误']);
        }
    }

    /**
     * 显示注册页面
     */
    public function register()
    {
        require VIEW_PATH . 'register.php';
    }

    /**
     * 处理用户注册请求
     * 
     * @return void 返回JSON响应
     */
    public function doRegister()
    {
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $captcha = isset($_POST['captcha']) ? strtolower(trim($_POST['captcha'])) : '';

        if (empty($username) || empty($password)) {
            $this->jsonReturn(['code' => 400, 'msg' => '用户名和密码不能为空']);
            return;
        }
        if ($password !== $password2) {
            $this->jsonReturn(['code' => 400, 'msg' => '两次密码不一致']);
            return;
        }
        if (strlen($username) < 3 || strlen($username) > 20) {
            $this->jsonReturn(['code' => 400, 'msg' => '用户名长度3-20位']);
            return;
        }
        if (strlen($password) < 6) {
            $this->jsonReturn(['code' => 400, 'msg' => '密码至少6位']);
            return;
        }
        if (empty($captcha)) {
            $this->jsonReturn(['code' => 400, 'msg' => '请输入验证码']);
            return;
        }
        if (!isset($_SESSION['captcha']) || $_SESSION['captcha'] !== $captcha) {
            $this->jsonReturn(['code' => 400, 'msg' => '验证码错误']);
            return;
        }
        unset($_SESSION['captcha']);

        if ($this->userModel->checkUsername($username)) {
            $this->jsonReturn(['code' => 400, 'msg' => '用户名已存在']);
            return;
        }

        $result = $this->userModel->register($username, $password, $phone);
        if ($result !== false) {
            $this->jsonReturn(['code' => 200, 'msg' => '注册成功']);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '注册失败']);
        }
    }

    /**
     * 用户登出
     * 
     * 清除Session并跳转首页
     */
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['user_type']);
        session_destroy();
        header('Location: ' . APP_BASE . '/index/index');
    }

    /**
     * 显示用户中心页面
     */
    public function showUserCenter()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . APP_BASE . '/index/login');
            return;
        }

        $userInfo = $this->userModel->getUserInfo($_SESSION['user_id']);
        require VIEW_PATH . 'user.php';
    }

    /**
     * 用户上架商品
     * 
     * 普通用户提交商品审核申请，需要管理员审核通过后才能上架销售
     * 
     * @return void 返回JSON响应
     */
    public function addGoods()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        if ($_SESSION['user_type'] == 1) {
            $this->jsonReturn(['code' => 403, 'msg' => '管理员不能上架商品']);
            return;
        }

        $goodsName = isset($_POST['goods_name']) ? trim($_POST['goods_name']) : '';
        $goodsPrice = isset($_POST['goods_price']) ? floatval($_POST['goods_price']) : 0;
        $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 100;
        $goodsDesc = isset($_POST['goods_desc']) ? trim($_POST['goods_desc']) : '';
        $catId = isset($_POST['cat_id']) ? intval($_POST['cat_id']) : 0;

        if (empty($goodsName) || $goodsPrice <= 0) {
            $this->jsonReturn(['code' => 400, 'msg' => '商品名称和价格不能为空']);
            return;
        }

        $uploadDir = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'goods' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = '';
        $dbPath = '';
        if (isset($_FILES['goods_img']) && $_FILES['goods_img']['error'] == 0) {
            $fileInfo = pathinfo($_FILES['goods_img']['name']);
            $extension = strtolower($fileInfo['extension']);
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $this->jsonReturn(['code' => 400, 'msg' => '图片格式不正确，支持jpg/jpeg/png/gif']);
                return;
            }
            $fileName = uniqid() . '.' . $extension;
            $targetPath = $uploadDir . $fileName;
            if (!move_uploaded_file($_FILES['goods_img']['tmp_name'], $targetPath)) {
                $errorMsg = '图片上传失败';
                if (!is_writable($uploadDir)) {
                    $errorMsg = '上传目录不可写';
                } elseif ($_FILES['goods_img']['size'] > 2 * 1024 * 1024) {
                    $errorMsg = '图片大小超过限制（最大2MB）';
                }
                $this->jsonReturn(['code' => 500, 'msg' => $errorMsg]);
                return;
            }
            $dbPath = 'goods/' . $fileName;
        }

        $goodsModel = new \app\model\goodsmodel();
        $result = $goodsModel->addGoods($goodsName, $dbPath, $goodsPrice, $stock, $goodsDesc, $catId, $_SESSION['user_id']);

        if ($result !== false) {
            $this->jsonReturn(['code' => 200, 'msg' => '商品提交成功，等待管理员审核']);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '提交失败']);
        }
    }

    /**
     * 管理员审核商品
     * 
     * 管理员对用户提交的商品进行审核，通过或拒绝
     * 
     * @return void 返回JSON响应
     */
    public function checkGoods()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
            $this->jsonReturn(['code' => 403, 'msg' => '权限不足']);
            return;
        }

        $goodsId = isset($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;
        $status = isset($_POST['status']) ? intval($_POST['status']) : 1;

        if (!$goodsId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $goodsModel = new \app\model\goodsmodel();
        $result = $goodsModel->auditGoods($goodsId, $status, $_SESSION['user_id']);

        if ($result !== false) {
            $this->jsonReturn(['code' => 200, 'msg' => $status == 1 ? '审核通过' : '审核拒绝']);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '审核失败']);
        }
    }

    /**
     * 获取待审核商品列表
     * 
     * 管理员查看所有待审核的商品
     * 
     * @return void 返回JSON响应
     */
    public function pendingList()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
            $this->jsonReturn(['code' => 403, 'msg' => '权限不足']);
            return;
        }

        $goodsModel = new \app\model\goodsmodel();
        $list = $goodsModel->getPendingGoods();

        $this->jsonReturn(['code' => 200, 'data' => $list]);
    }

    /**
     * 获取当前用户提交的商品列表
     * 
     * 普通用户查看自己提交的所有商品（含待审核/已通过/已拒绝状态）
     * 
     * @return void 返回JSON响应
     */
    public function myGoods()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $goodsModel = new \app\model\goodsmodel();
        $list = $goodsModel->getGoodsByUser($_SESSION['user_id']);

        $this->jsonReturn(['code' => 200, 'data' => $list]);
    }

    /**
     * 生成验证码
     * 
     * 使用Gregwar/Captcha生成图片验证码，存储到Session中
     */
    public function captcha()
    {
        $builder = new CaptchaBuilder();
        $builder->build();
        $_SESSION['captcha'] = strtolower($builder->getPhrase());
        header('Content-Type: image/jpeg');
        $builder->output();
    }

    /**
     * 返回JSON响应
     * 
     * @param array $data 要返回的数据
     */
    private function jsonReturn($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * 获取用户收货地址列表
     * 
     * @return void 返回JSON响应
     */
    public function getAddressList()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $addressModel = new addressmodel();
        $addresses = $addressModel->getAddresses($_SESSION['user_id']);

        $this->jsonReturn(['code' => 200, 'data' => $addresses]);
    }

    /**
     * 添加收货地址
     * 
     * @return void 返回JSON响应
     */
    public function addAddress()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $consignee = isset($_POST['consignee']) ? trim($_POST['consignee']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $province = isset($_POST['province']) ? trim($_POST['province']) : '';
        $city = isset($_POST['city']) ? trim($_POST['city']) : '';
        $district = isset($_POST['district']) ? trim($_POST['district']) : '';
        $detailAddr = isset($_POST['detail_addr']) ? trim($_POST['detail_addr']) : '';

        if (empty($consignee) || empty($phone) || empty($detailAddr)) {
            $this->jsonReturn(['code' => 400, 'msg' => '收货人、电话和详细地址不能为空']);
            return;
        }

        $addressModel = new addressmodel();
        $addrId = $addressModel->addAddress(
            $_SESSION['user_id'],
            $consignee,
            $phone,
            $province,
            $city,
            $district,
            $detailAddr
        );

        if ($addrId) {
            $this->jsonReturn(['code' => 200, 'msg' => '添加成功', 'data' => ['addr_id' => $addrId]]);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '添加失败']);
        }
    }

    /**
     * 编辑收货地址
     * 
     * @return void 返回JSON响应
     */
    public function editAddress()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $addrId = isset($_POST['addr_id']) ? intval($_POST['addr_id']) : 0;
        $consignee = isset($_POST['consignee']) ? trim($_POST['consignee']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $province = isset($_POST['province']) ? trim($_POST['province']) : '';
        $city = isset($_POST['city']) ? trim($_POST['city']) : '';
        $district = isset($_POST['district']) ? trim($_POST['district']) : '';
        $detailAddr = isset($_POST['detail_addr']) ? trim($_POST['detail_addr']) : '';

        if (!$addrId || empty($consignee) || empty($phone) || empty($detailAddr)) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $addressModel = new addressmodel();
        $result = $addressModel->updateAddress(
            $addrId,
            $_SESSION['user_id'],
            $consignee,
            $phone,
            $province,
            $city,
            $district,
            $detailAddr
        );

        if ($result !== false) {
            $this->jsonReturn(['code' => 200, 'msg' => '修改成功']);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '修改失败']);
        }
    }

    /**
     * 删除收货地址
     * 
     * @return void 返回JSON响应
     */
    public function deleteAddress()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $addrId = isset($_POST['addr_id']) ? intval($_POST['addr_id']) : 0;

        if (!$addrId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $addressModel = new addressmodel();
        $result = $addressModel->deleteAddress($addrId, $_SESSION['user_id']);

        if ($result !== false) {
            $this->jsonReturn(['code' => 200, 'msg' => '删除成功']);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '删除失败']);
        }
    }

    public function orderList()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $orderModel = new ordermodel();
        $orders = $orderModel->getOrderList($_SESSION['user_id']);

        foreach ($orders as &$order) {
            $order['goods_list'] = $orderModel->getOrderGoods($order['order_id']);
        }

        $this->jsonReturn(['code' => 200, 'data' => $orders]);
    }

    public function orderListByStatus()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $status = isset($_GET['status']) ? intval($_GET['status']) : 0;
        $orderModel = new ordermodel();
        $orders = $orderModel->getOrderByStatus($_SESSION['user_id'], $status);

        foreach ($orders as &$order) {
            $order['goods_list'] = $orderModel->getOrderGoods($order['order_id']);
        }

        $this->jsonReturn(['code' => 200, 'data' => $orders]);
    }

    public function orderDetail()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$orderId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $orderModel = new ordermodel();
        $order = $orderModel->getOrderDetail($orderId);

        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            $this->jsonReturn(['code' => 404, 'msg' => '订单不存在']);
            return;
        }

        $order['goods_list'] = $orderModel->getOrderGoods($orderId);

        $this->jsonReturn(['code' => 200, 'data' => $order]);
    }

    public function updateOrderStatus()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonReturn(['code' => 401, 'msg' => '请先登录']);
            return;
        }

        $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;

        if (!$orderId) {
            $this->jsonReturn(['code' => 400, 'msg' => '参数错误']);
            return;
        }

        $orderModel = new ordermodel();
        $order = $orderModel->getOrderDetail($orderId);

        if (!$order) {
            $this->jsonReturn(['code' => 404, 'msg' => '订单不存在']);
            return;
        }

        if ($_SESSION['user_type'] != 1 && $order['user_id'] != $_SESSION['user_id']) {
            $this->jsonReturn(['code' => 403, 'msg' => '权限不足']);
            return;
        }

        if ($_SESSION['user_type'] == 1 && $status == 2 && $order['status'] != 1) {
            $this->jsonReturn(['code' => 400, 'msg' => '订单状态不正确，无法发货']);
            return;
        }

        if ($_SESSION['user_type'] != 1 && $status == 3 && $order['status'] != 2) {
            $this->jsonReturn(['code' => 400, 'msg' => '订单状态不正确，无法确认收货']);
            return;
        }

        if ($_SESSION['user_type'] != 1 && $status == 1 && $order['status'] != 0) {
            $this->jsonReturn(['code' => 400, 'msg' => '订单状态不正确，无法支付']);
            return;
        }

        $result = $orderModel->updateOrderStatus($orderId, $status);

        if ($result !== false) {
            $statusText = ['待付款', '已付款', '已发货', '已完成', '已取消'];
            $this->jsonReturn(['code' => 200, 'msg' => '订单状态已更新为：' . ($statusText[$status] ?? '未知')]);
        } else {
            $this->jsonReturn(['code' => 500, 'msg' => '更新失败']);
        }
    }

    public function adminOrderList()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
            $this->jsonReturn(['code' => 403, 'msg' => '权限不足']);
            return;
        }

        $status = isset($_GET['status']) ? intval($_GET['status']) : -1;
        
        $orderModel = new ordermodel();
        $orders = $orderModel->getAllOrders($status);

        foreach ($orders as &$order) {
            $order['goods_list'] = $orderModel->getOrderGoods($order['order_id']);
        }

        $this->jsonReturn(['code' => 200, 'data' => $orders]);
    }
}
