<?php
/**
 * Copyright © 2015 Fastgento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Fastgento\Storelocator\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('fastgento_locator')) {
             $table = $installer->getConnection()->newTable(
                 $installer->getTable('fastgento_locator')
             );
             $table->addColumn(
                 'id',
                 Table::TYPE_INTEGER,
                 null,
                 [
                     'identity' => true,
                     'unsigned' => true,
                     'nullable' => false,
                     'primary' => true
                 ], 'Location ID')
                 ->addColumn('name', Table::TYPE_TEXT, 255, ['nullable'  => false,], 'Location Name')
                 ->addColumn('longitude', Table::TYPE_FLOAT, null, [], 'Longitude')
                 ->addColumn('latitude', Table::TYPE_FLOAT, null, [], 'Latitude')
                 ->addColumn('name', Table::TYPE_TEXT, null, [], 'Name')
                 ->addColumn('description', Table::TYPE_TEXT, null, [], 'Description');
        }
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
