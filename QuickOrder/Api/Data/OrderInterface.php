<?php

namespace ALevel\QuickOrder\Api\Data;

/**
 * Interface OrderInterface
 * @package ALevel\QuickOrder\Api\Data
 */
interface OrderInterface
{
    const ORDER_ID = 'order_id';

    const SKU = 'sku';

    const NAME = 'name';

    const PHONE = 'phone';

    const EMAIL = 'email';

    const STATUS = 'status';

    /**
     * @return mixed
     */
    public function getOrderId();

    /**
     * @param $id
     * @return mixed
     */
    public function setOrderId($id);

    /**
     * @return mixed
     */
    public function getSKU();

    /**
     * @param $sku
     * @return mixed
     */
    public function setSKU($sku);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param $name
     * @return mixed
     */
    public function setName($name);

    /**
     * @return mixed
     */
    public function getPhone();

    /**
     * @param $phone
     * @return mixed
     */
    public function setPhone($phone);

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @param $email
     * @return mixed
     */
    public function setEmail($email);

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @param $status
     * @return mixed
     */
    public function setStatus($status);

}
