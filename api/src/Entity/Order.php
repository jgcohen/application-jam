<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
use App\Controller\CheckoutController;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    operations: [
        new Get(),
        new Post(
            name: 'checkout',
            uriTemplate: '/checkout',
            controller: CheckoutController::class,
            stateless: false,
        ),
        new Put(),
        new Patch(),
        new Delete(),
        new GetCollection(normalizationContext: ['groups' => ['read:orders']]),

    ],
    normalizationContext: ['groups' => ['read:order']],
)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $id;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $datetime;

    #[ORM\Column(type: 'float')]
    #[Groups(['read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $total;

    #[ORM\OneToMany(mappedBy: 'order_associated', targetEntity: LineOrder::class, cascade: ["persist"])]
    #[Groups(['read:order', 'read:orders'])]
    #[ApiProperty(readableLink: true, writableLink: true)]
    private $lineOrders;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $status;

    public function __construct()
    {
        $this->lineOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }


    /**
     * @return Collection|LineOrder[]
     */
    public function getLineOrders(): Collection
    {
        return $this->lineOrders;
    }

    public function addLineOrder(LineOrder $lineOrder): self
    {
        if (!$this->lineOrders->contains($lineOrder)) {
            $this->lineOrders[] = $lineOrder;
            $lineOrder->setOrderAssociated($this);
        }

        return $this;
    }

    public function removeLineOrder(LineOrder $lineOrder): self
    {
        if ($this->lineOrders->removeElement($lineOrder)) {
            // set the owning side to null (unless already changed)
            if ($lineOrder->getOrderAssociated() === $this) {
                $lineOrder->setOrderAssociated(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }
}
