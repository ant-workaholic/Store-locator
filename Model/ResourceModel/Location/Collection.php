<?php
namespace Fastgento\Storelocator\Model\ResourceModel\Location;

/**
 * Class Collection
 *
 * @package Fastgento\Storelocator\Model\Location
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->storeManager = $storeManager;
    }

    protected function _construct()
    {
        $this->_init('Fastgento\Storelocator\Model\Location', 'Fastgento\Storelocator\Model\ResourceModel\Location');
    }


    /**
     * Retrieve nearest locations
     *
     * @param $centerLat
     * @param $centerLng
     * @param $distance
     * @return $this
     */
    public function getNearestLocations($centerLat, $centerLng, $distance)
    {
        $exprHaversine = "6371*acos(cos(radians($centerLat))*cos(radians(lat))*cos(radians(lng) - radians($centerLng)) + sin(radians($centerLat))*sin(radians(lat)))";
        $this->getSelect()
            ->columns(['distance' => new \Zend_Db_Expr($exprHaversine)])
            ->having("distance < ?", $distance)
            ->order("distance");
        return $this;
    }
}
