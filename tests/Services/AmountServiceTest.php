<?php


namespace App\Tests\Services;


use App\Services\AmountService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class AmountServiceTest extends TestCase
{

    public function testPreparePriceOnConcreteDiscount()
    {
        $price = '150EUR';
        $discount = '-5EUR';
        $amountService = new AmountService();
        $price = $amountService->preparePrice($price, $discount);


        $this->assertEquals('150', $price->getAmount());
        $this->assertEquals('145', $price->getDiscountedAmount());
        $this->assertEquals('EUR', $price->getCurrency());
    }

    public function testPreparePriceOnConcreteDiscountExceptionCase()
    {
        $this->expectException(\Exception::class);

        $price = '*150EUR';
        $discount = '*5EUR';
        $amountService = new AmountService();
        $amountService->preparePrice($price, $discount);
    }

    public function testPreparePriceOnPercentageDiscount()
    {
        $price = '150EUR';
        $discount = '-5%';
        $amountService = new AmountService();
        $price = $amountService->preparePrice($price, $discount);


        $this->assertEquals('150', $price->getAmount());
        $this->assertEquals('142.5', $price->getDiscountedAmount());
        $this->assertEquals('EUR', $price->getCurrency());
    }

    public function testPrepareDiscountOnConcreteDiscount()
    {
        $discount = '-5EUR';
        $amountService = new AmountService();
        $discount = $amountService->prepareDiscount($discount);


        $this->assertEquals('5', $discount->getValue());
    }

    public function testPrepareDiscountOnConcreteDiscountExceptionCase()
    {
        $this->expectException(\Exception::class);

        $discount = '-*5EUR';
        $amountService = new AmountService();
        $amountService->prepareDiscount($discount);
    }

    public function testPrepareDiscountOnPercentageDiscount()
    {
        $discount = '-5%';
        $amountService = new AmountService();
        $discount = $amountService->prepareDiscount($discount);


        $this->assertEquals('5', $discount->getValue());
    }

}