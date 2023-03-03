<?php

namespace Db;

/**
 * This class provides methods for performing various database operations related to products.
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
class DbOperation
{
    private $con;

    // Constructor method for initializing the database connection.
    public function __construct()
    {
        require_once dirname(__FILE__) . '/dbconnect.php';
        $db = new DbConnect();
        $this -> con = $db->connect();
    }

    /**
     * A private method for checking if a product with the given SKU already exists in the database.
     * @param string $sku Sku of the product
     * @return bool true if the value exist
     */
    private function isProductExist($sku)
    {
        $stmt = $this->con->prepare("SELECT * FROM items WHERE SKU = ?");
        $stmt->bind_param("s", $sku);
        $stmt->execute();
        $stmt->store_result();
// result stored in stmt
        return $stmt->num_rows > 0 ;
    }

    /**
     * A public method for adding a new product to the database
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param int $typeId sended by the child class(1, 2 ,3)
     * @param array $typeValue The number of values and their meaning depend on the product type ID.
     * For type 1 (DVD), there should be 1 value, which represents the size of the DVD.
     * For type 2 (book), there should be 1 value, which represents the weight of the book.
     * For type 3 (furniture), there should be 3 values, which represent the height, width, and length of the furniture.
     *
     * @return int number depending on the result
     * 0: If a product with the given SKU already exists in the database.
     * 1: If the product was successfully added to the database.
     * 2: If there was an error adding the product to the database.
     * 3: If the given product type ID is invalid.
     */
    public function addProduct($sku, $name, $price, $typeId, ...$typeValue)
    {
        if ($this->isProductExist($sku)) {
            return 0;
        } else {
            $myObj = [];
            switch ($typeId) {
                case 1:
                    $myObj["size"] = $typeValue[0];
                    break;
                case 2:
                    $myObj["weight"] = $typeValue[0];
                    break;
                case 3:
                    $myObj["height"] = $typeValue[0];
                    $myObj["width"] = $typeValue[1];
                    $myObj["length"] = $typeValue[2];
                    break;
                default:
                    return 3;
                    break;
            }
            $stmt = $this->con->prepare("INSERT INTO items
                    VALUES (?, ?, ?, ?, ?);");
        // prepar query
            $att = json_encode($myObj);
            $stmt->bind_param("ssdis", $sku, $name, $price, $typeId, $att);
            return $stmt->execute() ? 1 : 2;
        }
    }

    /**
     * getDVD, getBook(), getFurniture for retrieving all products of each type from the database.
     * It returns an array of arrays, where each inner array represents a single product
     * contains the following keys: 'sku', 'name', 'price', and 'valueType'
     */
    public function getDVD()
    {
        $DVDs = [];
        $qu1 = "SELECT * FROM items, types WHERE types.id=1 AND types.id=typeId";
        $result = mysqli_query($this->con, $qu1);
        while ($row = mysqli_fetch_array($result)) {
            $d = array(  'sku' => $row['SKU'],
                            'name' => $row['name'],
                            'price' => $row['price'],
                            'valueType' => $row['valueType'],
                        );
            array_push($DVDs, $d);
        }
        return $DVDs;
    }

    public function getBook()
    {
        $Books = [];
        $qu1 = "SELECT * FROM items, types WHERE types.id=2 AND types.id=typeId";
        $result = mysqli_query($this->con, $qu1);
        while ($row = mysqli_fetch_array($result)) {
            $b = array(  'sku' => $row['SKU'],
                            'name' => $row['name'],
                            'price' => $row['price'],
                            'valueType' => $row['valueType'],
                        );
            array_push($Books, $b);
        }
        return $Books;
    }

    public function getFurniture()
    {
        $Furnitures = [];
        $qu1 = "SELECT * FROM items, types WHERE types.id=3 AND types.id=typeId";
        $result = mysqli_query($this->con, $qu1);
        while ($row = mysqli_fetch_array($result)) {
            $f = array(  'sku' => $row['SKU'],
                            'name' => $row['name'],
                            'price' => $row['price'],
                            'valueType' => $row['valueType'],
                        );
            array_push($Furnitures, $f);
        }
        return $Furnitures;
    }

    /**
     * A public method for deleting one or more products from the database.
     * @param array $sku_arr represent an array of all sku's product that should be deleted
     */
    public function delete($sku_arr)
    {
        for ($i = 0; $i < count($sku_arr); $i++) {
            $stmt = $this->con->prepare("DELETE FROM items WHERE SKU = ?");
            $stmt->bind_param("s", $sku_arr[$i]);
            $stmt->execute();
        }
    }
}
