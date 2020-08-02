<?php

namespace ALevel\QuickOrder\DataProvider;

use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use ALevel\QuickOrder\Api\Data\StatusInterface;
use ALevel\QuickOrder\Model\ResourceModel\Status\Collection;
use ALevel\QuickOrder\Model\ResourceModel\Status\CollectionFactory;

/**
 * Class StatusProvider
 * @package ALevel\QuickOrder\DataProvider
 */
class StatusProvider extends ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    private $colleciton;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var array
     */
    private $loadedData = [];

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /** @var StatusInterface $block */
        foreach ($items as $status) {
            $this->loadedData[$status->getId()] = $status->getData();
        }

        $data = $this->dataPersistor->get('status');
        if (!empty($data)) {
            $status = $this->collection->getNewEmptyItem();
            $status->setData($data);
            $this->loadedData[$status->getId()] = $status->getData();
            $this->dataPersistor->clear('status');
        }

        return $this->loadedData;
    }
}
