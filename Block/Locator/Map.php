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
        \Magento\Directory\Api\CountryInformationAcquirerInterface $countryInformation
    ) {
        $this->_client = $client;
        $this->_collectionFactory = $collectionFactory;
        $this->_countryInfo = $countryInformation;
        $this->_scopeConfig = $scopeConfig;
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
            "height"  => $height,
            "width"   => $width,
            "zoom"    => (int)$zoom,
            "lat"     => $lat,
            "long"    => $long,
            "markers" => $markers,
            "country" => self::DEFAULT_TEST_COUNTRY
        );
        return json_encode($this->_options);
    }

    /**
     * Retrieve current ip
     */
    public function getCurrentIp()
    {
        /** @return string */
        /** @var \Magento\Framework\ObjectManagerInterface $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $a */
        $a = $om->get('Magento\Framework\HTTP\PhpEnvironment\RemoteAddress');
        return $a->getRemoteAddress();
    }

    public function sendRequest()
    {
        $json = file_get_contents("http://ipinfo.io/95.164.52.228/geo");
        $details = json_decode($json);
        return $details;
    }

//    /**
//     * @return mixed
//     */
    public function getCurrentCountryName()
    {
        $countryId = $this->_scopeConfig->getValue('general/store_information/country_id');
        return $countryId;
    }
}
