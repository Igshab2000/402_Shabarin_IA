<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\BooksList;
use App\Book;
use App\FileLogger;
use App\DBLogger;

class LoggerTest extends TestCase
{
    public function testLog()
    {
        $fileLogger = new FileLogger('logs');
        $booksList1 = new BooksList($fileLogger);
        $this -> assertTrue(file_exists("./logs/logs.txt"));
        $sizeLogsTxt = sizeof(file("./logs/logs.txt"));
        $book1 = new Book();
        $book2 = new Book();
        $book3 = new Book();
        $booksList1->add($book1);
        $booksList1->add($book2);
        $booksList1->add($book3);
        $this->assertSame($sizeLogsTxt + 3, sizeof(file("./logs/logs.txt")));
        
        $dbLogger = new DbLogger('logs');
        $booksList2 = new BooksList($dbLogger);
        $this -> assertTrue(file_exists("./logs/logs.db"));
        $booksList2->add($book1);
        $booksList2->add($book2);
        $booksList2->add($book3);
    }
}
