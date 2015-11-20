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
                 ->addColumn('description', Table::TYPE_TEXT, null, [], 'Description');
        }
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'cms_block_store'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('fastgento_locator_store')
        )->addColumn(
            'location_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Location ID'
        )->addColumn(
            'store_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store ID'
        )->addIndex(
            $installer->getIdxName('fastgento_locator_store', ['store_id']),
            ['store_id']
        )->addForeignKey(
            $installer->getFkName('fastgento_locator_store', 'location_id', 'fastgento_locator', 'id'),
            'location_id',
            $installer->getTable('fastgento_locator'),
            'location_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('fastgento_locator_store', 'location_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Storelocation To Store Linkage Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
