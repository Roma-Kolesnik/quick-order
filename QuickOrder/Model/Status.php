<?php

namespace ALevel\QuickOrder\Model;

use ALevel\QuickOrder\Api\Data\StatusInterface;
use Magento\Framework\Model\AbstractModel;
use ALevel\QuickOrder\Model\ResourceModel\Status as ResourceModel;

/**
 * Class Status
 * @package ALevel\QuickOrder\Model
 */
class Status extends AbstractModel implements StatusInterface
{

    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return mixed|null
     */
    public function getStatusId()
    {
        return $this->_getData(self::STATUS_ID);
    }

    /**
     * @param $status_id
     * @return mixed|void
     */
    public function setStatusId($status_id)
    {
        $this->setData(self::STATUS_ID, $status_id);
    }

    /**
     * @return mixed|null
     */
    public function getStatusCode()
    {
        return $this->_getData(self::STATUS_CODE);
    }

    /**
     * @param $status_code
     * @return mixed|void
     */
    public function setStatusCode($status_code)
    {
        $this->setData(self::STATUS_CODE, $status_code);
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
