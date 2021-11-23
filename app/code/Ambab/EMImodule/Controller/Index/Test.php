<?php
namespace Mageplaza\HelloWorld\Controller\Index;

use Magento\Framework\Controller\Result\JsonFactory;

class Test extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $resultJsonFactory;
	protected $blockData;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Ambab\EMImodule\Block\Catalog\Product\View $blockData,
		JsonFactory $resultJsonFactory)
	{
		$this->_pageFactory = $pageFactory;
		$this->resultJsonFactory = $resultJsonFactory;
		$this->blockData = $blockData;
		return parent::__construct($context);
	}

	public function execute()
	{
		$resultJson = $this->resultJsonFactory->create(); 
		$jsonData = $this->blockData->getJsonData();
		$result = $resultJson->setData($jsonData);
		return $result; 

	}
}