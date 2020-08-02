<?php

namespace ALevel\QuickOrder\Controller\Adminhtml\Status;

use ALevel\QuickOrder\Api\Data\StatusInterfaceFactory;
use ALevel\QuickOrder\Api\Repository\StatusRepositoryInterface;
use ALevel\QuickOrder\Model\Status;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

/**
 * Class Save
 * @package ALevel\QuickOrder\Controller\Adminhtml\Status
 */
class Save extends Action
{
    /** @var StatusRepositoryInterface */
    private $repository;

    /** @var StatusInterfaceFactory */
    private $modelFactory;

    /** @var DataPersistorInterface */
    private $dataPersistor;

    /** @var LoggerInterface */
    private $logger;

    /**
     * Save constructor.
     * @param Context $context
     * @param StatusRepositoryInterface $repository
     * @param StatusInterfaceFactory $statusFactory
     * @param DataPersistorInterface $dataPersistor
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        StatusRepositoryInterface $repository,
        StatusInterfaceFactory $statusFactory,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger
    )
    {
        $this->repository = $repository;
        $this->modelFactory = $statusFactory;
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger;

        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            /** @var Status $model */
            $model = $this->modelFactory->create();

            $id = $this->getRequest()->getParam('status_id');
            if ($id) {
                try {
                    $model = $this->repository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This status no longer exists.'));
                    $resultRedirect->setPath('*/*/');
                }
            }

            $model->setStatus($data['status']);
            $model->setStatusCode($data['status_code']);

            try {
                $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the status.'));
                $this->dataPersistor->clear('status_id');
                return $this->processReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the status.'));
            }

            $this->dataPersistor->set('status_id', $data);
            return $resultRedirect->setPath('*/*/', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $model
     * @param $data
     * @param $resultRedirect
     * @return mixed
     */
    private function processReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/', ['id' => $model->getId()]);
        } else if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
