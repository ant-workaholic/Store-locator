<?php
namespace Fastgento\Storelocator\Model;

use \Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Fastgento\Storelocator\Api\Data\LocationInterface;
/**
 * Class Location
 *
 * @package Fastgento\Storelocator\Model
 */
class Location extends AbstractModel implements LocationInterface, IdentityInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'storelocation_location';

    protected function _construct()
    {
        $this->_init('Fastgento\Storelocator\Model\ResourceModel\Location');
    }

    /**
     * Get location description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Get location id
     *
     * @return string
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Get location longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->getData(self::LONGITUDE);
    }

    /**
     * Get location latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->getData(self::LATITUDE);
    }

    /**
     * Set location id
     *
     * @param $id
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Set name location
     *
     * @param $name
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set location longitude
     *
     * @param $longitude
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setLongitude($longitude)
    {
        return $this->setData(self::LONGITUDE, $longitude);
    }

    /**
     * Set description location
     *
     * @param $description
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Set location latitude
     *
     * @param $latitude
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     */
    public function setLatitude($latitude)
    {
        return $this->setData(self::LATITUDE, $latitude);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

}
