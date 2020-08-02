<?php


namespace ALevel\QuickOrder\Block\Adminhtml\Status\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 * @package ALevel\QuickOrder\Block\Adminhtml\Status\Edit
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [
            'label' => __('Delete Status'),
            'class' => 'delete',
            'data_attribute' => [
                'url' => $this->getDeleteUrl()
            ],
            'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
            'sort_order' => 20,
        ];

        return $data;
    }

    /**
     * Get delete url.
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/', ['status_id' => $this->getStatusId()]);
    }
}
