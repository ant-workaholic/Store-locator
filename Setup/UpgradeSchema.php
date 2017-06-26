<?php
/**
 * This is a class for adding addition information
 * for location entity.
 */
namespace Fastgento\Storelocator\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            /**
             * Drop entity Id columns
             */
            $setup->getConnection()->dropColumn($setup->getTable('fastgento_locator'), 'image');
            $setup->getConnection()->addColumn(
                $setup->getTable('fastgento_locator'),
                'image',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment'  => 'Location image attribute'
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable("fastgento_locator"),
                "street",
                [
                    "type"     => \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment'  => "Location street"
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable("fastgento_locator"),
                "region",
                [
                    "type"     => \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment'  => "Location region"
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable("fastgento_locator"),
                "country_id",
                [
                    "type"     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => false,
                    'comment'  => "Location country"
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable("fastgento_locator"),
                "postcode",
                [
                    "type"     => \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment'  => "Postcode"
                ]
            );
        }
        $setup->endSetup();
    }
}
