<?php

namespace App\Entity;


use App\Helper\DiscountHelper;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PriceRepository")
 */
class Price extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    private $full_amount;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    private $amount;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    private $discounted_amount;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Discount", cascade={"persist", "remove"})
     */
    private $discount;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $currency;

    public function __construct(float $amount = null, ?Discount $discount = null)
    {
        parent::__construct();
        $this->setAmount($amount);
        $this->setDiscount($discount);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullAmount()
    {
        return $this->full_amount;
    }

    public function setFullAmount($full_amount): self
    {
        $this->full_amount = $full_amount;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDiscountedAmount()
    {
        return $this->discounted_amount;
    }

    public function setDiscountedAmount(): self
    {
        $this->discounted_amount = $this->calculateDiscount();

        return $this;
    }

    public function getDiscount(): ?Discount
    {
        return $this->discount;
    }

    public function setDiscount(?Discount $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    private function calculateDiscount()
    {
        if ($this->getDiscount()->getValue() <= 0) {
            return 0;
        }

        if ($this->getDiscount()->getType() == DiscountHelper::CONCRETE) {
            return $this->getAmount() - $this->getDiscount()->getValue();
        }

        return $this->getAmount() - $this->calculateBasedOnConcretePercent();
    }

    private function calculateBasedOnConcretePercent()
    {
        return $this->getAmount() * $this->getDiscount()->covertPercentToConcrete();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->getAmount(),
            'discount' => $this->getDiscountedAmount(),
            'currency' => $this->getCurrency(),
            'status' => $this->getStatus()
        ];
    }
}
