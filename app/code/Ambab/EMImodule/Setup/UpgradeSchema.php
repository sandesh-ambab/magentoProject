<?php

namespace Ambab\EMImodule\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements  UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1.3') < 0) {
            // Get module table
            $tableName = $setup->getTable('emi_bank');
            // Check if the table already exists
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                // Declare data
                $columns = [
                'roi' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                'nullable' => true,
                'comment' => 'Month',
                ],
                ];
                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }
            }
        }        
        $setup->endSetup();
    }
}
