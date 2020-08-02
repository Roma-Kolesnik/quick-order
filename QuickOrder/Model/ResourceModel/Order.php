<?php

namespace ALevel\QuickOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Order
 * @package ALevel\QuickOrder\Model\ResourceModel
 */
class Order extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('alevel_quick_order', 'order_id');
    }

}
