<?php
namespace Ambab\EMImodule\Block\Catalog\Product;

class View extends \Magento\Framework\View\Element\Template
{
   protected $_dataHelper;

   protected $registry;
   protected $emidetailsFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Ambab\EMImodule\Helper\Data $dataHelper,
        \Magento\Framework\Registry $registry,
        \Ambab\EMImodule\Model\EmidetailsFactory $emidetailsFactory,
        array $data = []
    ) {
        $this->_dataHelper = $dataHelper;
        $this->registry = $registry;
        $this->emidetailsFactory = $emidetailsFactory;
        parent::__construct($context, $data);
    }

    public function toShowBlock()
    {
        return $this->_dataHelper->isEmiEnabled();
    }

    // public function _prepareLayout()
    // {
    //     return parent::_prepareLayout();
    // }

    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function getProductPrize()
    {
        $_product = $this->getCurrentProduct();
        $productprice = $_product->getFinalPrice(); 
        return $productprice;
    }

    public function getCollection()
    {
        return $this->emidetailsFactory->create()->getCollection();
    }
    
}