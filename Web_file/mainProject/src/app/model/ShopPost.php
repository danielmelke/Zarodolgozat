<?php 

namespace app\model;

use db\Database;
use PDO;

require_once('src/db/Database.php');

class ShopPost
{
    private $cart_id;
    private $owner_id;
    
    /**
     * Get the value of cart_id
     */ 
    public function getCart_id()
    {
        return $this->cart_id;
    }

    /**
     * Set the value of cart_id
     *
     * @return  self
     */ 
    public function setCart_id($cart_id)
    {
        $this->cart_id = $cart_id;

        return $this;
    }

    /**
     * Get the value of owner_id
     */ 
    public function getOwner_id()
    {
        return $this->owner_id;
    }

    /**
     * Set the value of owner_id
     *
     * @return  self
     */ 
    public function setOwner_id($owner_id)
    {
        $this->owner_id = $owner_id;

        return $this;
    }

    function generate_cart_id() {
        $numlength = 20;
        $array = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 
                'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 
                'u', 'v', 'w', 'x', 'y', 'z'];
        $cart_id = "";

        for ($i = 0; $i < $numlength; $i++) { 
            $cart_id .= $array[rand(0, count($array) - 1)];
        }

        return $cart_id;
    }

    public function create($owner_id)
    {
        $this->owner_id = $owner_id;
        $this->cart_id = $cart_id = $this->generate_cart_id();
        $conn = Database::getConnection();
        $sql = "INSERT INTO `shopping_posts` (`cart_id`, `owner_id`) VALUES (:cart_id, :owner_id)";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ":cart_id" => $cart_id,
            ":owner_id" => $owner_id
        ]);
    }
}