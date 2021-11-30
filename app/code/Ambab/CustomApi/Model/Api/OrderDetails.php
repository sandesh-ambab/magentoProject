<?php

namespace Ambab\CustomApi\Model\Api;

use Psr\Log\LoggerInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;

class OrderDetails
{
    protected $logger;
    protected $productRepository;
    protected $_storeManager;
    
    public function __construct(
        LoggerInterface $logger,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepo,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storemanager
    )
    {
        $this->logger = $logger;
        $this->orderRepo = $orderRepo;
        $this->productRepository = $productRepository;
        $this->_storeManager =  $storemanager;
    }
    public function getOrderDetails($orderId)
    {
        try {
            $order = $this->orderRepo->get($orderId);
            $result = [];
            $i = 0;
            $result['Order_no'] = $order->getEntityId();

            // Get items details
            foreach ($order->getAllItems() as $item){
                $result['items'][$i]['name'] = $item->getName();
                $result['items'][$i]['quantity'] = $item->getQtyOrdered();
                $result['items'][$i]['special_price'] = $item->getPrice();
                $result['items'][$i]['regular_price'] = $item->getOriginalPrice();
                $result['items'][$i]['discount_price'] = $item->getDiscountAmount();
                $productId = $result['items'][$i]['product_id'] = $item->getProductId();

                // Get Image url
                $product = $this->productRepository->getById($productId);
                $store = $this->_storeManager->getStore();
                $result['items'][$i]['image_url'] = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' .$product->getImage();
                $i++;
            }

            // Get shipping info
            $result['Shipping_Address'] = $order->getShippingAddress()->getData();
            $result['Shipping_Method'] = $order->getShippingMethod();
            $result['Shipping_Amount'] = $order->getShippingAmount();
            
            // Get payment method
            $result['Payment Method'] = $order->getPayment()->getMethod();

            $response = ['success' => 'Orders information getting successfully', 'message' => $result];
        }
        catch (\Exception $e) {$response = ['success' => false, 'message' => $e->getMessage()];
            $this->logger->info($e->getMessage());
        }

        return $response;
    }
}