<?php

namespace ALevel\QuickOrder\Repository;

use ALevel\QuickOrder\Api\Data\StatusInterface;
use ALevel\QuickOrder\Api\Repository\StatusRepositoryInterface;
use ALevel\QuickOrder\Model\ResourceModel\Status as ResourceModel;
use ALevel\QuickOrder\Model\ResourceModel\Status\Collection;
use ALevel\QuickOrder\Model\ResourceModel\Status\CollectionFactory;
use ALevel\QuickOrder\Model\StatusFactory as ModelFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class StatusRepository
 * @package ALevel\QuickOrder\Repository
 */
class StatusRepository implements StatusRepositoryInterface
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
     * StatusRepository constructor.
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
     * @return StatusInterface
     * @throws NoSuchEntityException
     */
    public function getById($id): StatusInterface
    {
        $status = $this->modelFactory->create();

        $this->resource->load($status, $id);

        if (empty($status->getId())) {
            throw new NoSuchEntityException(__("Status %1 not found", $id));
        }

        return $status;
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
     * @param StatusInterface $status
     * @return StatusInterface
     * @throws CouldNotSaveException
     */
    public function save(StatusInterface $status): StatusInterface
    {
        try {
            $this->resource->save($status);
        } catch (\Exception $e) {
            // added logger
            throw new CouldNotSaveException(__("Status could not save"));
        }

        return $status;
    }

    /**
     * @param StatusInterface $status
     * @return $this|StatusRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function delete(StatusInterface $status): StatusRepositoryInterface
    {
        try {
            $this->resource->delete($status);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException("Status not delete");
        }

        return $this;
    }

    /**
     * @param int $id
     * @return $this|StatusRepositoryInterface
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): StatusRepositoryInterface
    {
        $status = $this->getById($id);
        $this->delete($status);

        return $this;
    }
}
