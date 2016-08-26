<?php
namespace Fastgento\Storelocator\Api\Data;

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

}