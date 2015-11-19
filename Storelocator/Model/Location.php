<?php
namespace Fastgento\Storelocator\Model;

use \Magento\Framework\Model\AbstractModel;

/**
 * Class Location
 *
 * @package Fastgento\Storelocator\Model
 */
class Location extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Fastgento\Storelocator\Model\Resource\Location');
    }
}
