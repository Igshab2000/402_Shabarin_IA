<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Truncater;

class TruncaterTest extends TestCase
{
    public function testTrancate()
    {
        $truncater1 = new Truncater();
        $truncater2 = new Truncater(['length' => 7]);
        $this->assertSame("Hello...", $truncater1->truncate("Hello, World!", ['length' => 5]));
        $this->assertSame("Hello, World!", $truncater1->truncate("Hello, World!"));
        $this->assertSame(
            "Hello, Wor---",
            $truncater2->truncate("Hello, World!", ['length' => 10,'separator' => '---'])
        );
        $this->assertSame("Hello, ...", $truncater2->truncate("Hello, World!"));
    }
}