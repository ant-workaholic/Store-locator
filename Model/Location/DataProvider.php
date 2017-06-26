<?php
namespace Fastgento\Storelocator\Model\Location;

use Fastgento\Storelocator\Model\ResourceModel\Location\CollectionFactory;
use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;
use Magento\Customer\Model\ResourceModel\Address\Attribute\Source\CountryWithWebsites;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Ui\Component\Form\Field;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var CountryWithWebsites
     */
    private $countryByWebsiteSource;

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
            $locationData = $location->getData();
            if (isset($locationData['image'])) {
                unset($locationData['image']);
                $locationData['image'][0]['name'] = $location->getData('image');
                $locationData['image'][0]['url'] = $location->getImageUrl();
            }
            $this->loadedData[$location->getId()] = $locationData;
        }
        return $this->loadedData;
    }

}