<?php

namespace ALevel\QuickOrder\Model\ResourceModel\Order;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use ALevel\QuickOrder\Model\Order as Model;
use ALevel\QuickOrder\Model\ResourceModel\Order as ResourceModel;

/**
 * Class Collection
 * @package ALevel\QuickOrder\Model\ResourceModel\Order
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }

}
