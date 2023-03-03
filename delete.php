<?php

/**
 * This file contains the logic to delete items from a database using POST request.
 * It requires the "dboperations.php" file that contains the delete() function.
 *
 * PHP version: 8.2.0
 * @category Delete
 * @package
 * @author   Anthonio Barakat <barakat.anthonio@gmail.com>
 * @license  Unlicensed
 * @version  1.0.0
 * @link
 */

use Db\DbOperation;

require_once dirname(__FILE__) . '/includes/dboperations.php';

if (
    $_SERVER['REQUEST_METHOD'] == 'POST'
    && isset($_POST['del_items'])
    && !empty($_POST['del_items'])
) {
    $delete_items = $_POST['del_items'];
    $del = new DbOperation();
    $del->delete($delete_items);
    header("Location: index.php");
} else {
    header("Location: index.php");
}
