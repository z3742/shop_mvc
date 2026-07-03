<?php

/**
 * 用户模型
 * 
 * 处理用户相关的数据操作，包括：
 * - 用户登录验证
 * - 用户注册
 * - 用户名检查
 * - 获取用户信息
 * - 更新用户信息
 * - 判断是否为管理员
 */

namespace app\model;

class usermodel extends \framework\model
{
    /**
     * 用户登录验证
     * 
     * 根据用户名获取用户信息并验证密码
     * 
     * @param string $username 用户名
     * @param string $password 密码
     * @return array|false 用户信息数组，验证失败返回false
     */
    public function login($username, $password)
    {
        $sql = "SELECT * FROM user WHERE username=?";
        $user = $this->db->fetchRow($sql, [$username]);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    /**
     * 用户注册
     * 
     * 创建新用户，密码使用bcrypt哈希加密
     * 
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $phone 手机号（可选）
     * @return int|false 插入成功返回用户ID，失败返回false
     */
    public function register($username, $password, $phone = '')
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (username, password, phone, type) VALUES (?, ?, ?, 0)";
        return $this->db->execute($sql, [$username, $hashedPassword, $phone]);
    }

    /**
     * 检查用户名是否存在
     * 
     * @param string $username 用户名
     * @return array|false 用户信息（存在）或false（不存在）
     */
    public function checkUsername($username)
    {
        $sql = "SELECT user_id FROM user WHERE username=?";
        return $this->db->fetchRow($sql, [$username]);
    }

    /**
     * 获取用户信息
     * 
     * 获取指定用户的基本信息（不含密码）
     * 
     * @param int $userId 用户ID
     * @return array|null 用户信息数组，不存在返回null
     */
    public function getUserInfo($userId)
    {
        $sql = "SELECT user_id, username, phone, type FROM user WHERE user_id=?";
        return $this->db->fetchRow($sql, [$userId]);
    }

    /**
     * 更新用户信息
     * 
     * 动态更新用户字段
     * 
     * @param int $userId 用户ID
     * @param array $data 要更新的数据数组
     * @return int|false 成功返回影响行数，失败返回false
     */
    public function updateUser($userId, $data)
    {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key=?";
            $values[] = $value;
        }
        $values[] = $userId;
        $sql = "UPDATE user SET " . implode(',', $fields) . " WHERE user_id=?";
        return $this->db->execute($sql, $values);
    }
    
    /**
     * 判断是否为管理员
     * 
     * @param int $userId 用户ID
     * @return bool 是否为管理员
     */
    public function isAdmin($userId)
    {
        $sql = "SELECT type FROM user WHERE user_id=?";
        $result = $this->db->fetchRow($sql, [$userId]);
        return $result && $result['type'] == 1;
    }
}