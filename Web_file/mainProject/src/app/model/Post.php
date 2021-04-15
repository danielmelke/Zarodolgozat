<?php 

namespace app\model;

use db\Database;
use PDO;

require_once('src/db/Database.php');

class Post
{
    private $id;
    private $author_id;
    private $subject;
    private $timestamp;
    private $post_content;
    private $city;
    private $category;
    private $role;
    private $status;
    private $cart_id;
    private $helper_id;

    private $postErrors = [];

    /**
     * @return id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return author_id
     */
    public function getAuthor_id()
    {
        return $this->author_id;
    }

    /**
     * @param author_id
     * @return self
     */
    public function setAuthor_id($author_id)
    {
        $this->author_id = $author_id;
        return $this;
    }

    /**
     * @return subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param subject
     * @return self
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return timestamp
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param timestamp
     * @return self
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return post_content
     */
    public function getPost_content()
    {
        return $this->post_content;
    }

    /**
     * @param post_content
     * @return self
     */
    public function setPost_content($post_content)
    {
        $this->post_content = $post_content;
        return $this;
    }
    
    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        if ($this->category == "shopping")
        {
            return "Vásárlás";
        }
        else
        {
            return "Egyéb";
        }
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
    
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
     * Get the value of helper_id
     */ 
    public function getHelper_id()
    {
        return $this->helper_id;
    }

    /**
     * Set the value of helper_id
     *
     * @return  self
     */ 
    public function setHelper_id($helper_id)
    {
        $this->helper_id = $helper_id;

        return $this;
    }
    
