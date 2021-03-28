<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Product;
use App\ProductCollection;
use App\ManufacturerFilter;
use App\MaxPriceFilter;

class FilterTest extends TestCase
{
    public function testFilter()
    {
        $p1 = new Product();
        $p1->name = 'Шоколад';
        $p1->price = 100;
        $p1->discount = 50;
        $p1->manufacturer = 'Красный Октябрь';

        $p2 = new Product();
        $p2->name = 'Мармелад';
        $p2->price = 100;
        $p2->manufacturer = 'Ламзурь';

        $p3 = new Product();
        $p3->name = 'Зефир';
        $p3->price = 67;
        $p3->manufacturer = 'Lacky days';


        $collection = new ProductCollection([$p1, $p2, $p3]);
        $resultCollection = $collection->filter(new MaxPriceFilter(70));
        $this -> assertSame(2, count($resultCollection -> getProductsArray()));
        $resultCollection = $collection->filter(new ManufacturerFilter('Ламзурь'));
        $this -> assertSame(1, count($resultCollection -> getProductsArray()));
        $this -> assertSame('Мармелад', $resultCollection -> getProductsArray()[0] -> name);
    }
}
