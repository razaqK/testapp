<?php

namespace App\Controller;

use App\Constant\Messages;
use App\Entity\Order;
use App\Entity\Product;
use App\Services\OrderService;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends BaseController
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function placeOrder(Request $request)
    {
        $user = $request->attributes->get('auth_user');
        $data = json_decode($request->getContent(), true);
        $validator = $this->validateParameters($data, ['products' => 'required']);
        if (!$validator['status']) {
            return $this->sendError($validator['message'], 400, $validator['data']);
        }

        $productIds = array_column($data['products'], 'product_id');

        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->getProductsByIds($productIds);
        if (!$products) {
            return $this->sendError(sprintf(Messages::NOT_FOUND, 'product records'), 404);
        }

        $totalDiscounted = 0;
        $actualTotalPrice = 0;
        foreach ($data['products'] as $product) {
            $key = array_search($product['product_id'], array_column($products, 'product_id'));
            $prod = $products[$key];
            $totalDiscounted += ($prod['discounted_amount'] * $product['quantity']);
            $actualTotalPrice += ($prod['amount'] * $product['quantity']);
        }

        $order = $this->orderService->create($totalDiscounted, $user, $data['products']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();


        return $this->sendSuccess(['id' => $order->getId(), 'identifier' => $order->getIdentifier(), 'total_price' => $order->getTotalPrice()], 201, sprintf(Messages::CREATED, 'order'));
    }

    public function getOrder(Request $request, $id)
    {
        $order = $this->getDoctrine()->getManager()
            ->getRepository(Order::class)->find($id);
        if (!$order) {
            return $this->sendError(sprintf(Messages::NOT_FOUND, 'order'), 404);
        }

        return $this->sendSuccess($order->toArray());
    }
}
