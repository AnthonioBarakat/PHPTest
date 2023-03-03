<?php

namespace Classes;

require_once dirname(__FILE__) . '/product.php';
/**
 * Book class which extends the abstract class Product construct Book object
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
class Book extends Product
{
    private $weight;
    /**
     * Book constructor
     *
     * @param string $sku    => SKU of the book
     * @param string $name   => Name of the book
     * @param float  $price  => Price of the book
     * @param float  $weight => Weight of the book
     */
    public function __construct($sku, $name, $price, $weight)
    {
        if ($this->validateWeight($weight)) {
            $this->weight = $weight;
            parent::__construct($sku, $name, $price);
        }
    }

    /**
     * validateWeight function
     * Validates the weight of the book to be more than 0.1kg and less or equal to 10kg.
     *
     * @param  float $weight Weight to be validated
     * @return bool True if weight is valid, False otherwise
     */
    private function validateWeight($weight): bool
    {
        return is_numeric($weight) && $weight >= 0.1 && $weight <= 10;
    }


    public function save(): string
    {
        return $this->saveAtDB(2, $this->weight);
    }


    public function __toString(): string
    {
        $price = sprintf("%0.2f", $this->price);
        return "<p class='card-text text-center'>{$this->sku}</p>
                <p class='card-text text-center'>{$this->name}</p>
                <p class='card-text text-center'>{$price} $</p>
                <p class='card-text text-center'>Weight: {$this->weight} KG</p>";
    }
}
