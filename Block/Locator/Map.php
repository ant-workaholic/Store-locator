<?php
/**
 * Copyright © 2016 Fastgento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Fastgento\Storelocator\Block\Locator;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\View\Element\Template;
use Fastgento\Storelocator\Model\ResourceModel\Location\CollectionFactory as LocationCollectionFactory;

/**
 * Class Map
 *
 * @package Fastgento\Storelocator\Block\Locator
 */
class Map extends \Magento\Framework\View\Element\Template
    implements \Magento\Framework\DataObject\IdentityInterface
{
    /**
     * Options storage parameter
     *
     * @var  $_options
     */
    protected $_options;

    /**
     * Collection factory
     *
     * @var LocationCollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var
     */
    protected $_client;

    /**
     * @var
     */
    protected $_countryInfo;

    /**
     * @var
     */
    protected $_scopeConfig;

    /**
     * @var
     */
    protected $_logger;

    /**
     * @var \Magento\Directory\Model\Country
     */
    protected $_countryHelper;

    protected $_directoryBlock;
    /**
     * Init collection factory
     *
     * @param Template\Context                    $context
     * @param array                               $data
     * @param LocationCollectionFactory           $collectionFactory
     * @param \Magento\Framework\HTTP\Client\Curl $client
     */
    public function __construct(
        Template\Context $context,
        array $data = [],
        LocationCollectionFactory $collectionFactory,
        \Magento\Framework\HTTP\Client\Curl $client,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Directory\Api\CountryInformationAcquirerInterface $countryInformation,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Block\Data $directoryBlock
    ) {
        $this->_client = $client;
        $this->_collectionFactory = $collectionFactory;
        $this->_countryInfo = $countryInformation;
        $this->_scopeConfig = $scopeConfig;
        $this->_logger = $logger;
        $this->_storeManager = $storeManager;
        $this->_directoryBlock = $directoryBlock;

        parent::__construct($context, $data);
    }

    /**
     * Get serialized options
     *
     * @return string
     */
    public function getSerializedOptions()
    {
        $height = $this->_scopeConfig->getValue("fastgento/general/height");
        $width = $this->_scopeConfig->getValue("fastgento/general/width");
        $zoom = $this->_scopeConfig->getValue("fastgento/general/zoom");
        $lat = $this->_scopeConfig->getValue("fastgento/general/lat");
        $long = $this->_scopeConfig->getValue("fastgento/general/long");
        $geoLocation = $this->_scopeConfig->getValue("fastgento/general/geolocation");

        $collection = $this->_collectionFactory->create();

        $markers = array();
        /** @var $location /Fastgento/Storelocator/Model/Location */
        foreach ($collection as $location) {
            $markers[] = array(
                "latitude"    => (float)$location->getLat(),
                "longitude"   => (float)$location->getLng(),
                "title"       => $location->getName(),
                "description" => $location->getDescription()
            );
        }

        // TODO: Need to implement functionality which uses the country data from the current store
        $this->_options = array(
            "height"      => $height,
            "width"       => $width,
            "zoom"        => (int)$zoom,
            "lat"         => $lat,
            "long"        => $long,
            "markers"     => $markers,
            "geolocation" => $geoLocation,
            "url"         => $this->getUrl('rest/V1/locations'),
        );
        return json_encode($this->_options);
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [\Fastgento\Storelocator\Model\Location::CACHE_TAG . '_' . "map"];
    }

    /**
     * @param null|string $defValue
     * @param string $name
     * @param string $id
     * @param string $title
     * @return string
     */
    public function getCountryHtmlSelect($defValue = null, $name = 'country_id', $id = 'country', $title = 'Country')
    {
        $html = $this->_directoryBlock->getCountryHtmlSelect($defValue, $name, $id, $title);
        return $html;
    }
}
