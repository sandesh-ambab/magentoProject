<?php

namespace Ambab\EMImodule\Block\Catalog\Product;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\AbstractProduct;

class Price extends AbstractProduct
{
    protected $_product;
    protected $registry;
    protected $_dataHelper;

 
    public function __construct(Context $context, array $data,
    \Magento\Framework\Registry $registry
    ){
        $this->registry = $registry;
        $this->_dataHelper = $dataHelper;

        parent::__construct($context, $data);
    }

    public function toShowBlock()
    {
        return $this->_dataHelper->isEmiEnabled();
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

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
 
}