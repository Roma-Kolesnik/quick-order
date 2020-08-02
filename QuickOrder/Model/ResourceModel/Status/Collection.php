<?php

namespace ALevel\QuickOrder\Model\ResourceModel\Status;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use ALevel\QuickOrder\Model\Status as Model;
use ALevel\QuickOrder\Model\ResourceModel\Status as ResourceModel;

/**
 * Class Collection
 * @package ALevel\QuickOrder\Model\ResourceModel\Status
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }

}
