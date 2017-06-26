<?php
namespace Fastgento\Storelocator\Api\Data;

/**
 * Interface LocationInterface
 * @package Fastgento\Storelocator\Api\Data
 */
interface LocationInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID          = 'id';
    const NAME        = 'name';
    const LNG         = 'lng';
    const LAT         = 'lat';
    const DESCRIPTION = 'description';
    const STREET      = 'street';
    const REGION      = 'region';
    const POSTCODE    = 'postcode';
    const IMAGE       = 'image';
    const COUNTRY_ID  = 'country_id';

    /**#@-*/

    /**
     * Get location id
     *
     * @return string
     */
    public function getId();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get location longitude
     *
     * @return string
     */
    public function getLng();

    /**
     * Get location description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get location latitude
     *
     * @return string
     */
    public function getLat();

    /**
     * Set location id
     *
     * @param $id
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setId($id);

    /**
     * Set name location
     *
     * @param $name
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setName($name);

    /**
     * Set location longitude
     *
     * @param $longitude
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setLng($longitude);

    /**
     * Set description location
     *
     * @param $description
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setDescription($description);

    /**
     * Set location latitude
     *
     * @param $latitude
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setLat($latitude);

    /**
     * Set street data
     *
     * @param string $street
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setStreet($street);

    /**
     * Retrieve street data
     *
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function getStreet();

    /**
     * Specify region
     *
     * @param $region
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setRegion($region);

    /**
     * Retrieve region
     *
     * @return string
     */
    public function getRegion();

    /**
     * Set postcode
     *
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setPostcode($postcode);

    /**
     * Get postcode
     *
     * @var string $postcode
     * @return mixed
     */
    public function getPostcode();

    /**
     * Retrieve a location image
     *
     * @return string
     */
    public function getImage();

    /**
     * Specify a location image
     *
     * @param $image
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setImage($image);

    /**
     * Set Country id
     *
     * @param $countryId
     * @return mixed
     */
    public function setCountryId($countryId);

    /**
     * Get country id
     *
     * @return mixed
     */
    public function getCountryId();
}