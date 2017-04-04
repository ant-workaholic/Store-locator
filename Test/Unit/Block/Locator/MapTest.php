<?php
namespace Fastgento\Storelocator\Test\Unit\Block;

class MapTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Magento\Cms\Block\Block
     */
    protected $block;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->block = $objectManager->getObject('Fastgento\Storelocator\Block\Locator\Map');
    }

    protected function tearDown()
    {
        $this->block = null;
    }

    public function testGetIdentities()
    {
        $this->assertEquals([\Fastgento\Storelocator\Model\Location::CACHE_TAG . '_' . 'map'], $this->block->getIdentities());
    }
}