<?php

/**
 * This file create new products by checking the required fields
 * and creating an instance of the appropriate product type.
 * Supported product types include DVDs, books, and furniture.
 *
 * PHP version: 8.2.0
 * @category Add
 * @package
 * @author   Anthonio Barakat <barakat.anthonio@gmail.com>
 * @license  Unlicensed
 * @version  1.0.0
 * @link
 */

use Classes\DVD;
use Classes\Book;
use Classes\Furniture;

require_once dirname(__FILE__) . '/classes/dvd.php';
require_once dirname(__FILE__) . '/classes/book.php';
require_once dirname(__FILE__) . '/classes/furniture.php';


/**
* Checks whether the required fields are set and not empty.
* If any of the fields are not set or empty, it returns false,
* otherwise, it returns true.
*
* @return bool Returns a boolean value, true or false.
*/
function checkIsset()
{
    if (!isset($_POST['p_sku']) || empty($_POST['p_sku'])) {
        return false;
    }
    if (!isset($_POST['p_name']) || empty($_POST['p_name'])) {
        return false;
    }
    if (!isset($_POST['p_price']) || empty($_POST['p_price'])) {
        return false;
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' and checkIsset()) {
    $p_sku = $_POST['p_sku'];
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $type = $_POST['type'];


    /* Check if special attribute is set
    to decide what is the product type  */
    if (!empty($_POST['size'])) {
        $size = $_POST['size'];
        $new_dvd = new DVD($p_sku, $p_name, $p_price, $size);
        $message = $new_dvd->save();
        header("Location: index.php");
    } elseif (!empty($_POST['weight'])) {
        $weight = $_POST['weight'];
        $new_book = new Book($p_sku, $p_name, $p_price, $weight);
        $message = $new_book->save();
        header("Location: index.php");
    } elseif (
        !empty($_POST['height'])
        && !empty($_POST['width'])
        && !empty($_POST['length'])
    ) {
        $height = $_POST['height'];
        $width = $_POST['width'];
        $length = $_POST['length'];
        $new_furn = new Furniture(
            $p_sku,
            $p_name,
            $p_price,
            $height,
            $width,
            $length
        );
        $message = $new_furn->save();
        header("Location: index.php");
    }
}
