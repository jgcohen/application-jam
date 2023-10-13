<?php

namespace App\Tests\Entity;

use App\Entity\Flavor;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class FlavorTest extends TestCase
{
    private $flavor;
    private $product;

    protected function setUp(): void
    {
        $this->flavor = new Flavor();
        $this->product = new Product();
    }

    public function testAddProduct(): void
    {
        $this->flavor->addProduct($this->product);

        $this->assertCount(
            1,
            $this->flavor->getProducts(),
            'Failed asserting that the product count is 1 after adding a product.'
        );
        $this->assertContains(
            $this->product,
            $this->flavor->getProducts(),
            'Failed asserting that the product collection contains the added product.'
        );
    }

    public function testRemoveProduct(): void
    {
        $this->flavor->addProduct($this->product);
        $this->flavor->removeProduct($this->product);


        $this->assertCount(
            0,
            $this->flavor->getProducts(),
            'Failed asserting that the product count is 0 after removing a product.'
        );
        $this->assertNotContains(
            $this->product,
            $this->flavor->getProducts(),
            'Failed asserting that the product collection no longer contains the removed product.'
        );
    }

    public function testSetName(): void
    {
        $name = 'test';
        $this->flavor->setName($name);

        $this->assertEquals(
            $name,
            $this->flavor->getName(),
            "Failed asserting that the name is '{$name}' after setting."
        );
    }

    protected function tearDown(): void
    {
        unset($this->flavor, $this->product);
    }
}