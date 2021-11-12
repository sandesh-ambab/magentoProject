<?php

namespace Ambab\EMImodule\Block\Catalog\Product;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use \Magento\Framework\Data\Collection\AbstractDb;
use \Magento\Framework\Data\Collection;

class Price extends \Magento\Framework\View\Element\Template
{
    protected $_dataHelper;

    protected $registry;
    protected $emidetailsFactory;
    protected $checkoutSession;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Ambab\EMImodule\Helper\Data $dataHelper,
        \Magento\Framework\Registry $registry,
        \Ambab\EMImodule\Model\EmidetailsFactory $emidetailsFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        array $data = []
    ) {
        $this->_dataHelper = $dataHelper;
        $this->registry = $registry;
        $this->emidetailsFactory = $emidetailsFactory;
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
    }

    public function toShowBlock()
    {
        return $this->_dataHelper->isEmiEnabled();
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

    public function getCollection()
    {
        return $this->emidetailsFactory->create()->getCollection();
    }

    public function getOnlyBank()
    {
        $emiData = $this->emidetailsFactory->create();
        $collection = $emiData->getCollection()
            ->distinct(true)
            ->addFieldToSelect('bank_name')
            ->load();

        return $collection;
    }

    public function getBankDetails($bankName)
    {
        $emiData = $this->emidetailsFactory->create();
        $collection = $emiData->getCollection()
            ->addFieldToFilter('bank_name', ['like'=>$bankName])
            ->load();

        return $collection;
    }

    public function emiCalculation($price, $r, $month)
    {
        $emi = ($price * $r * pow(1 + $r, $month)) / (pow(1 + $r, $month) - 1);
        return $emi;
    }

    public function getItemsQty($itemId = 0) // 0 for all items
    {
        return $this->getActiveQuoteAddress()->getItemQty($itemId);
    }

    /**
     * @return float
     */
    public function getSubtotal()
    {
        return $this->getActiveQuoteAddress()->getBaseSubtotal(); // or any other type of subtotal like subtotal incl tax etc.
    }

    /**
     * @return \Magento\Quote\Model\Quote\Address
     */
    protected function getActiveQuoteAddress()
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->checkoutSession->getQuote();
        if ($quote->isVirtual()) {
            return $quote->getBillingAddress();
        }

        return $quote->getShippingAddress();
    }
}
