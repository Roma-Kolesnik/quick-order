<?php


namespace ALevel\QuickOrder\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Listing
 * @package ALevel\QuickOrder\Controller\Adminhtml\Grid
 */
class Listing extends Action
{
    /** {@inheritDoc} */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }

    public function _isAllowed()
    {
        return parent::_isAllowed();
    }

}
