<?php

namespace App;

class Book
{
    private static $lastId = 1;
    private $id;
    private $name;
    private $authors;
    private $publisher;
    private $year;

    public function __construct()
    {
        $this->id = self::$lastId++;
    }

    public function setName($name): Book
    {
        $this->name = $name;

        return $this;
    }

    public function setAuthors($authors): Book
    {
        $this->authors = $authors;

        return $this;
    }

    public function setPublisher($publisher): Book
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function setYear($year): Book
    {
        $this->year = $year;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function __toString(): string
    {
        $authorsArray = $this->authors;
        $authors = "";
        for ($i = 0; $i < count($authorsArray); $i++) {
            $authors .= "Автор " . ($i + 1) . ": " . $authorsArray[$i] . "\n";
        }

        return "Id: {$this->id}" . "\n" .
            "Название: {$this->name}" . "\n" .
            $authors .
            "Издательство: {$this->publisher}" . "\n" .
            "Год: {$this->year}";
    }
}
