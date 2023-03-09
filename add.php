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

use Classes\DVDFactory;
use Classes\BookFactory;
use Classes\FurnitureFactory;

require_once dirname(__FILE__) . '/classes/factories.php';


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

function getAttribute()
{
    if (isset($_POST['size']) && !empty($_POST['size'])) {
        return array('size' => $_POST['size']);
    } elseif (isset($_POST['weight']) && !empty($_POST['weight'])) {
        return array('weight' => $_POST['weight']);
    } elseif (
        isset($_POST['height']) && !empty($_POST['height'])
        && isset($_POST['width']) && !empty($_POST['width'])
        && isset($_POST['length']) && !empty($_POST['length'])
    ) {
            return array(
                'height' => $_POST['height'],
                'width' => $_POST['width'],
                'length' => $_POST['length']
            );
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST' and checkIsset()) {
    $p_sku = $_POST['p_sku'];
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];

    $type = $_POST['type'];



    $factories = array(
        'DVD' => new DVDFactory(),
        'BOOK' => new BookFactory(),
        'FURNITURE' => new FurnitureFactory(),
    );


    /* Check if special attribute is set
    to decide what is the product type  */
    $attributes = getAttribute();

    $p_type = $factories[$type];
    $new_p = $p_type->createProduct($p_sku, $p_name, $p_price, $attributes);
    $message = $new_p->save();
    if ($message == 0) {
        echo "
        <script>
        alert('Product SKU already exist');
        window.location.href = 'index.php';
        </script>";
    } else {
        header("Location: index.php");
    }
}
