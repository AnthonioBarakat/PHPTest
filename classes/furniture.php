<?php

namespace Classes;

require_once dirname(__FILE__) . '/product.php';
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
class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    /**
     * Furniture constructor
     *
     * @param string $sku    => SKU of the Furniture
     * @param string $name   => Name of the Furniture
     * @param float  $price  => Price of the Furniture
     * @param float  $height => Height of the Furniture
     * @param float  $width  => Width of the Furniture
     * @param float  $length => Length of the Furniture
     */
    public function __construct($sku, $name, $price, $height, $width, $length)
    {
        if ($this->validateDimensions($height, $width, $length)) {
            $this->height = $height;
            $this->width = $width;
            $this->length = $length;
            parent::__construct($sku, $name, $price);
        }
    }

    /**
     * validateDimensions function
     * Validates the height, width and length of the Furniture
     *  to be more than a specified number for each and less than 10000.
     *
     * @param  float $height Height to be validated
     * @param  float $width  Width to be validated
     * @param  float $length Length to be validated
     * @return bool True if the three parameters is valid, False otherwise
     */
    private function validateDimensions($height, $width, $length): bool
    {
        $isValid = true;
        if (!is_numeric($height) || $height < 10 || $height > 9999) {
            $isValid = false;
        }
        if (!is_numeric($width) || $width < 15 || $width > 9999) {
            $isValid = false;
        }
        if (!is_numeric($length) || $length < 20 || $length > 9999) {
            $isValid = false;
        }
        return $isValid;
    }



    public function save(): string
    {
        return $this->saveAtDB(3, $this->height, $this->width, $this->length);
    }


    public function __toString(): string
    {
        $price = sprintf("%0.2f", $this->price);
        $height = round($this->height, 0, PHP_ROUND_HALF_UP);
        $width = round($this->width, 0, PHP_ROUND_HALF_UP);
        $length = round($this->length, 0, PHP_ROUND_HALF_UP);

        return "<p class='card-text text-center'>{$this->sku}</p>
                <p class='card-text text-center'>{$this->name}</p>
                <p class='card-text text-center'>{$price} $</p>
                <p class='card-text text-center'>Dimension: {$height}&times;{$width}&times;{$length}</p>";
    }
}
