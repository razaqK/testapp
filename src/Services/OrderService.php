<?php


namespace App\Services;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Helper\Util;

class OrderService
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    public function create(int $total, User $customer, array $items)
    {
        $this->order->setTotalPrice($total);
        $this->order->setCustomerId($customer->getId());
        $this->order->setCustomer($customer);
        $this->order->setIdentifier(Util::generateRandomShortCode(10));
        $this->addItems($items);
        return $this->order;
    }

    private function createItem(int $productId, int $quantity)
    {
        $item = new OrderItem();
        $item->setIdentifier(Util::generateRandomShortCode(10));
        $item->setProductId($productId);
        $item->setOrder($this->order);
        $item->setQuantity($quantity);
        return $item;
    }

    private function addItems(array $items)
    {
        foreach($items as $item)
        {
            $orderItem = $this->createItem($item['product_id'], $item['quantity']);
            $this->order->addItem($orderItem);
        }
    }
}