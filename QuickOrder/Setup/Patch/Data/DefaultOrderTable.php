<?php

namespace ALevel\QuickOrder\Setup\Patch\Data;

use ALevel\QuickOrder\Api\Data\Schema\OrderSchemaInterface;
use ALevel\QuickOrder\Api\Data\OrderInterfaceFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\DB\TransactionFactory;

/**
 * Class DefaultOrderTable
 * @package ALevel\QuickOrder\Setup\Patch\Data
 */
class DefaultOrderTable implements DataPatchInterface
{
    /**
     * @var TransactionFactory
     */
    private $transactionModel;

    /**
     * @var OrderInterfaceFactory
     */
    private $modelFactory;

    /**
     * DefaultOrderTable constructor.
     * @param TransactionFactory $transactionFactory
     * @param OrderInterfaceFactory $orderInterfaceFactory
     */
    public function __construct(
        TransactionFactory $transactionFactory,
        OrderInterfaceFactory $orderInterfaceFactory
    )
    {
        $this->transactionModel = $transactionFactory;
        $this->modelFactory = $orderInterfaceFactory;
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
     * @return DefaultOrderTable|void
     */
    public function apply()
    {
        $orderData = [
            [
                OrderSchemaInterface::SKU => '#123',
                OrderSchemaInterface::NAME => 'Eric',
                OrderSchemaInterface::PHONE => '+380432862739',
                OrderSchemaInterface::EMAIL => 'eric.el@gmail.com',
                OrderSchemaInterface::STATUS_LABEL => 'Pending'
            ],
            [
                OrderSchemaInterface::SKU => '#4EMS',
                OrderSchemaInterface::NAME => 'Bob',
                OrderSchemaInterface::PHONE => '+780912963710',
                OrderSchemaInterface::EMAIL => 'bob2134@gmail.com',
                OrderSchemaInterface::STATUS_LABEL => 'Approved'
            ],
            [
                OrderSchemaInterface::SKU => '#97MKJ',
                OrderSchemaInterface::NAME => 'Gunter',
                OrderSchemaInterface::PHONE => '+970426923381',
                OrderSchemaInterface::EMAIL => 'gunter.fridrih@box.en',
                OrderSchemaInterface::STATUS_LABEL => 'Decline'
            ],
        ];

        $transactionalModel = $this->transactionModel->create();

        foreach ($orderData as $data) {
            $model = $this->modelFactory->create();
            $model->addData($data);
            $transactionalModel->addObject($model);
        }
        $transactionalModel->save();
    }
}
