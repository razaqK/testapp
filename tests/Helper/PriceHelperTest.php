<?php


namespace App\Tests\Helper;


use App\Helper\PriceHelper;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class PriceHelperTest extends TestCase
{
    public function testPriceHelper()
    {
        $amount = '150EUR';
        $priceHelper = new PriceHelper($amount);


        $this->assertEquals('150EUR', $priceHelper->getAmount());
        $this->assertEquals('150', $priceHelper->formattedAmount());
        $this->assertEquals('EUR', $priceHelper->currency());
    }
}