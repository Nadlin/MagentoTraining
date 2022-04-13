<?php

namespace Amasty\NadezhdaLinnik\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.2', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('amasty_nadezhdalinnik_blacklist'),
                'email_body',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'default' => '',
                    'comment' => 'Email Body Template'
                ]
            );
        }

        $setup->endSetup();
    }
}
