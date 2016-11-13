<?php
namespace Fastgento\Storelocator\Block\Page\Head;


class Google extends \Magento\Framework\View\Element\Template
{
    /**
     * @return mixed
     */
    public function getApiKey()
    {
         return $this->_scopeConfig->getValue('fastgento/general/api_key');
    }
}