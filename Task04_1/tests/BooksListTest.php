<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\BooksList;
use App\Book;

class BooksListTest extends TestCase
{
    public function testAddAndCount()
    {
        $book = new Book();
        $booksList = new BooksList();
        $booksList->add($book);
        $this->assertSame(1, $booksList->count());
    }

    public function testGet()
    {
        $book = new Book();
        $booksList = new BooksList();
        $book->setName("Совершенный код")->setAuthors(array("Макконнелл Стив"))
            ->setPublisher("БХВ-Петербург")->setYear(2017);
        $booksList->add($book);
        $this -> assertInstanceOf(Book::class, $booksList -> get(1));
    }

    public function testStore()
    {
        $book = new Book();
        $booksList = new BooksList();
        $book->setName("Совершенный код")->setAuthors(array("Макконнелл Стив"))
            ->setPublisher("БХВ-Петербург")->setYear(2017);
        $booksList->add($book);
        $this -> assertSame(null, $booksList -> store("output"));
    }

    public function testLoad()
    {
        $booksList = new BooksList();
        $booksList->load("output");
        $this->assertSame(1, $booksList->count());
        $this->assertInstanceOf(Book::class, $booksList->get(1));
    }

    public function testCurrentAndKey()
    {
        $book1 = new Book();
        $book2 = new Book();
        $book3 = new Book();
        $booksList = new BooksList();
        $book1 -> setName("Совершенный код")->setAuthors(array("Макконнелл Стив"))
            ->setPublisher("БХВ-Петербург")->setYear(2017);
        $book2 -> setName("Design Patterns")->setAuthors(array("Эрих Гамма", "Ричард Хелм", "Ральф Джонсон", "Джон Влиссидес"))
            ->setPublisher("Addison-Wesley")->setYear(1994);
        $book3 -> setName("Чистый код. Создание, анализ и рефакторинг")
            ->setAuthors(array("Мартин Роберт К."))
            ->setPublisher("Питер")->setYear(2019);
        $booksList -> add($book1);
        $booksList -> add($book2);
        $booksList -> add($book3);

        $this->assertSame(
            "Id: 4" . "\n" .
            "Название: Совершенный код" . "\n" .
            "Автор 1: Макконнелл Стив" . "\n" .
            "Издательство: БХВ-Петербург" . "\n" .
            "Год: 2017",
            $booksList -> current() -> __toString()
        );
        $this -> assertSame(4, $booksList -> key());
        return $booksList;
    }

    /**
     * @depends testCurrentAndKey
     */

    public function testNext(BooksList $booksList)
    {
        $booksList->next();
        $this->assertSame(
            "Id: 5" . "\n" .
            "Название: Design Patterns" . "\n" .
            "Автор 1: Эрих Гамма" . "\n" .
            "Автор 2: Ричард Хелм" . "\n".
            "Автор 3: Ральф Джонсон" . "\n".
            "Автор 4: Джон Влиссидес" . "\n".
            "Издательство: Addison-Wesley" . "\n" .
            "Год: 1994",
            $booksList -> current() -> __toString()
        );
        $booksList->next();
        $this->assertSame(
            "Id: 6" . "\n" .
            "Название: Чистый код. Создание, анализ и рефакторинг" . "\n" .
            "Автор 1: Мартин Роберт К." . "\n" .
            "Издательство: Питер" . "\n" .
            "Год: 2019",
            $booksList -> current() -> __toString()
        );

        return $booksList;
    }

    /**
     * @depends testNext
     */

    public function testValidAndRewind(BooksList $booksList)
    {
        $booksList -> next();
        $this -> assertSame(false, $booksList -> valid());
        $booksList -> rewind();
        $this -> assertSame(true, $booksList -> valid());
        $this -> assertSame(
            "Id: 4" . "\n" .
            "Название: Совершенный код" . "\n" .
            "Автор 1: Макконнелл Стив" . "\n" .
            "Издательство: БХВ-Петербург" . "\n" .
            "Год: 2017",
            $booksList->current()->__toString()
        );
    }
}
