<?php
/**
 * Copyright © 2015 Fastgento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Fastgento\Storelocator\Block\Locator;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\View\Element\Template;
use Fastgento\Storelocator\Model\ResourceModel\Location\CollectionFactory as LocationCollectionFactory;

class Map extends \Magento\Framework\View\Element\Template
{
    /** @var  $_options */
    protected $_options;

    protected $_collectionFactory;

    public function __construct(Template\Context $context, array $data = [], LocationCollectionFactory $collectionFactory)
    {
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    public function getSerializedOptions()
    {
        $height = $this->_scopeConfig->getValue("fastgento/general/height");
        $width = $this->_scopeConfig->getValue("fastgento/general/width");
        $zoom = $this->_scopeConfig->getValue("fastgento/general/zoom");
        $lat = $this->_scopeConfig->getValue("fastgento/general/lat");
        $long = $this->_scopeConfig->getValue("fastgento/general/long");

        $collection = $this->_collectionFactory->create();

        $markers = array();
        /** @var $location /Fastgento/Storelocator/Model/Location */
        foreach ($collection as $location) {
            $markers[] = array(
                "latitude"  => (float)$location->getLatitude(),
                "longitude" => (float)$location->getLongitude(),
                "title"     => $location->getName(),
            );
        }

        // Test value data
        $this->_options = array(
            "height"  => $height,
            "width"   => $width,
            "zoom"    => (int)$zoom,
            "lat"     => $lat,
            "long"    => $long,
            "markers" => $markers,
        );
        return json_encode($this->_options);
    }
}
