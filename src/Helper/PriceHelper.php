<?php


namespace App\Helper;


class PriceHelper extends AmountHelper
{
    public function __construct($amount)
    {
        parent::__construct($amount);
    }

    private function hasCurrency()
    {
        return preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $this->getAmount());
    }

    private function isValidCurrency()
    {
        return true; // TODO check if currency is valid from the currency list
    }

    /**
     * @return bool|string
     */
    public function currency()
    {
        if (!$this->hasCurrency() || !$this->isValidCurrency()) {
            return 'EUR';
        }

        return substr($this->getAmount(), -3) ?? 'EUR';
    }
}