<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ambab\EMImodule\Model;


use Ambab\EMImodule\Block\Catalog\Product\View as Emi;

class DefaultConfigProvider
{
 
    protected $isEnable;

    
    
    public function __construct( Emi $isEnable) {
        $this->isEnable = $isEnable;
    }

    private function isEmiEnabled()
    {
        return $this->isEnable->toShowBlock();
    }
}
