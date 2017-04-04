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
{
    const HOST = 'http://ipinfo.io/';

    // This is a temporary test default data
    //TODO: Should be deleted in future.
    const DEFAULT_TEST_COUNTRY = 'Germany';
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

    protected $_countryHelper;

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
        \Magento\Directory\Model\Country $countryHelper
    ) {
        $this->_client = $client;
        $this->_collectionFactory = $collectionFactory;
        $this->_countryInfo = $countryInformation;
        $this->_scopeConfig = $scopeConfig;
        $this->_logger = $logger;
        $this->_storeManager = $storeManager;
        $this->_countryHelper = $countryHelper;
        $this->getCurrentCountryName();
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
        $geolocation = $this->_scopeConfig->getValue("fastgento/general/geolocation");

        $collection = $this->_collectionFactory->create();

        $markers = array();
        /** @var $location /Fastgento/Storelocator/Model/Location */
        foreach ($collection as $location) {
            $markers[] = array(
                "latitude"    => (float)$location->getLatitude(),
                "longitude"   => (float)$location->getLongitude(),
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
            "geolocation" => $geolocation,
            "country"     => $this->getCurrentCountryName()
        );
        return json_encode($this->_options);
    }

    //TODO: Need to move the functional to another place
    //TODO: This code requires refactoring
    public function getCurrentIp()
    {
        /** @return string */
        /** @var \Magento\Framework\ObjectManagerInterface $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $a */
        $a = $om->get('Magento\Framework\HTTP\PhpEnvironment\RemoteAddress');
        return $a->getRemoteAddress();
    }

    //TODO: Need to move the functional to another place
    //TODO: This code requires refactoring
    public function sendRequest()
    {
        $json = file_get_contents("http://ipinfo.io/95.164.52.228/geo");
        $details = json_decode($json);
        return $details;
    }

    /**
     * @return mixed
     */
    public function getCurrentCountryName()
    {
        $country = $this->_countryHelper
            ->loadByCode($this->_storeManager->getStore()->getConfig('general/country/default'))
            ->getName();
        return $country;
    }
}
