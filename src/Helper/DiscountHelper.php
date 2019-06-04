<?php


namespace App\Helper;


class DiscountHelper extends AmountHelper
{
    const CONCRETE = "CONCRETE";
    const PERCENT = "PERCENT";
    private $isConcrete = true;

    public function __construct($amount)
    {
        parent::__construct($amount);
    }

    public function type()
    {
        if (strpos($this->getAmount(), '%') !== false) {
            $this->isConcrete = false;
            return self::PERCENT;
        }
        return self::CONCRETE;
    }
}