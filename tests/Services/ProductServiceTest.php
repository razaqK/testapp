<?php


namespace App\Tests\Services;


use App\Entity\Discount;
use App\Entity\Price;
use App\Entity\Product;
use App\Services\ProductService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ProductServiceTest extends TestCase
{
    public function testCreateProduct()
    {
        $discount = new Discount();
        $discount->setType('CONCRETE');
        $discount->setValue(4);

        $price = new Price();
        $price->setAmount(500);
        $price->setDiscount($discount);
        $price->setCurrency('EUR');
        $price->setDiscountedAmount();


        $productService = new ProductService(new Product());
        $product = $productService->create($price, ['name' => 'product']);


        $this->assertEquals('500', $product->getAmount());
        $this->assertEquals('496', $product->getDiscountedAmount());
        $this->assertEquals('EUR', $product->getCurrency());
        $this->assertEquals(false, $product->getIsBundle());
        $this->assertEquals('product', $product->getName());
    }

    public function testCreateProductWithoutDiscount()
    {
        $discount = new Discount();
        $discount->setType('CONCRETE');

        $price = new Price();
        $price->setAmount(500);
        $price->setDiscount($discount);
        $price->setCurrency('EUR');
        $price->setDiscountedAmount();


        $productService = new ProductService(new Product());
        $product = $productService->create($price, ['name' => 'product']);


        $this->assertEquals('500', $product->getAmount());
        $this->assertEquals('0', $product->getDiscountedAmount());
        $this->assertEquals('EUR', $product->getCurrency());
        $this->assertEquals(false, $product->getIsBundle());
        $this->assertEquals('product', $product->getName());
    }

    public function testUpdateProductName()
    {
        $discount = new Discount();
        $discount->setType('CONCRETE');

        $price = new Price();
        $price->setAmount(500);
        $price->setDiscount($discount);
        $price->setCurrency('EUR');
        $price->setDiscountedAmount();

        $oldProduct = new Product();
        $oldProduct->setArrayValueToField(['amount' => 300, 'discounted_amount' => 0, 'currency' => 'EUR', 'is_bundle' => false, 'name' => 'old product']);


        $productService = new ProductService(new Product());
        $product = $productService->update($oldProduct, null, 'new product');


        $this->assertEquals('300', $product->getAmount());
        $this->assertEquals('0', $product->getDiscountedAmount());
        $this->assertEquals('EUR', $product->getCurrency());
        $this->assertEquals(false, $product->getIsBundle());
        $this->assertEquals('new product', $product->getName());
    }

    public function testUpdateProduct()
    {
        $discount = new Discount();
        $discount->setType('PERCENT');
        $discount->setValue(10);

        $price = new Price();
        $price->setAmount(400);
        $price->setDiscount($discount);
        $price->setCurrency('EUR');
        $price->setDiscountedAmount();

        $oldProduct = new Product();
        $oldProduct->setArrayValueToField(['amount' => 300, 'discounted_amount' => 0, 'currency' => 'EUR', 'is_bundle' => false, 'name' => 'old product']);


        $productService = new ProductService(new Product());
        $product = $productService->update($oldProduct, $price, 'new product');


        $this->assertEquals('400', $product->getAmount());
        $this->assertEquals('360', $product->getDiscountedAmount());
        $this->assertEquals('EUR', $product->getCurrency());
        $this->assertEquals(false, $product->getIsBundle());
        $this->assertEquals('new product', $product->getName());
    }
}