<?php
namespace Fastgento\Storelocator\Model\Location;

/**
 * Class Collection
 *
 * @package Fastgento\Storelocator\Model\Location
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Fastgento\Storelocator\Model\Location', 'Fastgento\Storelocator\Model\Resource\Location');
    }
}
