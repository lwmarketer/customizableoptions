<?php
/**
 * Copyright © 2016 SW-THEMES. All rights reserved.
 */

namespace Lovevox\CustomizableOptions\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        //catalog_product_option_type_value 扩展swatch color值
        $installer->getConnection()->addColumn(
            $installer->getTable('catalog_product_option_type_value'),
            'swatch',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 12,
                'nullable' => true,
                'default' => '',
                'comment' => 'swatch color value'
            ]
        );
        $installer->endSetup();
    }
}
