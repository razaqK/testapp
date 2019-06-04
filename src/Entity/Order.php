<?php

namespace App\Entity;

use App\Constant\Status;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order extends BaseEntity
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
    private $identifier;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    private $total_price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $customer_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="orders", cascade={"persist", "remove"})
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        parent::__construct();
        $this->setStatus(Status::PROCESSING);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getTotalPrice()
    {
        return $this->total_price;
    }

    public function setTotalPrice($totalPrice): self
    {
        $this->total_price = $totalPrice;

        return $this;
    }

    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    public function setCustomerId(?int $customerId): self
    {
        $this->customer_id = $customerId;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setOrder($this);
        }

        return $this;
    }

    public function removeItem(OrderItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getOrder() === $this) {
                $item->setOrder(null);
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
            'customer_id' => $this->getCustomerId(),
            'total_price' => $this->getTotalPrice(),
            'status' => $this->getStatus(),
            'customer' => json_decode($this->serialize($this->getCustomer()), true),
            'list' => json_decode($this->serialize($this->getItems()), true)
        ];
    }
}
