<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\User;

class UserTest extends TestCase
{
    public function testSetAndGetFirstName()
    {
        $user = new User();

        $user->setEmail('test3@gmail.com');

        $this->assertEquals('test3@gmail.com', $user->getEmail());
    }
}