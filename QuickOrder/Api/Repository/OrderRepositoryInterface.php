<?php

namespace ALevel\QuickOrder\Api\Repository;

use ALevel\QuickOrder\Api\Data\OrderInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface OrderRepositoryInterface
 * @package ALevel\QuickOrder\Api\Repository
 */
interface OrderRepositoryInterface
{
    /**
     * Get order by ID
     *
     * @param int $id
     * @return OrderInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): OrderInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * @param \ALevel\QuickOrder\Api\Data\OrderInterface $order
     * @return \ALevel\QuickOrder\Api\Data\OrderInterface
     */
    public function save(\ALevel\QuickOrder\Api\Data\OrderInterface $order): OrderInterface;

    /**
     * @param OrderInterface $order
     * @return OrderRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function delete(OrderInterface $order): OrderRepositoryInterface;

    /**
     * @param int $id
     * @return OrderRepositoryInterface
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): OrderRepositoryInterface;
}
