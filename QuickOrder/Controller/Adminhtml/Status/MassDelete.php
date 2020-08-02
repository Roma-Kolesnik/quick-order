<?php

namespace ALevel\QuickOrder\Controller\Adminhtml\Status;

use ALevel\QuickOrder\Api\Repository\StatusRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Class MassDelete
 * @package ALevel\QuickOrder\Controller\Adminhtml\Status
 */
class MassDelete extends Action
{
    /** @var StatusRepositoryInterface */
    private $repository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param StatusRepositoryInterface $repository
     */
    public function __construct(
        Context $context,
        StatusRepositoryInterface $repository,
        LoggerInterface $logger
    )
    {
        $this->repository = $repository;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_redirect('*/*/');
        }

        $ids = $this->getRequest()->getParam('selected');

        if (empty($ids)) {
            $this->messageManager->addWarningMessage(__("Please select ids"));
            return $this->_redirect('*/*/');
        }

        foreach ($ids as $id) {
            try {
                $this->repository->deleteById($id);
            } catch (NoSuchEntityException|CouldNotDeleteException $e) {
                $this->logger->info(sprintf("Item %d already delete", $id));
            }
        }

        $this->messageManager->addSuccessMessage(sprintf("Items %s was deleted", implode(',', $ids)));
        $this->_redirect('*/*/');
    }
}
