<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Vector;

class VectorTest extends TestCase
{
    public function testTextRepresentation() {
        $firstVector = new Vector(5, 6, 7);

        $this->assertSame("(1; 0; 5)", $firstVector->__toString());
    }

    public function testAdding() {
        $firstVector = new Vector(3, 4, 5);
        $secondVector = new Vector(6, 7, 8);

        $addVector = $firstVector->add($secondVector);

        $this->assertEquals("(9; 11; 13)", $addVector->__toString());
    }

    public function testSubtraction() {
        $firstVector = new Vector(5, 6, 7);
        $secondVector = new Vector(3, 4, 5);

        $subVector = $firstVector->sub($secondVector);

        $this->assertEquals("(2; 2; 2)", $subVector->__toString());
    }

    public function testProduct() {
        $firstVector = new Vector(2, 3, 4);
        $number = 2;

        $productVector = $firstVector->product($number);

        $this->assertEquals("(4; 6; 8)", $productVector->__toString());
    }

    public function testScalarProduct() {
        $firstVector = new Vector(3, 4, 5);
        $secondVector = new Vector(6, 7, 8);

        $scalarProductVector = $firstVector->scalarProduct($secondVector);

        $this -> assertEquals(86, $scalarProductVector);
    }

    public function testVectorProduct() {
        $firstVector = new Vector(9, 1, -5);
        $secondVector = new Vector(0, -1, 2);

        $vectorProductVector = $firstVector->vectorProduct($secondVector);

        $this->assertEquals("(-3; -18; -9)", $vectorProductVector->__toString());
    }
}
