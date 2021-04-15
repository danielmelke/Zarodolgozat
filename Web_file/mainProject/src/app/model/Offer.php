<?php 

namespace app\model;

use db\Database;
use PDO;

require_once('src/db/Database.php');

class Offer
{
    private $id;
    private $author_id;
    private $offer_name;
    private $offer_description;
    private $offer_images;
    private $offer_price;
    private $offer_timestamp;

    private static $loadableCreate = ['author_id', 'offer_name', 'offer_description', 'offer_images', 'offer_price'];
    private static $loadableUpdate = ['offer_name', 'offer_description', 'offer_images', 'offer_price'];
    private $createErrors = [];
    private $updateErrors = [];
    
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
     * Get the value of author_id
     */ 
    public function getAuthor_id()
    {
        return $this->author_id;
    }

    /**
     * Set the value of author_id
     *
     * @return  self
     */ 
    public function setAuthor_id($author_id)
    {
        $this->author_id = $author_id;

        return $this;
    }

    /**
     * Get the value of offer_name
     */ 
    public function getOffer_name()
    {
        return $this->offer_name;
    }

    /**
     * Set the value of offer_name
     *
     * @return  self
     */ 
    public function setOffer_name($offer_name)
    {
        $this->offer_name = $offer_name;

        return $this;
    }

    /**
     * Get the value of offer_description
     */ 
    public function getOffer_description()
    {
        return $this->offer_description;
    }

    /**
     * Set the value of offer_description
     *
     * @return  self
     */ 
    public function setOffer_description($offer_description)
    {
        $this->offer_description = $offer_description;

        return $this;
    }

    /**
     * Get the value of offer_images
     */ 
    public function getOffer_images()
    {
        return $this->offer_images;
    }

    /**
     * Set the value of offer_images
     *
     * @return  self
     */ 
    public function setOffer_images($offer_images)
    {
        $this->offer_images = $offer_images;

        return $this;
    }

    /**
     * Get the value of offer_price
     */ 
    public function getOffer_price()
    {
        return $this->offer_price;
    }

    /**
     * Set the value of offer_price
     *
     * @return  self
     */ 
    public function setOffer_price($offer_price)
    {
        $this->offer_price = $offer_price;

        return $this;
    }

    /**
     * Get the value of offer_timestamp
     */ 
    public function getOffer_timestamp()
    {
        return $this->offer_timestamp;
    }

    /**
     * Set the value of offer_timestamp
     *
     * @return  self
     */ 
    public function setOffer_timestamp($offer_timestamp)
    {
        $this->offer_timestamp = $offer_timestamp;

        return $this;
    }

    public function generate_img_name()
    {
        $numlength = 20;
        $array = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 
                'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 
                'u', 'v', 'w', 'x', 'y', 'z'];
        $img_name = "IMG_";
    
        for ($i = 0; $i < $numlength; $i++) { 
            $img_name .= $array[rand(0, count($array) - 1)];
        }
    
