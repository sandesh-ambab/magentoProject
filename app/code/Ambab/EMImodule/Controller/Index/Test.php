<?php
namespace Ambab\EMImodule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Ambab\EMImodule\Block\Catalog\Product\View;

class Test extends Action
{
	private $resultJsonFactory;
	protected $blockData;
 
    public function __construct(JsonFactory $resultJsonFactory, Context $context, View $blockData)
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
		$this->blockData = $blockData;
    }

	public function execute()
	{
		$resultJson = $this->resultJsonFactory->create(); 
		$jsonData = $this->blockData->getJsonData();
		return $resultJson->setData($jsonData);
	}
}