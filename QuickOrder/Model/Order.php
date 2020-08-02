<?php

namespace ALevel\QuickOrder\Model;

use ALevel\QuickOrder\Api\Data\OrderInterface;
use Magento\Framework\Model\AbstractModel;
use ALevel\QuickOrder\Model\ResourceModel\Order as ResourceModel;

/**
 * Class Order
 * @package ALevel\QuickOrder\Model
 */
class Order extends AbstractModel implements OrderInterface
{
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return mixed|null
     */
    public function getOrderId()
    {
        return $this->_getData(self::ORDER_ID);
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function setOrderId($id)
    {
        $this->setData(self::ORDER_ID, $id);
    }

    /**
     * @return mixed|null
     */
    public function getSKU()
    {
        return $this->_getData(self::SKU);
    }

    /**
     * @param $sku
     * @return mixed|void
     */
    public function setSKU($sku)
    {
        $this->setData(self::SKU, $sku);
    }

    /**
     * @return mixed|null
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    /**
     * @param $name
     * @return mixed|void
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * @return mixed|null
     */
    public function getPhone()
    {
        return $this->_getData(self::PHONE);
    }

    /**
     * @param $phone
     * @return mixed|void
     */
    public function setPhone($phone)
    {
        $this->setData(self::PHONE, $phone);
    }

    /**
     * @return mixed|null
     */
    public function getEmail()
    {
        return $this->_getData(self::EMAIL);
    }

    /**
     * @param $email
     * @return mixed|void
     */
    public function setEmail($email)
    {
        $this->setData(self::EMAIL, $email);
    }

    /**
     * @return mixed|null
     */
    public function getStatus()
    {
        return $this->_getData(self::STATUS);
    }

    /**
     * @param $status
     * @return mixed|void
     */
    public function setStatus($status)
    {
        $this->setData(self::STATUS, $status);
    }
}

