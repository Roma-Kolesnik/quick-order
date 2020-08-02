<?php


namespace ALevel\QuickOrder\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use ALevel\QuickOrder\Model\Status;

/**
 * Class ChangeStatus
 * @package ALevel\QuickOrder\Ui\Component\Listing\Column
 */
class ChangeStatus extends Column
{
    const URL_PATH_EDIT = 'quick_order/grid/edit';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Status
     */
    protected $statusFactory;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * ChangeStatus constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param Status $statusFactory
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Status $statusFactory,
        array $components = [],
        array $data = [],
        $editUrl = self::URL_PATH_EDIT
    )
    {
        $this->statusFactory = $statusFactory;
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $collection = $this->statusFactory->getCollection()->getData();
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['order_id'])) {
                    foreach ($collection as $status) {
                        $stat = $status['status'];
                        $item[$name][$stat] = [
                            'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['order_id'], 'status' => $stat]),
                            'label' => __($stat)
                        ];
                    }
                }
            }
        }
        return $dataSource;
    }
}
