<?php

namespace App\Entity;

use App\Repository\ProductRepository;
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

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
        new GetCollection(normalizationContext: ['groups' => ['read:products']]),

    ],
    normalizationContext: ['groups' => ['read:product']],
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:product', 'read:products', 'read:categories', 'read:category','read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:product', 'read:products', 'read:categories', 'read:category','read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:product', 'read:products', 'read:categories', 'read:category','read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['read:product', 'read:products', 'read:categories', 'read:category','read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $image;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read:product', 'read:products', 'read:categories', 'read:category','read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private $price;

    #[Groups(['read:product', 'read:products', 'read:categories', 'read:category','read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    private int $quantity = 0;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'products')]
    #[Groups(['read:product', 'read:products','read:lineOrder', 'read:lineOrders', 'read:order', 'read:orders'])]
    #[ApiProperty(readableLink: true, writableLink: true)]
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getFullName(): ?string
    {
        return $this->name . " - " . $this->price;
    }
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }



    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
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

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);


        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
