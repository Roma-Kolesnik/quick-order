<?php

namespace ALevel\QuickOrder\Controller\Adminhtml\Status;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

/**
 * Class Index
 * @package ALevel\QuickOrder\Controller\Adminhtml\Status
 */
class Index extends Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $page = $resultJson = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $page->setActiveMenu('ALevel_QuickOrder::quick_order_status');
        $page->getConfig()->getTitle()->prepend(__('Status Grid'));
        return $page;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ALevel_QuickOrder::quick_order_status');
    }

}
