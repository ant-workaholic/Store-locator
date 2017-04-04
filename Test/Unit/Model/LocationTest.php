<?php
namespace Fastgento\Storelocator\Test\Unit\Model;

use Fastgento\Storelocator\Model\Location;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\Context;
use Fastgento\Storelocator\Model\ResourceModel\Location as LocationResource;
use Magento\Framework\Model\ResourceModel\AbstractResource;

/**
 * Class LocationTest
 */
class LocationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Fastgento\Storelocator\Model\Location
     */
    protected $model;

    /**
     * @var
     */
    protected $contextMock;

    /**
     * @var ManagerInterface |\PHPUnit_Framework_MockObject_MockObject
     */
    protected $eventManagerMock;

    /**
     * @var LocationResource |\PHPUnit_Framework_MockObject_MockObject
     */
    protected $resourceLocationMock;

    /**
     * @var AbstractResource | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $resourceMock;

    /**
     * @var ScopeConfigInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $scopeConfigMock;


    public function setUp()
    {
        $this->eventManagerMock = $this
            ->getMockBuilder(ManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->contextMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}