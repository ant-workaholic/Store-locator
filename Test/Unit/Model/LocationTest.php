<?php
namespace Fastgento\Storelocator\Test\Unit\Model;

/**
 * Class LocationTest
 * Testing cases for Location model
 *
 * @package Fastgento\Storelocator\Test\Unit\Model
 */
class LocationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Fastgento\Storelocator\Model\Location|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $thisMock;

    /**
     * @var \Magento\Backend\Block\Template\Context
     */
    protected $context;

    /**
     * @var \Fastgento\Storelocator\Model\Resource\Location|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $resourceLocationMock;

    /**
     * @var \Magento\Framework\Event\ManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $eventManagerMock;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->eventManagerMock = $this->getMockBuilder('Magento\Framework\Event\ManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $this->context = $objectManager->getObject(
            'Magento\Framework\Model\Context',
            [
                'eventDispatcher' => $this->eventManagerMock
            ]
        );

        $this->resourceLocationMock = $this->getMockBuilder('Fastgento\Storelocator\Model\Resource\Location')
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'getIdFieldName',
                ]
            )
            ->getMock();

        $this->thisMock = $this->getMockBuilder('Fastgento\Storelocator\Model\Location')
            ->setMethods(
                [
                    '_construct',
                    '_getResource',
                    'load',
                ]
            )
            ->getMock();

        $this->thisMock->expects($this->any())
            ->method('_getResource')
            ->willReturn($this->resourcePageMock);
        $this->thisMock->expects($this->any())
            ->method('load')
            ->willReturnSelf();
    }
}
