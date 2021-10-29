<?php
namespace Ambab\EMImodule\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
   const MODULE_ENABLE = "emi_calc_module_enable/general/enable";

   public function getDefaultConfig($path)
   {
       return $this->scopeConfig->getValue($path, \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
   }

   public function isEmiEnabled()
   {
       return (bool) $this->getDefaultConfig(self::MODULE_ENABLE);
   }
 }