    public static function findAll($order)
    {
        $conn = Database::getConnection();
        if (strtoupper($order) == "DESC")
        {
            $sql = "SELECT * FROM user_posts ORDER BY timestamp DESC";
        }
        else if (strtoupper($order) == "ASC")
        {
            $sql = "SELECT * FROM user_posts ORDER BY timestamp ASC";
        }
        $statement = $conn->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    public static function findAllByFilters($text, $city, $order, $category, $role)
    {
        $conn = Database::getConnection();
        if (strtoupper($order) == "DESC")
        {
            if ($city == "All")
            {
                if ($role == "both")
                {
                    $sql = "SELECT * FROM `user_posts` 
                    WHERE `category` = :category AND (`subject` LIKE :text1 OR `post_content` LIKE :text2)
                    ORDER BY timestamp DESC";
                    $statement = $conn->prepare($sql);
                    $statement->execute([
                        ':category' => $category,
                        ':text1' => "%".$text."%",
                        ':text2' => "%".$text."%"
                    ]);
                    return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
                }
                else
                {
                    $sql = "SELECT * FROM `user_posts` 
                    WHERE `category` = :category AND `role` = :role AND (`subject` LIKE :text1 OR `post_content` LIKE :text2)
                    ORDER BY timestamp DESC";
                    $statement = $conn->prepare($sql);
                    $statement->execute([
                        ':category' => $category,
                        ':role' => $role,
                        ':text1' => "%".$text."%",
                        ':text2' => "%".$text."%"
                    ]);
                    return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
                }
            }
            else
            {
                if ($role == "both")
                {
                    $sql = "SELECT * FROM `user_posts` 
                    WHERE `category` = :category AND `city` = :city AND (`subject` LIKE :text1 OR `post_content` LIKE :text2)
                    ORDER BY timestamp DESC";
                    $statement = $conn->prepare($sql);
                    $statement->execute([
                        ':category' => $category,
                        ':city' => $city,
                        ':text1' => "%".$text."%",
                        ':text2' => "%".$text."%"
                    ]);
                    return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
                }
                else
                {
                    $sql = "SELECT * FROM `user_posts` 
                    WHERE `category` = :category AND `role` = :role AND `city` = :city AND (`subject` LIKE :text1 OR `post_content` LIKE :text2)
                    ORDER BY timestamp DESC";
                    $statement = $conn->prepare($sql);
                    $statement->execute([
                        ':category' => $category,
                        ':role' => $role,
                        ':city' => $city,
                        ':text1' => "%".$text."%",
                        ':text2' => "%".$text."%"
                    ]);
                    return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
                }
            }
        }
        else if (strtoupper($order) == "ASC")
        {
            if ($city == "All")
            {
                if ($role == "both")
                {
                    $sql = "SELECT * FROM `user_posts` 
                    WHERE `category` = :category AND (`subject` LIKE :text1 OR `post_content` LIKE :text2)
                    ORDER BY timestamp ASC";
                    $statement = $conn->prepare($sql);
                    $statement->execute([
                        ':category' => $category,
                        ':text1' => "%".$text."%",
                        ':text2' => "%".$text."%"
                    ]);
                    return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
                }
                else
                {
                    $sql = "SELECT * FROM `user_posts` 
                    WHERE `category` = :category AND `role` = :role AND (`subject` LIKE :text1 OR `post_content` LIKE :text2)
                    ORDER BY timestamp ASC";
                    $statement = $conn->prepare($sql);
                    $statement->execute([
                        ':category' => $category,
                        ':role' => $role,
                        ':text1' => "%".$text."%",
                        ':text2' => "%".$text."%"
                    ]);
                    return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
                }
            }
            else
            {
                if ($role == "both")
                {
                    $sql = "SELECT * FROM `user_posts` 
                    WHERE `category` = :category AND `city` = :city AND (`subject` LIKE :text1 OR `post_content` LIKE :text2)
                    ORDER BY timestamp ASC";
                    $statement = $conn->prepare($sql);
                    $statement->execute([
                        ':category' => $category,
                        ':city' => $city,
                        ':text1' => "%".$text."%",
                        ':text2' => "%".$text."%"
                    ]);
                    return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
                }
                else
                {
                    $sql = "SELECT * FROM `user_posts` 
                    WHERE `category` = :category AND `role` = :role AND `city` = :city AND (`subject` LIKE :text1 OR `post_content` LIKE :text2)
                    ORDER BY timestamp ASC";
                    $statement = $conn->prepare($sql);
                    $statement->execute([
                        ':category' => $category,
                        ':role' => $role,
                        ':city' => $city,
                        ':text1' => "%".$text."%",
                        ':text2' => "%".$text."%"
                    ]);
                    return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
                }
            }
        }
    }

    public static function findAllByAuthorId($author_id, $order)
    {
        $conn = Database::getConnection();
        if (strtoupper($order) == "DESC")
        {
            $sql = "SELECT * FROM `user_posts` WHERE `author_id` = :author_id ORDER BY timestamp DESC";
        }
        else if (strtoupper($order) == "ASC")
        {
            $sql = "SELECT * FROM `user_posts` WHERE `author_id` = :author_id ORDER BY timestamp ASC";
        }
        $statement = $conn->prepare($sql);
        $statement->execute([
            ':author_id' => $author_id
        ]);
        return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    public static function findAllByAuthorIdAndFilter($author_id, $order, $text, $category)
    {
        $conn = Database::getConnection();
        if (strtoupper($order) == "DESC")
        {
            $sql = "SELECT * FROM `user_posts` 
            WHERE `author_id` = :author_id AND `category` = :category AND (`subject` LIKE :text1 OR `post_content` LIKE :text2) 
            ORDER BY timestamp DESC";
        }
        else if (strtoupper($order) == "ASC")
        {
            $sql = "SELECT * FROM `user_posts` 
            WHERE `author_id` = :author_id AND `category` = :category AND (`subject` LIKE :text1 OR `post_content` LIKE :text2) 
            ORDER BY timestamp ASC";
        }
        $statement = $conn->prepare($sql);
        $statement->execute([
            ':author_id' => $author_id,
            ':category' => $category,
            ':text1' => "%".$text."%",
            ':text2' => "%".$text."%"
        ]);
        return $statement->fetchAll(PDO::FETCH_CLASS,self::class);

    }

    public static function findOneById($id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `user_posts` WHERE `id` = :id";
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
            $sql = "SELECT * FROM `user_posts` WHERE `subject` LIKE :text1
            OR `post_content` LIKE :text2
            ORDER BY `timestamp` DESC";    
        }
        else if (strtoupper($order) == "ASC")
        {
            $sql = "SELECT * FROM `user_posts` WHERE `subject` LIKE :text1
            OR `post_content` LIKE :text2
            ORDER BY `timestamp` ASC";  
        }
        $statement = $conn->prepare($sql);
        $statement->execute([
            ':text1' => "%".$text."%",
            ':text2' => "%".$text."%"
        ]);
        return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    public function load($data, $user, $cart_id) 
    {
        $this->subject = $data['subject'];
        $this->post_content = $data['post_content'];
        $this->city = $user->getCity();
        $this->category = $data['category'];
        $this->role = $data['role'];
        $this->status = "Aktív";
        $this->cart_id = $cart_id;
    }

    public function validate()
    {
        $this->postErrors = [];

        if(empty($this->subject))
        {
            $this->postErrors[] = "Adja meg a témát/címet!";
        }
        if(empty($this->post_content))
        {
            $this->postErrors[] = "Nem lehet üres a poszt!";
        }
        if(empty($this->category))
        {
            $this->postErrors[] = "Nem lehet üres a kategória!";
        }
        if(empty($this->role))
        {
            $this->postErrors[] = "Nem lehet üres a szerep!";
        }
        return count($this->postErrors) == 0;
    }


    public function create()
    {
        if ($this->validate())
        {
            $this->author_id = $_SESSION['user_id'];
            $conn = Database::getConnection();
            $sql = "INSERT INTO `user_posts`
            (`author_id` ,`subject`, `post_content`, `city`, `category`, `role`, `status`, `cart_id`)
            VALUES (:author_id, :subject, :post_content, :city, :category, :role, :status, :cart_id)";
            $statement = $conn->prepare($sql);
            $result = $statement->execute([
                ":author_id" => $this->author_id,
                ":subject" => $this->subject,
                ":post_content" => $this->post_content,
                ":city" => $this->city,
                ":category" => $this->category,
                ":role" => $this->role,
                ":status" => $this->status,
                ":cart_id" => $this->cart_id
            ]);
            if ($result)
            {
                return true;
            }
            else
            {
                $this->postErrors[] = "Nem sikerült a poszt létrehozása! Próbáld újra!";
            }
        }
        return false;
    }

    public function update()
    {
        if ($this->validate())
        {
            $conn = Database::getConnection();
            $sql = "UPDATE `user_posts`
            SET `subject` = :subject, `post_content` = :post_content
            WHERE `id` = :id";
            $statement = $conn->prepare($sql);
            $result = $statement->execute([
                ":id" => $this->id,
                ":subject" => $this->subject,
                ":post_content" => $this->post_content
            ]);
            if ($result)
            {
                return true;
            }
            else
            {
                $this->postErrors[] = "Nem sikerült a poszt szerkesztése! Próbáld újra!";
            }
        }
        return false;
    }

    public function delete()
    {
        $conn = Database::getConnection();
        $sql = "DELETE FROM `user_posts`
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
            $this->postErrors[] = "Nem sikerült a poszt törlése! Próbáld újra!";
        }
    }

    public function setHelper()
    {
        $conn = Database::getConnection();
        $sql = "UPDATE `user_posts`
        SET `status` = 'Folyamatban', `helper_id` = :helper_id
        WHERE `id` = :id";
        $statement = $conn->prepare($sql);
        $result = $statement->execute([
            ":id" => $this->id,
            ":helper_id" => $this->helper_id
        ]);
        if ($result)
        {
            return true;
        }
        else
        {
            $this->postErrors[] = "Nem sikerült elfogadni! Próbáld újra!";
        }
    }

    public function endStatus()
    {
        $conn = Database::getConnection();
        $sql = "UPDATE `user_posts`
        SET `status` = 'Befejezett'
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
            $this->postErrors[] = "Nem sikerült elfogadni! Próbáld újra!";
        }
    }
}