<?php

namespace Ambab\EMImodule\Block\Catalog\Product;


class Price extends \Magento\Framework\View\Element\Template
{
    protected $checkoutSession;
    protected $scopeConfigInterface;
    protected $GetSalableQuantityDataBySku;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface,
        \Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku $GetSalableQuantityDataBySku,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->scopeConfigInterface = $scopeConfigInterface;
        $this->GetSalableQuantityDataBySku = $GetSalableQuantityDataBySku;

        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    // For getting subtotal 
    public function getSubtotal()
    {
        return $this->getActiveQuoteAddress()->getBaseSubtotal();
    }

    // For getting minimum order amount
    public function getMinimumOrderAmount()
    {
        return $this->scopeConfigInterface->getValue('sales/minimum_order/amount');
    }

    protected function getActiveQuoteAddress()
    {
        $quote = $this->checkoutSession->getQuote();
        if ($quote->isVirtual()) {
            return $quote->getBillingAddress();
        }

        return $quote->getShippingAddress();
    }

    // Prodcut salable qty
    public function getProductSalableQty($sku)
    {
        $salableQty = $this->GetSalableQuantityDataBySku->execute($sku);
        return $salableQty[0]['qty'];
    }
}
