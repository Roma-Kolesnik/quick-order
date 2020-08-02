<?php

namespace ALevel\QuickOrder\Repository;

use ALevel\QuickOrder\Api\Data\OrderInterface;
use ALevel\QuickOrder\Api\Repository\OrderRepositoryInterface;
use ALevel\QuickOrder\Model\ResourceModel\Order as ResourceModel;
use ALevel\QuickOrder\Model\ResourceModel\Order\Collection;
use ALevel\QuickOrder\Model\ResourceModel\Order\CollectionFactory;
use ALevel\QuickOrder\Model\OrderFactory as ModelFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class OrderRepository
 * @package ALevel\QuickOrder\Repository
 */
class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    private $resource;

    /**
     * @var ModelFactory
     */
    private $modelFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $processor;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * OrderRepository constructor.
     * @param ResourceModel $resource
     * @param ModelFactory $modeFactory
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsInterfaceFactory $searchResultFactory
     */
    public function __construct(
        ResourceModel $resource,
        ModelFactory $modeFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultFactory
    )
    {
        $this->resource = $resource;
        $this->modelFactory = $modeFactory;
        $this->collectionFactory = $collectionFactory;
        $this->processor = $collectionProcessor;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @param int $id
     * @return OrderInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): OrderInterface
    {
        $order = $this->modelFactory->create();

        $this->resource->load($order, $id);

        if (empty($order->getId())) {
            throw new NoSuchEntityException(__("Order %1 not found", $id));
        }

        return $order;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->processor->process($searchCriteria, $collection);

        /** @var SearchResultsInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();

        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setItems($collection->getItems());

        return $searchResult;
    }

    /**
     * @param \ALevel\QuickOrder\Api\Data\OrderInterface $order
     * @return \ALevel\QuickOrder\Api\Data\OrderInterface
     */
    public function save(\ALevel\QuickOrder\Api\Data\OrderInterface $order): OrderInterface
    {
        $order->getResource()->save($order);

        return $order;
    }

    /**
     * @param OrderInterface $order
     * @return $this|OrderRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function delete(OrderInterface $order): OrderRepositoryInterface
    {
        try {
            $this->resource->delete($order);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException("Order not delete");
        }

        return $this;
    }

    /**
     * @param int $id
     * @return $this|OrderRepositoryInterface
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): OrderRepositoryInterface
    {
        $order = $this->getById($id);
        $this->delete($order);

        return $this;
    }

}
