<?php


namespace ALevel\QuickOrder\Controller\Adminhtml\Grid;

use ALevel\QuickOrder\Api\Repository\OrderRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Class Delete
 * @package ALevel\QuickOrder\Controller\Adminhtml\Grid
 */
class Delete extends Action
{
    /** @var OrderRepositoryInterface */
    private $repository;

    /** @var LoggerInterface */
    private $logger;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param OrderRepositoryInterface $repository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        OrderRepositoryInterface $repository,
        LoggerInterface $logger
    )
    {
        parent::__construct($context);
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_redirect('*/*/');
        }

        $id = $this->getRequest()->getParam('order_id');

        if (empty($id)) {
            $this->messageManager->addWarningMessage(__("Please select order id"));
            return $this->_redirect('*/*/');
        }

        try {
            $this->repository->deleteById($id);
        } catch (NoSuchEntityException|CouldNotDeleteException $e) {
            $this->logger->info(sprintf("Item %d already delete", $id));
        }

        $this->messageManager->addSuccessMessage(sprintf("Item %d was deleted", $id));
        $this->_redirect('*/*/');
    }
}
