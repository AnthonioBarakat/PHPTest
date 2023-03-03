<?php

namespace Classes;

require_once dirname(__FILE__) . '/product.php';
/**
 * DVD class which extends the abstract class Product construct DVD object
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
class DVD extends Product
{
    private $size;
    /**
     * DVD constructor
     *
     * @param string $sku   => SKU of the DVD
     * @param string $name  => Name of the DVD
     * @param float  $price => Price of the DVD
     * @param float  $size  => Size of the DVD
     */
    public function __construct($sku, $name, $price, $size)
    {
        if ($this->validateSize($size)) {
            $this->size = $size;
            parent::__construct($sku, $name, $price);
        }
    }
    /**
     * validateSize function
     * Validates the size of the DVD to be more than 1MB and less or equal to 17.08GB = 17080MB.
     *
     * @param  float $size Size to be validated
     * @return bool True if Size is valid, False otherwise
     */
    private function validateSize($size): bool
    {
        return is_numeric($size) && $size >= 1 && $size <= 17080;
    }


    public function save(): string
    {
        return $this->saveAtDB(1, $this->size);
    }


    public function __toString(): string
    {
        $price = sprintf("%0.2f", $this->price);
        return "<p class='card-text text-center'>{$this->sku}</p>
                <p class='card-text text-center'>{$this->name}</p>
                <p class='card-text text-center'>{$price} $</p>
                <p class='card-text text-center'>Size: {$this->size} MB</p>";
    }
}
