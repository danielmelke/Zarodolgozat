<?php 

namespace app\model;

use db\Database;
use PDO;

require_once('src/db/Database.php');

class Rating
{
    private $id;
    private $post_id;
    private $from_user;
    private $to_user;
    private $rating_value;

    private $createErrors = [];

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
     * Get the value of post_id
     */ 
    public function getPost_id()
    {
        return $this->post_id;
    }

    /**
     * Set the value of post_id
     *
     * @return  self
     */ 
    public function setPost_id($post_id)
    {
        $this->post_id = $post_id;

        return $this;
    }

    /**
     * Get the value of from_user
     */ 
    public function getFrom_user()
    {
        return $this->from_user;
    }

    /**
     * Set the value of from_user
     *
     * @return  self
     */ 
    public function setFrom_user($from_user)
    {
        $this->from_user = $from_user;

        return $this;
    }

    /**
     * Get the value of to_user
     */ 
    public function getTo_user()
    {
        return $this->to_user;
    }

    /**
     * Set the value of to_user
     *
     * @return  self
     */ 
    public function setTo_user($to_user)
    {
        $this->to_user = $to_user;

        return $this;
    }

    /**
     * Get the value of rating_value
     */ 
    public function getRating_value()
    {
        return $this->rating_value;
    }

    /**
     * Set the value of rating_value
     *
     * @return  self
     */ 
    public function setRating_value($rating_value)
    {
        $this->rating_value = $rating_value;

        return $this;
    }

    public static function findAllGivenTo($to_user)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `ratings` WHERE `to_user` = :to_user";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ":to_user" => $to_user
        ]);
        return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function findOneByPostId($post_id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `ratings` WHERE `post_id` = :post_id";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ":post_id" => $post_id
        ]);
        return $statement->fetchObject(self::class);
    }

    public function load($_to_user, $_value)
    {
        $this->to_user = $_to_user;
        $this->rating_value = $_value;
    }

    public function validate()
    {
        $this->createErrors = [];
        
        if (empty($this->to_user))
        {
            $this->createErrors = "Valami hiba történt!";
        }
        if (empty($this->rating_value))
        {
            $this->createErrors = "Adja meg az értéket!";
        }

        return count($this->createErrors) == 0;
    }

    public function create()
    {
        if ($this->validate())
        {
            $this->from_user = $_SESSION['user_id'];
            $conn = Database::getConnection();
            $sql = "INSERT INTO `ratings`
            (`post_id`, `from_user` ,`to_user`, `rating_value`)
            VALUES (:post_id, :from_user, :to_user, :rating_value)";
            $statement = $conn->prepare($sql);
            $result = $statement->execute([
                ":post_id" => $this->post_id,
                ":from_user" => $this->from_user,
                ":to_user" => $this->to_user,
                ":rating_value" => $this->rating_value
            ]);
            if ($result)
            {
                return true;
            }
            else
            {
                $this->postErrors[] = "Nem sikerült az értékelés létrehozása! Próbáld újra!";
            }
        }
        return false;
    }
}