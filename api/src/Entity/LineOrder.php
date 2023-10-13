<?php

namespace App\Entity;

use App\Repository\LineOrderRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiProperty;
#[ORM\Entity(repositoryClass: LineOrderRepository::class)]

#[ApiResource(
    operations: [
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
        new GetCollection(normalizationContext: ['groups' => ['read:lineOrders']]),

    ],
    normalizationContext: ['groups' => ['read:lineOrder']],
)]
class LineOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $quantity;

    #[ORM\Column(type: 'float')]
    #[Groups(['read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $subtotal;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'lineOrders')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty(readableLink: true, writableLink: true)]
    #[Groups(['read:lineOrder', 'read:lineOrders'])]
    private $order_associated;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(nullable: false,onDelete:"CASCADE")]
    #[Groups(['read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    #[ApiProperty(readableLink: true, writableLink: true)]
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(float $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function getOrderAssociated(): ?Order
    {
        return $this->order_associated;
    }

    public function setOrderAssociated(?Order $order_associated): self
    {
        $this->order_associated = $order_associated;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
    public function __toString(){
        return $this->quantity." ".$this->product->getName();
    }
}
