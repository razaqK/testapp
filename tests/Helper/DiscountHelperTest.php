<?php


namespace App\Tests\Helper;


use App\Helper\DiscountHelper;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DiscountHelperTest extends TestCase
{
    public function testPreparePriceOnConcreteDiscount()
    {
        $amount = '-15%';
        $priceHelper = new DiscountHelper($amount);


        $this->assertEquals('-15%', $priceHelper->getAmount());
        $this->assertEquals('15', $priceHelper->formattedAmount());
        $this->assertEquals('PERCENT', $priceHelper->type());
    }
}