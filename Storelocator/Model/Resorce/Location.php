<?php
namespace Fastgento\Storelocator\Model\Resource;

/**
 * Class Location
 *
 * @package Fastgento\Storelocator\Model\Resource
 */
class Location extends \Magento\Framework\Model\Resource\Db\AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('fastgento_locator', 'id');
    }
}
