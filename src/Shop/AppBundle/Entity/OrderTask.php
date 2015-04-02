<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 02/04/15
 * Time: 20:12
 */

namespace Shop\AppBundle\Entity;

class OrderTask
{
    protected $orderId;
    protected $productId;
    protected $count;

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }
}