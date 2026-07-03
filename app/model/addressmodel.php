<?php
namespace app\model;

class addressmodel extends \framework\model
{
    /**
     * 添加收货地址
     */
    public function addAddress($userId, $consignee, $phone, $province, $city, $district, $detailAddr)
    {
        $sql = "INSERT INTO user_address (user_id, consignee, phone, province, city, district, detail_addr) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->db->execute($sql, [$userId, $consignee, $phone, $province, $city, $district, $detailAddr]);
        return $this->db->lastInsertId();
    }

    /**
     * 获取用户的所有地址
     */
    public function getAddresses($userId)
    {
        $sql = "SELECT * FROM user_address WHERE user_id=? ORDER BY addr_id DESC";
        return $this->db->fetchAll($sql, [$userId]);
    }

    /**
     * 获取单个地址详情
     */
    public function getAddress($addrId)
    {
        $sql = "SELECT * FROM user_address WHERE addr_id=?";
        return $this->db->fetchRow($sql, [$addrId]);
    }

    /**
     * 更新地址
     */
    public function updateAddress($addrId, $userId, $consignee, $phone, $province, $city, $district, $detailAddr)
    {
        $sql = "UPDATE user_address 
                SET consignee=?, phone=?, province=?, city=?, district=?, detail_addr=?
                WHERE addr_id=? AND user_id=?";
        return $this->db->execute($sql, [$consignee, $phone, $province, $city, $district, $detailAddr, $addrId, $userId]);
    }

    /**
     * 删除地址
     */
    public function deleteAddress($addrId, $userId)
    {
        $sql = "DELETE FROM user_address WHERE addr_id=? AND user_id=?";
        return $this->db->execute($sql, [$addrId, $userId]);
    }
}
?>