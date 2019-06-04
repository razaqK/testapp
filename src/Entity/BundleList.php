<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BundleListRepository")
 */
class BundleList extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Product", cascade={"persist", "remove"})
     */
    private $bundle;

    /**
     * @ORM\Column(type="integer")
     */
    protected $product_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBundle(): ?Product
    {
        return $this->bundle;
    }

    public function setBundle(?Product $bundle): self
    {
        $this->bundle = $bundle;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'product_id' => $this->getProductId(),
            'bundle_id' => $this->getBundle()->getId(),
            'status' => $this->getStatus()
        ];
    }
}
