<?php

/**
 * A class for creating a database connection.
 *
 * PHP version: 8.2.0
 *
 * @category Database
 * @package  Db
 * @author   Anthonio Barakat <barakat.anthonio@gmail.com>
 * @license  Unlicensed
 * @version  1.0.0
 * @link
 */

namespace Db;

class DbConnect
{
    private $con;

    public function __construct()
    {
    }
    public function connect()
    {
        include_once dirname(__FILE__) . "/constants.php";
        $this -> con = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if (mysqli_connect_errno()) { // this method return true if failed to connect to database
            echo "Failed to connect with database " . mysqli_connect_error(); // get the error as string
        }

        return $this -> con;
    }
}
