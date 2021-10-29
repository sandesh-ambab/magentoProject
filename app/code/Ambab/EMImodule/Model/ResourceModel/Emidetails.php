<?php
namespace Ambab\EMImodule\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Emidetails extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }
	
	/**
     * Define main table
     */
	protected function _construct()
	{
		$this->_init('emi_bank', 'id');
	}
}
?>
