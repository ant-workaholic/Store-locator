<?php
namespace Fastgento\Storelocator\Model;

/**
 * Class LocationTest
 * @package Fastgento\Storelocator\Model
 */
class LocationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Fastgento\Storelocator\Model\Location
     */
    protected $model;

    protected function setUp()
    {
        $user = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\User\Model\User'
        )->loadByUsername(
            \Magento\TestFramework\Bootstrap::ADMIN_NAME
        );

        /** @var $session \Magento\Backend\Model\Auth\Session */
        $session = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(
            'Magento\Backend\Model\Auth\Session'
        );
        $session->setUser($user);
    }


    /**
     * @magentoDbIsolation enabled
     * @dataProvider generateLocationDataFromDataProvider
     */
    public function testGenerateIdentifierFromTitle($data, $expectedData)
    {
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        /** @var \Fastgento\Storelocator\Model\Location $location */
        $location = $objectManager->create('Fastgento\Storelocator\Model\Location');
        $location->setData($data);
        $location->save();
        $location->assertEquals($expectedData, $location->getData());
    }

    public function generateLocationDataFromDataProvider()
    {
        return [
            ['data' => ['name' => 'First location', 'stores' => [1]], 'expectedData' => ["name" => "First location"]],
        ];
    }
}