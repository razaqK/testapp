<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_bundle;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    protected $amount;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    protected $discounted_amount;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $currency;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BundleList", mappedBy="bundle", cascade={"persist", "remove"})
     */
    private $bundleList;

    public function __construct()
    {
        parent::__construct();
        $this->bundleList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsBundle(): ?bool
    {
        return $this->is_bundle;
    }

    public function setIsBundle(bool $is_bundle): self
    {
        $this->is_bundle = $is_bundle;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDiscountedAmount()
    {
        return $this->discounted_amount;
    }

    public function setDiscountedAmount(float $discountedAmount): self
    {
        $this->discounted_amount = $discountedAmount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return Collection|BundleList[]
     */
    public function getBundleList(): Collection
    {
        return $this->bundleList;
    }

    public function addBundleList(BundleList $bundleList): self
    {
        if (!$this->bundleList->contains($bundleList)) {
            $this->bundleList[] = $bundleList;
            $bundleList->setBundle($this);
        }

        return $this;
    }

    public function removeBundleList(BundleList $bundleList): self
    {
        if ($this->bundleList->contains($bundleList)) {
            $this->bundleList->removeElement($bundleList);
            // set the owning side to null (unless already changed)
            if ($bundleList->getBundle() === $this) {
                $bundleList->setBundle(null);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'currency' => $this->getCurrency(),
            'amount' => $this->getAmount(),
            'discount' => $this->getDiscountedAmount(),
            'status' => $this->getStatus(),
            'is_bundle' => (bool)$this->getIsBundle(),
            'list' => json_decode($this->serialize($this->getBundleList()), true)
        ];
    }
}
