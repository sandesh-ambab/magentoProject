<?php
namespace Ambab\EMImodule\Model\ResourceModel\Emidetails;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
	
	protected $_eventPrefix = 'emicalc_emidetails_collection';

    protected $_eventObject = 'emidetails_collection';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
	{
		$this->_init('Ambab\EMImodule\Model\Emidetails', 'Ambab\EMImodule\Model\ResourceModel\Emidetails');
	}
}
?>
