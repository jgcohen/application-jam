<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    private $category;

    protected function setUp(): void
    {
        $this->category = new Category();
    }

    public function testSetName(): void
    {
        $name = 'Electronics';
        $this->category->setName($name);

        $this->assertEquals(
            $name,
            $this->category->getName(),
            "Failed asserting that the name is '{$name}' after setting."
        );
    }

    public function testSetDescription(): void
    {
        $description = 'Various electronic products.';
        $this->category->setDescription($description);

        $this->assertEquals(
            $description,
            $this->category->getDescription(),
            "Failed asserting that the description is '{$description}' after setting."
        );
    }

    public function testSetSlug(): void
    {
        $slug = 'electronics';
        $this->category->setSlug($slug);

        $this->assertEquals(
            $slug,
            $this->category->getSlug(),
            "Failed asserting that the slug is '{$slug}' after setting."
        );
    }

    public function testAddAndRemoveProduct(): void
    {
        $product = new Product();
        $this->category->addProduct($product);

        $this->assertCount(
            1,
            $this->category->getProducts(),
            "Failed asserting that Product is added."
        );

        $this->category->removeProduct($product);
        $this->assertCount(
            0,
            $this->category->getProducts(),
            "Failed asserting that Product is removed."
        );
    }

    protected function tearDown(): void
    {
        unset($this->category);
    }
}