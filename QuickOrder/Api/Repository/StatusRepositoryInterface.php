<?php


namespace ALevel\QuickOrder\Api\Repository;

use ALevel\QuickOrder\Api\Data\StatusInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface StatusRepositoryInterface
 * @package ALevel\QuickOrder\Api\Repository
 */
interface StatusRepositoryInterface
{
    /**
     * Get status by ID
     *
     * @param int $id
     * @return StatusInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): StatusInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * @param StatusInterface $status
     * @return StatusInterface
     * @throws CouldNotSaveException
     */
    public function save(StatusInterface $status): StatusInterface;

    /**
     * @param StatusInterface $status
     * @return StatusRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function delete(StatusInterface $status): StatusRepositoryInterface;

    /**
     * @param int $id
     * @return StatusRepositoryInterface
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): StatusRepositoryInterface;
}
