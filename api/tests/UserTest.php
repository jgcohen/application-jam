<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testSetEmail(): void
    {
        $email = 'test@example.com';
        $this->user->setEmail($email);

        $this->assertEquals(
            $email,
            $this->user->getEmail(),
            "Failed asserting that the email is '{$email}' after setting."
        );
    }

    public function testSetRoles(): void
    {
        $roles = ['ROLE_ADMIN'];
        $this->user->setRoles($roles);

        $expectedRoles = ['ROLE_ADMIN', 'ROLE_USER'];  // Since ROLE_USER is added by default

        $this->assertEquals(
            $expectedRoles,
            $this->user->getRoles(),
            "Failed asserting that the roles match expected roles after setting."
        );
    }

    public function testSetPassword(): void
    {
        $password = 'password123';
        $this->user->setPassword($password);

        $this->assertEquals(
            $password,
            $this->user->getPassword(),
            "Failed asserting that the password is '{$password}' after setting."
        );
    }

    protected function tearDown(): void
    {
        unset($this->user);
    }
}
