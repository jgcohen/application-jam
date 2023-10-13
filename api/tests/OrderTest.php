<?php

namespace App\Tests\Entity;

use App\Entity\Order;
use App\Entity\LineOrder;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private $order;

    protected function setUp(): void
    {
        $this->order = new Order();
    }

    public function testSetDatetime(): void
    {
        $datetime = new \DateTime();
        $this->order->setDatetime($datetime);

        $this->assertEquals(
            $datetime,
            $this->order->getDatetime(),
            "Failed asserting that the datetime is '{$datetime->format('c')}' after setting."
        );
    }

    public function testSetTotal(): void
    {
        $total = 100.50;
        $this->order->setTotal($total);

        $this->assertEquals(
            $total,
            $this->order->getTotal(),
            "Failed asserting that the total is '{$total}' after setting."
        );
    }

    public function testSetStatus(): void
    {
        $status = 'Processing';
        $this->order->setStatus($status);

        $this->assertEquals(
            $status,
            $this->order->getStatus(),
            "Failed asserting that the status is '{$status}' after setting."
        );
    }

    public function testAddAndRemoveLineOrder(): void
    {
        $lineOrder = new LineOrder();
        $this->order->addLineOrder($lineOrder);

        $this->assertCount(
            1,
            $this->order->getLineOrders(),
            "Failed asserting that LineOrder is added."
        );

        $this->order->removeLineOrder($lineOrder);
        $this->assertCount(
            0,
            $this->order->getLineOrders(),
            "Failed asserting that LineOrder is removed."
        );
    }

    protected function tearDown(): void
    {
        unset($this->order);
    }
}
