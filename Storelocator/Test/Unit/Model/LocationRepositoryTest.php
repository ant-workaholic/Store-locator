<?php
namespace Fastgento\Storelocator\Test\Unit\Model;

use Magento\Framework\Api\SortOrder;
use Fastgento\Storelocator\Model\LocationRepository;

class LocationRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LocationRepository
     */
    protected $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Cms\Model\ResourceModel\Block
     */
    protected $locationResource;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Cms\Model\Block
     */
    protected $location;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Fastgento\Storelocator\Api\Data\LocationInterface
     */
    protected $locationData;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Fastgento\Storelocator\Api\Data\LocationSearchResultsInterface
     */
    protected $locationSearchResult;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Api\DataObjectHelper
     */
    protected $dataHelper;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Fastgento\Storelocator\Model\ResourceModel\Location\Collection
     */
    protected $collection;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * Initialize repository
     */
    public function setUp()
    {
        $this->locationResource = $this->getMockBuilder('Fastgento\Storelocator\Model\ResourceModel\Location')
            ->disableOriginalConstructor()
            ->getMock();
        $this->dataObjectProcessor = $this->getMockBuilder('Magento\Framework\Reflection\DataObjectProcessor')
            ->disableOriginalConstructor()
            ->getMock();
        $locationFactory = $this->getMockBuilder('Fastgento\Storelocator\Model\LocationFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $locationDataFactory = $this->getMockBuilder('Fastgento\Storelocator\Api\Data\LocationInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $locationSearchResultFactory = $this->getMockBuilder('Fastgento\Storelocator\Api\Data\LocationSearchResultsInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $collectionFactory = $this->getMockBuilder('Fastgento\Storelocator\Model\ResourceModel\Location\CollectionFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->storeManager = $this->getMockBuilder('Magento\Store\Model\StoreManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $store = $this->getMockBuilder('\Magento\Store\Api\Data\StoreInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $store->expects($this->any())->method('getId')->willReturn(0);
        $this->storeManager->expects($this->any())->method('getStore')->willReturn($store);

        $this->location = $this->getMockBuilder('Fastgento\Storelocator\Model\Location')->disableOriginalConstructor()->getMock();
        $this->locationData = $this->getMockBuilder('Fastgento\Storelocator\Api\Data\LocationInterface')
            ->getMock();
        $this->locationSearchResult = $this->getMockBuilder('Fastgento\Storelocator\Api\Data\LocationSearchResultsInterface')
            ->getMock();
        $this->collection = $this->getMockBuilder('Fastgento\Storelocator\Model\ResourceModel\Location\Collection')
            ->disableOriginalConstructor()
            ->setMethods(['addFieldToFilter', 'getSize', 'setCurPage', 'setPageSize', 'load', 'addOrder'])
            ->getMock();

        $locationFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->location);
        $locationDataFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->locationData);
        $locationSearchResultFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->locationSearchResult);
        $collectionFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->collection);
        /**
         * @var \Magento\Cms\Model\LocationFactory $locationFactory
         * @var \Magento\Cms\Api\Data\LocationInterfaceFactory $locationDataFactory
         * @var \Magento\Cms\Api\Data\LocationSearchResultsInterfaceFactory $locationSearchResultFactory
         * @var \Magento\Cms\Model\ResourceModel\Block\CollectionFactory $collectionFactory
         */

        $this->dataHelper = $this->getMockBuilder('Magento\Framework\Api\DataObjectHelper')
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = new LocationRepository(
            $this->locationResource,
            $locationFactory,
            $locationDataFactory,
            $collectionFactory,
            $locationSearchResultFactory,
            $this->dataHelper,
            $this->dataObjectProcessor,
            $this->storeManager
        );
    }

    /**
     * @test
     */
    public function testSave()
    {
        $this->locationResource->expects($this->once())
            ->method('save')
            ->with($this->location)
            ->willReturnSelf();
        $this->assertEquals($this->location, $this->repository->save($this->location));
    }

    /**
     * @test
     */
    public function testDeleteById()
    {
        $locationId = '123';

        $this->location->expects($this->once())
            ->method('getId')
            ->willReturn(true);
        $this->locationResource->expects($this->once())
            ->method('load')
            ->with($this->location, $locationId)
            ->willReturn($this->location);
        $this->locationResource->expects($this->once())
            ->method('delete')
            ->with($this->location)
            ->willReturnSelf();

        $this->assertTrue($this->repository->deleteById($locationId));
    }

    /**
     * @test
     */
    public function testDelete()
    {
        $this->locationResource->expects($this->once())
            ->method('delete')
            ->with($this->location)
            ->willReturnSelf();
        $this->assertEquals(true, $this->repository->delete($this->location));
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\CouldNotSaveException
     */
    public function testSaveException()
    {
        $this->locationResource->expects($this->once())
            ->method('save')
            ->with($this->location)
            ->willThrowException(new \Exception());
        $this->repository->save($this->location);
    }

}