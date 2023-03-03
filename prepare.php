<?php

/**
 * Description: This file contains the All class which integrates and prepare all the products.
 *
 * PHP version: 8.2.0
 *
 * @category Prepare
 * @package
 * @author   Anthonio Barakat <barakat.anthonio@gmail.com>
 * @license  Unlicensed
 * @version  1.0.0
 * @link
 */

namespace Prepare;

use Classes\DVD;
use Classes\Book;
use Classes\Furniture;
use Db\DbOperation;

require_once dirname(__FILE__) . '/includes/dboperations.php';
require_once dirname(__FILE__) . '/classes/dvd.php';
require_once dirname(__FILE__) . '/classes/book.php';
require_once dirname(__FILE__) . '/classes/furniture.php';

/**
 * All class.
 * Integrates all the products and prepares them to be displayed in index.php.
 */
class All
{
    /**
     * @var array $DVDs holds an array of all DVDs
     * @var array $Books holds an array of all books
     * @var array $Furnitures holds an array of all Furnitures
     * @var array $all_products holds an array of all Products
     */
    private $DVDs;
    private $Books;
    private $Furnitures;
    private $all_products = [];

    /**
     * Constructor method.
     * Gets all the DVDs, Books, and Furnitures from the database using the DbOperation class.
     */
    public function __construct()
    {
        $p_obj = new DbOperation();
        $this->DVDs = $p_obj->getDVD();
        $this->Books = $p_obj->getBook();
        $this->Furnitures = $p_obj->getFurniture();
    }

    /**
     * Prepares all DVDs.
     * Iterates over all the DVDs and creates new DVD objects with their values.
     * Add the created DVD object to the $_all_products array.
     */
    private function prepareDVDs()
    {
        foreach ($this->DVDs as $d) {
            $size = json_decode($d['valueType'], true);
            $new_d = new DVD($d['sku'], $d['name'], $d['price'], $size['size']);
            array_push($this->all_products, $new_d);
        }
    }

    /**
     * Prepares all Books.
     * Iterates over all the Books and creates new Book objects with their values.
     * Add the created book object to the $_all_products array.
     */
    private function prepareBooks()
    {
        foreach ($this->Books as $b) {
            $weight = json_decode($b['valueType'], true);
            $new_b = new Book($b['sku'], $b['name'], $b['price'], $weight['weight']);
            array_push($this->all_products, $new_b);
        }
    }

    /**
     * Prepares all Furnitures.
     * Iterates over all the Furnitures and creates new Furniture objects with their values.
     * Add the created Furniture object to the $_all_products array.
     */
    private function prepareFurnitures()
    {
        foreach ($this->Furnitures as $f) {
            $att = json_decode($f['valueType'], true);
            $new_f = new Furniture(
                $f['sku'],
                $f['name'],
                $f['price'],
                $att['height'],
                $att['width'],
                $att['length']
            );
            array_push($this->all_products, $new_f);
        }
    }

    /**
     * Integrates all the products.
     * Calls the _prepareDVDs(), _prepareBooks(), and _prepareFurnitures() methods.
     * Returns an array containing all the products.
     *
     * @return array:Product
     */
    public function integrateAll(): array
    {
        $this->prepareDVDs();
        $this->prepareBooks();
        $this->prepareFurnitures();
        return $this->all_products;
    }
}
