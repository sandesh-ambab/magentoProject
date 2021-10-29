<?php

namespace Ambab\EMImodule\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $bankData = [
            [
                'bank_name' => 'SBI'
            ],
            [
                'bank_name' => 'HDFC'
            ]
        ];
        
        foreach($bankData as $data) {
            $setup->getConnection()->insert($setup->getTable('emi_bank'), $data);
        }
    }
}