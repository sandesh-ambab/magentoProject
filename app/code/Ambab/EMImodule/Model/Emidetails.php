<?php
namespace Ambab\EMImodule\Model;

use Ambab\EMImodule\Api\Data\EmidetailsInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Emidetails extends AbstractModel implements EmidetailsInterface, IdentityInterface
{
	const CACHE_TAG = 'ambab_emicalc';
	
	//Unique identifier for use within caching
	protected $_cacheTag = self::CACHE_TAG;
	
	protected function _construct()
    {
        $this->_init('Ambab\EMImodule\Model\ResourceModel\Emidetails');
    }
	
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }

    public function getId()
	{
		return parent::getData(self::BANK_ID);
	}

	public function getBankName()
	{
		return $this->getData(self::BANK_NAME); 
	}

    public function setId($id)
    {
        return $this->setData(self::BANK_ID, $id);
    }
	
	public function setBankName($bank_name)
    {
        return $this->setData(self::BANK_NAME, $bank_name);
    }
}

