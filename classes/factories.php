<?php

namespace Classes;

require_once dirname(__FILE__) . '/dvd.php';
require_once dirname(__FILE__) . '/book.php';
require_once dirname(__FILE__) . '/furniture.php';
/**
 * Furniture class which extends the abstract class Product construct Furniture object
 *
 * PHP version: 8.2.0
 *
 * @category Initialize
 * @package  Classes
 * @author   Anthonio Barakat <barakat.anthonio@gmail.com>
 * @license  Unlicensed
 * @version  1.0.0
 * @link
 */
interface ProductFactory
{
    public function createProduct($sku, $name, $price, $attributes);
}

class DVDFactory implements ProductFactory
{
    public function createProduct($sku, $name, $price, $attributes)
    {
        $size = $attributes['size'];
        return new DVD($sku, $name, $price, $size);
    }
}

class BookFactory implements ProductFactory
{
    public function createProduct($sku, $name, $price, $attributes)
    {
        $weight = $attributes['weight'];
        return new Book($sku, $name, $price, $weight);
    }
}

class FurnitureFactory implements ProductFactory
{
    public function createProduct($sku, $name, $price, $attributes)
    {
        $height = $attributes['height'];
        $width = $attributes['width'];
        $length = $attributes['length'];
        return new Furniture($sku, $name, $price, $height, $width, $length);
    }
}
