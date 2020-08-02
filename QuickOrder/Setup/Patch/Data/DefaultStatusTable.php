<?php

namespace ALevel\QuickOrder\Setup\Patch\Data;

use ALevel\QuickOrder\Api\Data\Schema\StatusSchemaInterface;
use ALevel\QuickOrder\Api\Data\StatusInterfaceFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\DB\TransactionFactory;

/**
 * Class DefaultStatusTable
 * @package ALevel\QuickOrder\Setup\Patch\Data
 */
class DefaultStatusTable implements DataPatchInterface
{
    /**
     * @var TransactionFactory
     */
    private $transactionModel;

    /**
     * @var StatusInterfaceFactory
     */
    private $modelFactory;

    /**
     * DefaultStatusTable constructor.
     * @param TransactionFactory $transactionFactory
     * @param StatusInterfaceFactory $statusInterfaceFactory
     */
    public function __construct(
        TransactionFactory $transactionFactory,
        StatusInterfaceFactory $statusInterfaceFactory
    )
    {
        $this->transactionModel = $transactionFactory;
        $this->modelFactory = $statusInterfaceFactory;
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return DefaultStatusTable|void
     */
    public function apply()
    {
        $statusData = [
            [
                StatusSchemaInterface::STATUS_CODE_COL_NAME => 'pending',
                StatusSchemaInterface::STATUS_LABEL_COL_NAME => 'Pending',
            ],
            [
                StatusSchemaInterface::STATUS_CODE_COL_NAME => 'approved',
                StatusSchemaInterface::STATUS_LABEL_COL_NAME => 'Approved',
            ],
            [
                StatusSchemaInterface::STATUS_CODE_COL_NAME => 'decline',
                StatusSchemaInterface::STATUS_LABEL_COL_NAME => 'Decline',
            ],
        ];

        $transactionalModel = $this->transactionModel->create();

        foreach ($statusData as $data) {
            $model = $this->modelFactory->create();
            $model->addData($data);
            $transactionalModel->addObject($model);
        }
        $transactionalModel->save();
    }
}
