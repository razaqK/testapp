<?php


namespace App\Tests\Services;


use App\Entity\Order;
use App\Entity\User;
use App\Services\OrderService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class OrderServiceTest extends TestCase
{
    public function testCreateProduct()
    {
        $user = new User();
        $user->setArrayValueToField(['token' => '12132323232']);


        $orderService = new OrderService(new Order());
        $order = $orderService->create(500, $user, [['product_id' => 1, 'quantity' => 2], ['product_id' => 2, 'quantity' => 4]]);


        $this->assertEquals('500', $order->getTotalPrice());
        $this->assertEquals($user, $order->getCustomer());
        $this->assertCount(2, $order->getItems());
    }

    public function testCreateProductWithInvalidParameter()
    {
        $user = new User();
        $user->setArrayValueToField(['token' => '12132323232']);


        $orderService = new OrderService(new Order());
        try {
            $order = $orderService->create('ade', $user, [['product_id' => 1, 'quantity' => 2], ['product_id' => 2, 'quantity' => 4]]);
            $this->assertInstanceOf(\TypeError::class, $order);
        } catch (\TypeError $error) {
            $this->assertInstanceOf(\TypeError::class, $error);
        }
    }
}