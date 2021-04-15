<?php 

namespace app\model;

use db\Database;
use PDO;

require_once('src/db/Database.php');

class Product
{
    private $id;
    private $name;

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
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public static function findAll()
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `shopping_products`";
        $statement = $conn->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function findOneById($id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `shopping_products` WHERE `id` = :id";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ":id" => $id
        ]);
        return $statement->fetchObject(self::class);
    }

    public function alreadyExists($name)
    {
        $conn = Database::getConnection();
        $sql = "SELECT `name` FROM `shopping_products`";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, self::class);
        foreach ($result as $item)
        {
            if ($item->getName() == $name)
            {
                return true;
            }
        }
        return false;
    }

    public function addNewProduct($name)
    {
        if (!($this->alreadyExists($name)))
        {  
            $conn = Database::getConnection();
            $sql = "INSERT INTO `shopping_products` (`name`) VALUES (:name)";
            $statement = $conn->prepare($sql);
            $result = $statement->execute([
                ":name" => $name
            ]);
            if ($result)
            {
                return true;
            }
            return false;
        }
        return false;

    }
}