        return $img_name;
    }

    public static function findAll($order)
    {
        $conn = Database::getConnection();
        if (strtoupper($order) == "DESC")
        {
            $sql = "SELECT * FROM `offers` ORDER BY `offer_timestamp` DESC";
        }
        else if (strtoupper($order) == "ASC")
        {
            $sql = "SELECT * FROM `offers` ORDER BY `offer_timestamp` ASC";
        }
        $statement = $conn->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    public static function findAllByFilters($text, $city, $order)
    {
        $conn = Database::getConnection();
        if (strtoupper($order) == "DESC")
        {
            if ($city == "All")
            {
                $sql = "SELECT * FROM `offers` WHERE `offer_name` LIKE :text1
                OR `offer_description` LIKE :text2
                ORDER BY `offer_timestamp` DESC";
                $statement = $conn->prepare($sql);
                $statement->execute([
                    ':text1' => "%".$text."%",
                    ':text2' => "%".$text."%",
                ]);
                return $statement->fetchAll(PDO::FETCH_CLASS,self::class);              
            }
            else
            {
                $sql = "SELECT * FROM `offers` 
                WHERE `offer_city` = :city AND (`offer_name` LIKE :text1 OR `offer_description` LIKE :text2)
                ORDER BY `offer_timestamp` DESC"; 
                $statement = $conn->prepare($sql);
                $statement->execute([
                    ':city' => $city,
                    ':text1' => "%".$text."%",
                    ':text2' => "%".$text."%",
                ]);
                return $statement->fetchAll(PDO::FETCH_CLASS,self::class);               
            }
        }
        else if (strtoupper($order) == "ASC")
        {
            if ($city == "All")
            {
                $sql = "SELECT * FROM `offers` WHERE `offer_name` LIKE :text1
                OR `offer_description` LIKE :text2
                ORDER BY `offer_timestamp` ASC";
                $statement = $conn->prepare($sql);
                $statement->execute([
                    ':text1' => "%".$text."%",
                    ':text2' => "%".$text."%",
                ]);
                return $statement->fetchAll(PDO::FETCH_CLASS,self::class);              
            }
            else
            {
                $sql = "SELECT * FROM `offers` 
                WHERE `offer_city` = :city AND (`offer_name` LIKE :text1 OR `offer_description` LIKE :text2)
                ORDER BY `offer_timestamp` ASC";
                $statement = $conn->prepare($sql);
                $statement->execute([
                    ':city' => $city,
                    ':text1' => "%".$text."%",
                    ':text2' => "%".$text."%",
                ]);
                return $statement->fetchAll(PDO::FETCH_CLASS,self::class);               
            }
        }
        else if ($order == "priceDESC")
        {
            if ($city == "All")
            {
                $sql = "SELECT * FROM `offers` WHERE `offer_name` LIKE :text1
                OR `offer_description` LIKE :text2
                ORDER BY `offer_price` DESC";
                $statement = $conn->prepare($sql);
                $statement->execute([
                    ':text1' => "%".$text."%",
                    ':text2' => "%".$text."%",
                ]);
                return $statement->fetchAll(PDO::FETCH_CLASS,self::class);                    
            }
            else
            {
                $sql = "SELECT * FROM `offers` 
                WHERE `offer_city` = :city AND (`offer_name` LIKE :text1 OR `offer_description` LIKE :text2)
                ORDER BY `offer_price` DESC";
                $statement = $conn->prepare($sql);
                $statement->execute([
                    ':city' => $city,
                    ':text1' => "%".$text."%",
                    ':text2' => "%".$text."%",
                ]);
                return $statement->fetchAll(PDO::FETCH_CLASS,self::class);                      
            }
        }
        else if ($order == "priceASC")
        {
            if ($city == "All")
            {
                $sql = "SELECT * FROM `offers` WHERE `offer_name` LIKE :text1
                OR `offer_description` LIKE :text2
                ORDER BY `offer_price` ASC";
                $statement = $conn->prepare($sql);
                $statement->execute([
                    ':text1' => "%".$text."%",
                    ':text2' => "%".$text."%",
                ]);
                return $statement->fetchAll(PDO::FETCH_CLASS,self::class);                     
            }
            else
            {
                $sql = "SELECT * FROM `offers` 
                WHERE `offer_city` = :city AND (`offer_name` LIKE :text1 OR `offer_description` LIKE :text2)
                ORDER BY `offer_price` ASC";
                $statement = $conn->prepare($sql);
                $statement->execute([
                    ':city' => $city,
                    ':text1' => "%".$text."%",
                    ':text2' => "%".$text."%",
                ]);
                return $statement->fetchAll(PDO::FETCH_CLASS,self::class);                    
            }
        }
    }

    public static function findAllOrderByPrice($order)
    {
        $conn = Database::getConnection();
        if (strtoupper($order) == "DESC")
        {
            $sql = "SELECT * FROM `offers` ORDER BY `offer_price` DESC";
        }
        else if (strtoupper($order) == "ASC")
        {
            $sql = "SELECT * FROM `offers` ORDER BY `offer_price` ASC";
        }
        $statement = $conn->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    public static function findAllByAuthorId($author_id, $order)
    {
        $conn = Database::getConnection();
        if (strtoupper($order) == "DESC")
        {
            $sql = "SELECT * FROM `offers` WHERE `author_id` = :author_id ORDER BY `offer_timestamp` DESC";
        }
        else if (strtoupper($order) == "ASC")
        {
            $sql = "SELECT * FROM `offers` WHERE `author_id` = :author_id ORDER BY `offer_timestamp` ASC";
        }
        $statement = $conn->prepare($sql);
        $statement->execute([
            ':author_id' => $author_id
        ]);
        return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    public static function findOneById($id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `offers` WHERE `id` = :id";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ':id' => $id
        ]);
        return $statement->fetchObject(self::class);
    }

    public static function searchAllByText($text, $order)
    {
        $conn = Database::getConnection();
        if (strtoupper($order) == "DESC")
        {
            $sql = "SELECT * FROM `offers` WHERE `offer_name` LIKE :text1
            OR `offer_description` LIKE :text2
            ORDER BY `offer_timestamp` DESC";    
        }
        else if (strtoupper($order) == "ASC")
        {
            $sql = "SELECT * FROM `offers` WHERE `offer_name` LIKE :text1
            OR `offer_description` LIKE :text2
            ORDER BY `offer_timestamp` ASC";  
        }
        $statement = $conn->prepare($sql);
        $statement->execute([
            ':text1' => "%".$text."%",
            ':text2' => "%".$text."%",
        ]);
        return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    public function load($data)
    {
        foreach (self::$loadableCreate as $item) {
            if (array_key_exists($item, $data) && (!empty($data[$item]) || $data[$item] == "0")) {
                $this->$item = $data[$item];
            }
        }
    }

    public function loadUpdate($data)
    {
        foreach (self::$loadableUpdate as $item) {
            if (array_key_exists($item, $data) && (!empty($data[$item]) || $data[$item] == "0")) {
                $this->$item = $data[$item];
            }
        }
    }

    public function validateCreate()
    {
        $this->createErrors = [];

        if (empty($this->offer_name))
        {
            $this->createErrors = "Adja meg a címet/megnevezést!";
        }
        if (empty($this->offer_description))
        {
            $this->createErrors = "Adja meg a leírást!";
        }
        if (empty($this->offer_price))
        {
            $this->createErrors = "Adja meg az árat!";
        }
        if (empty($this->offer_images))
        {
            $this->offer_images = "";
        }

        return count($this->createErrors) == 0;
    }

    public function validateUpdate()
    {
        $this->updateErrors = [];

        if (empty($this->offer_name))
        {
            $this->updateErrors = "Adja meg a címet/megnevezést!";
        }
        if (empty($this->offer_description))
        {
            $this->updateErrors = "Adja meg a leírást!";
        }
        if (empty($this->offer_price))
        {
            $this->updateErrors = "Adja meg az árat!";
        }
        if (empty($this->offer_images))
        {
            $this->offer_images = "";
        }

        return count($this->updateErrors) == 0;
    }

    public function create()
    {
        if ($this->validateCreate())
        {
            $this->author_id = $_SESSION['user_id'];
            if ($_FILES['offer']['type']['offer_images'] == "image/jpeg" || $_FILES['offer']['type']['offer_images'] == "image/jpg" || $_FILES['offer']['type']['offer_images'] == "image/png")
            {
                $temp = explode(".", $_FILES['offer']['name']['offer_images']);
                $newfilename = $this->generate_img_name() . '.' . end($temp);
                move_uploaded_file($_FILES['offer']['tmp_name']['offer_images'], "C:/xampp/htdocs/mainProject/img/uploads/" . $newfilename);
                $this->offer_images = $newfilename;
            }

            $conn = Database::getConnection();
            $sql = "INSERT INTO `offers`
            (`author_id` ,`offer_name`, `offer_description`, `offer_images`, `offer_price`)
            VALUES (:author_id, :offer_name, :offer_description, :offer_images, :offer_price)";
            $statement = $conn->prepare($sql);
            $result = $statement->execute([
                ":author_id" => $this->author_id,
                ":offer_name" => $this->offer_name,
                ":offer_description" => $this->offer_description,
                ":offer_images" => $this->offer_images,
                ":offer_price" => $this->offer_price
            ]);
            if ($result)
            {
                return true;
            }
            else
            {
                $this->createErrors[] = "Nem sikerült a hírdetés létrehozása! Próbáld újra!";
            }
        }
        return false;
    }

    public function update()
    {
        if ($this->validateUpdate())
        {
            if ($_FILES['offer']['type']['offer_images'] == "image/jpeg" || $_FILES['offer']['type']['offer_images'] == "image/jpg" || $_FILES['offer']['type']['offer_images'] == "image/png")
            {
                $temp = explode(".", $_FILES['offer']['name']['offer_images']);
                $newfilename = $this->generate_img_name() . '.' . end($temp);
                move_uploaded_file($_FILES['offer']['tmp_name']['offer_images'], "C:/xampp/htdocs/mainProject/img/uploads/" . $newfilename);
                $this->offer_images = $newfilename;
            }

            $conn = Database::getConnection();
            $sql = "UPDATE `offers`
            SET `offer_name` = :offer_name, `offer_description` = :offer_description, `offer_images` = :offer_images, `offer_price` = :offer_price
            WHERE `id` = :id";
            $statement = $conn->prepare($sql);
            $result = $statement->execute([
                ":id" => $this->id,
                ":offer_name" => $this->offer_name,
                ":offer_description" => $this->offer_description,
                ":offer_images" => $this->offer_images,
                ":offer_price" => $this->offer_price
            ]);
            if ($result)
            {
                return true;
            }
            else
            {
                $this->updateErrors[] = "Nem sikerült a hírdetés szerkesztése! Próbáld újra!";
            }
        }
        return false;
    }

    public function delete()
    {
        $conn = Database::getConnection();
        $sql = "DELETE FROM `offers`
        WHERE `id` = :id";
        $statement = $conn->prepare($sql);
        $result = $statement->execute([
            ":id" => $this->id
        ]);
        if ($result)
        {
            return true;
        }
        else
        {
            $this->updateErrors[] = "Nem sikerült a hírdetés törlése! Próbáld újra!";
        }
    }

}