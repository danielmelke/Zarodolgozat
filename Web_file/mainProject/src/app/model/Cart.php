<?php 

namespace app\model;

use db\Database;
use PDO;

require_once('src/db/Database.php');

class Cart
{
    private $id;
    private $product_id;
    private $amount;
    private $measure;
    private $content;
    private $unique_id;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of product_id
     */ 
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */ 
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }
    
    /**
     * Get the value of measure
     */ 
    public function getMeasure()
    {
        return $this->measure;
    }

    /**
     * Set the value of measure
     *
     * @return  self
     */ 
    public function setMeasure($measure)
    {
        $this->measure = $measure;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of unique_id
     */ 
    public function getUnique_id()
    {
        return $this->unique_id;
    }

    /**
     * Set the value of unique_id
     *
     * @return  self
     */ 
    public function setUnique_id($unique_id)
    {
        $this->unique_id = $unique_id;

        return $this;
    }

    public static function findAll()
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `shopping_cart`";
        $statement = $conn->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function findAllById($id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `shopping_cart` WHERE `id` = :id";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ":id" => $id
        ]);
        return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function load($product, $cart)
    {
        $this->amount = $cart['amount'];
        $this->content = $cart['content'];
        $this->product_id = $product['name'];
    }

    public function create()
    {
        $conn = Database::getConnection();
        $sql = "INSERT INTO `shopping_cart`
        (`id` ,`product_id`, `amount`, `measure`, `content`)
        VALUES (:id, :product_id, :amount, :measure, :content)";
        $statement = $conn->prepare($sql);
        $result = $statement->execute([
            ":id" => $this->id,
            ":product_id" => $this->product_id,
            ":amount" => $this->amount,
            ":measure" => $this->measure,
            ":content" => $this->content
        ]);
        if ($result)
        {
            return true;
        }
        return false;
    }
}