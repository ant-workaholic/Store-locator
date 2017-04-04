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
     * Prefix of the model
     *
     * @var string
     */
    protected $_eventPrefix = "fastgento_storelocator";


    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface              $storeManager
     * @param \Magento\Framework\Model\Context                        $context
     * @param \Magento\Framework\Registry                             $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb           $resourceCollection
     * @param array                                                   $data
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->_storeManager = $storeManager;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data); // TODO: Change the autogenerated stub
    }

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

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->getData(self::REGION);
    }

    /**
     * @param $region
     * @return $this
     */
    public function setRegion($region)
    {
        return $this->setData(self::REGION, $region);
    }

    /**
     * Retrieve a street of the specific location
     *
     * @return mixed
     */
    public function getStreet()
    {
        return $this->getData(self::STREET);
    }

    /**
     * Specify a street address
     */
    public function setStreet($street)
    {
        $this->setData(self::STREET, $street);
    }

    public function getPostcode()
    {
        return $this->getData(self::POSTCODE);
    }

    public function setPostcode($postcode)
    {
        $this->setData(self::POSTCODE, $postcode);
    }


    /**
     * Get image url
     *
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getImageUrl()
    {
        $url = false;
        $image = $this->getImage();
        if ($image) {
            if (is_string($image)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'location/item/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
}
