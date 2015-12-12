<?php
/**
 * Copyright © 2015 Fastgento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Fastgento\Storelocator\Block\Locator;

class Map extends \Magento\Framework\View\Element\Template
{
    /** @var  $_options */
    protected $_options;


    public function getSerializedOptions()
    {
        // Test value data
        $this->_options = array(
            "height" => "500px",
            "width"  => "auto",
            "zoom"   => 11,
            "lat"    => -34.397,
            "long"   => 150.644
        );
        return json_encode($this->_options);
    }
}
