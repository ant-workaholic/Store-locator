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
    const LONGITUDE   = 'longitude';
    const LATITUDE    = 'latitude';
    const DESCRIPTION = 'description';
    const STREET      = 'street';
    const REGION      = 'region';
    const POSTCODE    = 'postcode';
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
    public function getLongitude();

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
    public function getLatitude();

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
    public function setLongitude($longitude);

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
    public function setLatitude($latitude);

    /**
     * Set street data
     *
     * @param string $street
     * @return mixed
     */
    public function setStreet($street);

    /**
     * Retrieve street data
     *
     * @return string
     */
    public function getStreet();

    /**
     * Specify region
     *
     * @param $region
     * @return mixed
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
     * @return mixed
     */
    public function setPostcode($postcode);

    /**
     * Get postcode
     *
     * @var string $postcode
     * @return mixed
     */
    public function getPostcode();
}