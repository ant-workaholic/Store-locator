<?php
namespace Fastgento\Storelocator\Model\Location;

use Fastgento\Storelocator\Model\ResourceModel\Location\CollectionFactory;
use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Fastgento\Storelocator\Model\ResourceModel\Location\Collection
     */
    protected $collection;

    /**
     * @var FilterPool
     */
    protected $filterPool;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $locationCollectionFactory
     * @param FilterPool $filterPool
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $locationCollectionFactory,
        FilterPool $filterPool,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $locationCollectionFactory->create();
        $this->filterPool = $filterPool;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Fastgento\Storelocator\Model\Location $location */
        foreach ($items as $location) {
            $this->loadedData[$location->getId()] = $location->getData();
        }
        return $this->loadedData;
    }
}