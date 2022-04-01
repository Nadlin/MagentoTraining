<?php

namespace Amasty\NadezhdaLinnik\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()
            ->newTable($setup->getTable('amasty_nadezhdalinnik_blacklist'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Registration ID'
            )->addColumn(
                'sku',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                50,
                [
                    'nullable' => false,
                ],
                'Product SKU'
            )->addColumn(
                'qty',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                10,
                [
                    'nullable' => false,
                    'default'=> 5
                ],
                'Product Quantity'
            )->setComment('Product Black List');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
