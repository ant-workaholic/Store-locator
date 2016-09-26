<?php
namespace Fastgento\Storelocator\Block\Locator;

use \Fastgento\Storelocator\Model\ResourceModel\Location\CollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\View\Element\Template;

class Item extends \Magento\Framework\View\Element\Template
{
    protected $_collectionFactory;

    /**
     * Specify location's collection factory
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Template\Context $context,
        array $data = [],
        CollectionFactory $collectionFactory
    ){
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get all locations for all map
     *
     * @TODO: Need to change the logic for show just the nearest area for current position
     */
    public function getAllLocations()
    {
        /** @var /Fastgento/Storelocator/Model/ResourceModel/Location/Collection $collection */
        $collection = $this->_collectionFactory->create();
        if ($collection) {
            return $collection;
        }
    }

}