<?php


namespace ALevel\QuickOrder\Controller\Adminhtml\Status;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Create
 * @package ALevel\QuickOrder\Controller\Adminhtml\Status
 */
class Create extends Action
{
    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
