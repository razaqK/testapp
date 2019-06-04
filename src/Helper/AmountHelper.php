<?php


namespace App\Helper;


abstract class AmountHelper
{
    private $amount;
    private $formatted;
    private $isFormatted = false;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @throws \Exception
     */
    private function format()
    {
        $amount = abs((float)$this->getAmount());
        if (empty($amount)) {
            throw new \Exception("Invalid Amount");
        }

        $this->formatted = $amount;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function formattedAmount()
    {
        if (!$this->isFormatted) {
            $this->format();
        }
        return $this->formatted;
    }

}