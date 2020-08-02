<?php

namespace ALevel\QuickOrder\Controller\Adminhtml\Status;

use ALevel\QuickOrder\Api\Repository\StatusRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Class Delete
 * @package ALevel\QuickOrder\Controller\Adminhtml\Status
 */
class Delete extends Action
{
    /** @var StatusRepositoryInterface */
    private $repository;

    /** @var LoggerInterface */
    private $logger;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param StatusRepositoryInterface $repository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        StatusRepositoryInterface $repository,
        LoggerInterface $logger
    )
    {
        parent::__construct($context);
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id', null);

        if (empty($id)) {
            $this->messageManager->addWarningMessage(__("Please select status id"));
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
