<?php

namespace App\Entity;

use App\Repository\OrderedProductRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use DateTime;

#[ORM\Entity(repositoryClass: OrderedProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class OrderedProduct
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderedProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'orderedProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $orderItem = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getOrderItem(): ?Order
    {
        return $this->orderItem;
    }

    public function setOrderItem(?Order $orderItem): static
    {
        $this->orderItem = $orderItem;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
