<?php

namespace ALevel\QuickOrder\Block\Adminhtml\Status\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

use ALevel\QuickOrder\Api\Repository\StatusRepositoryInterface;

/**
 * Class GenericButton
 * @package ALevel\QuickOrder\Block\Adminhtml\Status\Edit
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var StatusRepositoryInterface
     */
    protected $repository;

    /**
     * @param Context $context
     * @param StatusRepositoryInterface $blockRepository
     */
    public function __construct(
        Context $context,
        StatusRepositoryInterface $blockRepository
    )
    {
        $this->context = $context;
        $this->repository = $blockRepository;
    }

    /**
     * Return CMS block ID
     *
     * @return int|null
     */
    public function getStatusId()
    {
        try {
            return $this->repository->getById(
                $this->context->getRequest()->getParam('id')
            )->getStatusId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
