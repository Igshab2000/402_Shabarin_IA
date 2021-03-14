<?php

namespace Tests\BookTest;

use App\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testSetName()
    {
        $book = new Book();
        $book->setName("Совершенный код");

        $this->assertEquals("Совершенный код", $book->getName());
    }

    public function testSetAuthors()
    {
        $book = new Book();
        $book->setAuthors(array("Макконнелл Стив"));

        $this->assertEquals(array("Макконнелл Стив"), $book->getAuthors());
    }

    public function testSetPublisher()
    {
        $book = new Book();
        $book->setPublisher("БХВ-Петербург");

        $this->assertEquals("БХВ-Петербург", $book->getPublisher());
    }

    public function testSetYear()
    {
        $book = new Book();
        $book->setYear(2017);

        $this->assertEquals(2017, $book->getYear());
    }
}