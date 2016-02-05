<?php
namespace Fastgento\Storelocator\Test\Unit\Controller\Adminhtml;


use Magento\Cms\Test\Unit\Controller\Adminhtml\AbstractMassActionTest;

/**
 * Class MassDeleteTest
 *
 * @package Fastgento\Storelocator\Test\Unit\Controller\Adminhtml
 */
class MassDeleteTest extends AbstractMassActionTest
{
    protected $massDeleteController;

    protected $collectionFactoryMock;

    protected $locationCollectionMock;

    protected function setUp()
    {
        parent::setUp();

        $this->collectionFactoryMock = $this->getMock('Fastgento\Storelocator\Model\ResourceModel\Location\CollectionFactory',
            ['create'],
            [], '',
            false
        );

        $this->locationCollectionMock = $this->getMock('Fastgento\Storelocator\Model\ResourceModel\Location\Collection', [], [], '', false);

        $this->massDeleteController = $this->objectManager->getObject(
            'Fastgento\Storelocator\Controller\Adminhtml\Index\MassDelete',
            [
                'context' => $this->contextMock,
                'filter' => $this->filterMock,
                'collectionFactory' => $this->collectionFactoryMock
            ]
        );
    }
    public function testMassDeleteAction()
    {
        $deletedLocationsCount = 2;

        $collection = [
            $this->getLocationMock(),
            $this->getLocationMock()
        ];

        $this->collectionFactoryMock->expects($this->once())->method('create')->willReturn($this->locationCollectionMock);

        $this->filterMock->expects($this->once())
            ->method('getCollection')
            ->with($this->locationCollectionMock)
            ->willReturn($this->locationCollectionMock);

        $this->locationCollectionMock->expects($this->once())->method('getSize')->willReturn($deletedLocationsCount);
        $this->locationCollectionMock->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator($collection));

        $this->messageManagerMock->expects($this->once())
            ->method('addSuccess')
            ->with(__('A total of %1 record(s) have been deleted.', $deletedLocationsCount));
        $this->messageManagerMock->expects($this->never())->method('addError');

        $this->resultRedirectMock->expects($this->once())
            ->method('setPath')
            ->with('*/*/')
            ->willReturnSelf();

        $this->assertSame($this->resultRedirectMock, $this->massDeleteController->execute());
    }

    /**
     * Create Location Collection Mock
     *
     * @return \Fastgento\Storelocator\Model\ResourceModel\Location\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getLocationMock()
    {
        $blockMock = $this->getMock('Fastgento\Storelocator\Model\ResourceModel\Location\Collection', ['delete'], [], '', false);
        $blockMock->expects($this->once())->method('delete')->willReturn(true);

        return $blockMock;
    }
}