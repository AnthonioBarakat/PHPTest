<?php

namespace Classes;

use db\DbOperation;

require_once 'includes/dboperations.php';
/**
 * Abstract class Product represents a product object with SKU, name, and price properties
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
abstract class Product
{
    // Properties
    protected $sku;
    protected $name;
    protected $price;
    private static $NbOfProducts = 0;


    /**
     * Product constructor.
     *
     * @param string $sku   SKU of the product
     * @param string $name  Name of the product
     * @param float  $price Price of the product
     */
    public function __construct($sku, $name, $price)
    {
        if ($this->validateData($sku, $name, $price)) {
            $this->sku = $sku;
            $this->name = $name;
            $this->price = $price;
            Product::$NbOfProducts += 1;
        }
    }

    public static function getNbOfProducts()
    {
        return Product::$NbOfProducts;
    }



    /**
     * Validates the SKU, name, and price data
     *
     * @param  string $sku   SKU of the product
     * @param  string $name  Name of the product
     * @param  float  $price Price of the product
     * @return bool Returns true if the data is valid, false otherwise
     */
    protected function validateData($sku, $name, $price): bool
    {
        $name = filter_var($name, 513);
        $price = filter_var($price, 520);
        return strlen($sku) == 9 || strlen($sku) == 8;
    }

    /**
     * Saves the product to the database
     *
     * @param  int   $typeId       Type ID of the product
     * @param  mixed ...$typeValue special attribute of the specified type
     * @return string Returns a string message indicating the status of the operation
     */
    protected function saveAtDB($typeId, ...$typeValue): string
    {
        $new_product = new DbOperation();
        $opStatus = $new_product->addProduct(
            $this->sku,
            $this->name,
            $this->price,
            $typeId,
            ...$typeValue
        );
        switch ($opStatus) {
            case 0:
                return "Product already exists";
            break;
            case 1:
                return "Product Added successfully";
            break;
            case 2:
                return "There is an error in query execution";
            break;
            case 3:
                return "There is an error in create the json att";
            break;
        }
    }

    /**
     * Abstract function to be implmented by all the classes
     *  that inherit Product in order to save the product
     *
     * @return string Returns a string message indicating the status of the operation
     */
    abstract protected function save(): string;


    public function getSKU()
    {
        return $this->sku;
    }
}
