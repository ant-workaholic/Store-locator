<?php
namespace Fastgento\Storelocator\Test\Unit\Model\ResourceModel\Location;

use Magento\Framework\DataObject;
use Fastgento\Storelocator\Model\ResourceModel\Location\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    protected $collection;

    /**
     * @var \Magento\Framework\DB\Select|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $select;

    /**
     * @var \Magento\Framework\DB\Adapter\Pdo\Mysql|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $connection;

    /**
     * @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;

    /**
     * @var \Magento\Framework\Model\ResourceModel\Db\AbstractDb|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $resource;

    public function setUp()
    {
        $this->select = $this->getMockBuilder('Magento\Framework\DB\Select')
            ->disableOriginalConstructor()
            ->getMock();

        $this->connection = $this->getMockBuilder('Magento\Framework\DB\Adapter\Pdo\Mysql')
            ->disableOriginalConstructor()
            ->getMock();
        $this->connection->expects($this->any())->method('select')->willReturn($this->select);

        $this->resource = $this->getMockBuilder('Magento\Framework\Model\ResourceModel\Db\AbstractDb')
            ->disableOriginalConstructor()
            ->setMethods(['getConnection', 'getMainTable', 'getTable'])
            ->getMockForAbstractClass();
        $this->resource->expects($this->any())->method('getConnection')->willReturn($this->connection);
        $this->resource->expects($this->any())->method('getMainTable')->willReturn('table_test');
        $this->resource->expects($this->any())->method('getTable')->willReturn('test');

        $this->objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->collection = $this->objectManager->getObject(
            'Fastgento\Storelocator\Model\ResourceModel\Location\Collection',
            [
                'resource' => $this->resource,
                'connection' => $this->connection
            ]
        );
    }

    /**
     * @test
     */
    public function testAddFieldToFilter()
    {
        $field = 'name';
        $value = 'test_filter';
        $searchSql = 'sql query';

        $this->connection->expects($this->any())->method('quoteIdentifier')->willReturn($searchSql);
        $this->connection->expects($this->any())->method('prepareSqlCondition')->willReturn($searchSql);

        $this->select->expects($this->once())
            ->method('where')
            ->with($searchSql, null, \Magento\Framework\DB\Select::TYPE_CONDITION);

        $this->assertSame($this->collection, $this->collection->addFieldToFilter($field, $value));
    }
}