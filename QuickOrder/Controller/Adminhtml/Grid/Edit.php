<?php


namespace ALevel\QuickOrder\Controller\Adminhtml\Grid;

use ALevel\QuickOrder\Api\Data\OrderInterfaceFactory;
use ALevel\QuickOrder\Api\Repository\OrderRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

/**
 * Class Edit
 * @package ALevel\QuickOrder\Controller\Adminhtml\Grid
 */
class Edit extends Action
{
    /**
     * @var OrderRepositoryInterface
     */
    private $repository;

    /**
     * @var OrderInterfaceFactory
     */
    private $modelFactory;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Edit constructor.
     * @param Context $context
     * @param OrderRepositoryInterface $repository
     * @param OrderInterfaceFactory $orderFactory
     * @param DataPersistorInterface $dataPersistor
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        OrderRepositoryInterface $repository,
        OrderInterfaceFactory $orderFactory,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger
    )
    {
        $this->repository = $repository;
        $this->modelFactory = $orderFactory;
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|mixed
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getParam('status');

        if (!empty($data)) {

            $model = $this->modelFactory->create();

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->repository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This status no longer exists.'));
                    $resultRedirect->setPath('*/*/');
                }
            }

            $model->setStatus($data);

            try {
                $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__("You saved status - $data"));
                $this->dataPersistor->clear('status');
                return $this->processReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the status.'));
            }

            $this->dataPersistor->set('order', $data);
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
