<?php

namespace Ambab\CustomApi\Api;

interface OrderDetailsInterface
{
    /**
    * @api
    * @param int 
    * @return string 
    */

    public function getOrderDetails($orderId);
}