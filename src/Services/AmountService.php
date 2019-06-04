<?php


namespace App\Services;


use App\Entity\Discount;
use App\Entity\Price;
use App\Helper\DiscountHelper;
use App\Helper\PriceHelper;

class AmountService
{
    public function preparePrice($priceValue, $discountValue) : Price
    {
        $discount = $this->prepareDiscount($discountValue);

        $priceHelper = new PriceHelper($priceValue);
        $price = new Price($priceHelper->formattedAmount(), $discount);
        $price->setCurrency($priceHelper->currency());
        $price->setDiscountedAmount();
        return $price;
    }

    public function prepareDiscount($value) : Discount
    {
        $discountHelper = new DiscountHelper($value);
        // create price and discount
        $discount = new Discount();
        $discount->setType($discountHelper->type());
        $discount->setValue($discountHelper->formattedAmount());

        return $discount;
    }
}