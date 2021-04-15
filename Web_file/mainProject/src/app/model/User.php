<?php

namespace app\model;

use db\Database;
use PDO;

class User
{
    private $id;
    private $user_id;
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $passwordConfirm;
    private $password_hash;
    private $date_of_birth;
    private $county;
    private $city;
    private $role;
    private $phone;
    private $phone_visible;
    private $about;

    private $registerErrors = [];
    private $loginErrors = [];
    private $updateErrors = [];

    private static $loadable = ['first_name', 'last_name', 'email', 'password', 'passwordConfirm', 'date_of_birth', 'county', 'city', 'role'];
    private static $updateable = ['first_name', 'last_name', 'date_of_birth', 'county', 'city', 'role', 'phone', 'phone_visible', 'about'];

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
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of first_name
     */ 
    public function getFirst_name()
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     *
     * @return  self
     */ 
    public function setFirst_name($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of last_name
     */ 
    public function getLast_name()
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */ 
    public function setLast_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of date_of_birth
     */ 
    public function getDate_of_birth()
    {
        return $this->date_of_birth;
    }

    /**
     * Set the value of date_of_birth
     *
     * @return  self
     */ 
    public function setDate_of_birth($date_of_birth)
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    /**
     * Get the value of county
     */ 
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set the value of county
     *
     * @return  self
     */ 
    public function setCounty($county)
    {
        $this->county = $county;

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
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }
    
    /**
     * Get the value of phone_visible
     */ 
    public function getPhone_visible()
    {
        return $this->phone_visible;
    }

    /**
     * Set the value of phone_visible
     *
     * @return  self
     */ 
    public function setPhone_visible($phone_visible)
    {
        $this->phone_visible = $phone_visible;

        return $this;
    }
    
    /**
     * Get the value of about
     */ 
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set the value of about
     *
     * @return  self
     */ 
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    function generate_user_id() {
        $numlength = 16;
        $user_id = "";
    
        for ($i=0; $i < $numlength; $i++) { 
            $user_id .= rand(0, 9);
        }
    
        return $user_id;
    }

    public static function findOneByEmail($email)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM users WHERE `email` = :email";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ":email" => $email
        ]);
        return $statement->fetchObject(self::class);
    }

    public static function findOneByUserId($user_id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM users WHERE `user_id` = :user_id";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ":user_id" => $user_id
        ]);
        return $statement->fetchObject(self::class);
    }

    public static function findOneById($id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM users WHERE `id` = :id LIMIT 1";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ":id" => $id
        ]);
        return $statement->fetchObject(self::class);
    }

    public static function emailValidation($emailToValidate)
    {
        $conn = Database::getConnection();
        $sql = "SELECT `email` FROM users";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $emails[] = $statement->fetchAll(PDO::FETCH_COLUMN);
        foreach($emails[0] as $email)
        {
            if ($email == $emailToValidate)
            {
                return true;
            }
        }
        return false;
    }

    public function getLoginErrors()
    {
        return $this->loginErrors;
    }

    public function load($data)
    {
        foreach (self::$loadable as $item) {
            if (array_key_exists($item, $data) && (!empty($data[$item]) || $data[$item] == "0")) {
                $this->$item = $data[$item];
            }
        }
    }

    public function loadUpdate($data)
    {
        foreach (self::$updateable as $item) {
            if (array_key_exists($item, $data) && (!empty($data[$item]) || $data[$item] == "0")) {
                $this->$item = $data[$item];
            }
        }
    }

    public function validate()
    {
        $this->registerErrors = [];

        if(empty($this->first_name))
        {
            $this->registerErrors[] = "Adja meg a keresztnevét!";
        }
        if(empty($this->last_name))
        {
            $this->registerErrors[] = "Adja meg a vezetéknevét!";
        }
        if(empty($this->email))
        {
            $this->registerErrors[] = "Adja meg az e-mail címét!";
        }
        if ($this->emailValidation($this->email)) 
        {
            $this->registerErrors[] = "Az e-mail cím már szerepel az adatbázisban!";
        }
        if(empty($this->password) || strlen($this->password) < 8)
        {
            $this->registerErrors[] = "A jelszónak minimum 8 karakter hosszúnak kell lennie!";
        }
        if($_POST['user']['passwordConfirm'] != $this->password)
        {
            $this->registerErrors[] = "A megadott jelszóknak egyezniük kell!";
        }
        if (empty($this->date_of_birth)) 
        {
            $this->date_of_birth = null;
        }
        if (empty($this->county)) 
        {
            $this->county = null;
        }
        if (empty($this->city)) 
        {
            $this->city = null;
        }
        if (empty($this->role))
        {
            $this->registerErrors[] = "Válassz szerepet!";
        }

        return count($this->registerErrors) == 0;
    }

    public function validateUpdate() 
    {
        $this->updateErrors = [];

        if(empty($this->first_name))
        {
            $this->updateErrors[] = "Adja meg a keresztnevét!";
        }
        if(empty($this->last_name))
        {
            $this->updateErrors[] = "Adja meg a vezetéknevét!";
        }
        if(empty($this->email))
        {
            $this->updateErrors[] = "Adja meg az e-mail címét!";
        }
        if (empty($this->date_of_birth)) 
        {
            $this->date_of_birth = null;
        }
        if (empty($this->county)) 
        {
            $this->county = null;
        }
        if (empty($this->city)) 
        {
            $this->city = null;
        }
        if (empty($this->role)) 
        {
            $this->updateErrors = "Válassz szerepet!";
        }
        if (empty($this->phone)) 
        {
            $this->phone = null;
        }
        if (empty($this->phone_visible))
        {
            $this->phone_visible = false;
        }
        if ($this->phone_visible == "on")
        {
            $this->phone_visible = true;
        }
        if (empty($this->about)) 
        {
            $this->about = null;
        }

        return count($this->updateErrors) == 0;
    }

    public function register()
    {
        if ($this->validate())
        {
            $conn = Database::getConnection();
            $sql = "INSERT INTO `users`
            (`user_id` ,`first_name`, `last_name`, `email`, `password_hash`, `date_of_birth`, `county`, `city`, `role`)
            VALUES (:user_id, :first_name, :last_name, :email, :password_hash, :date_of_birth, :county, :city, :role)";
            $statement = $conn->prepare($sql);
            $result = $statement->execute([
                ":user_id" => $this->generate_user_id(),
                ":first_name" => ucfirst($this->first_name),
                ":last_name" => ucfirst($this->last_name),
                ":email" => $this->email,
                ":password_hash" => password_hash($this->password, PASSWORD_DEFAULT),
                ":date_of_birth" => $this->date_of_birth,
                ":county" => $this->county,
                ":city" => $this->city,
                ":role" => $this->role
            ]);
            if ($result)
            {
                return true;
            }
            else
            {
                $this->registerErrors[] = "Sikertelen validálás!";
            }
        }
        return false;
    }

    public function login($password)
    {
        if (password_verify($password, $this->password_hash))
        {
            $_SESSION['user_id'] = $this->user_id;
            return true;
        }
        return false;
    }

    public function update()
    {
        if ($this->validateUpdate())
        {
            $conn = Database::getConnection();
            $sql = "UPDATE `users`
            SET `first_name` = :first_name, `last_name` = :last_name, `email` = :email,
             `date_of_birth` = :date_of_birth, `county` = :county, `city` = :city,
             `role` = :role, `phone` = :phone, `phone_visible` = :phone_visible, `about` = :about
            WHERE `id` = :id";
            $statement = $conn->prepare($sql);
            $result = $statement->execute([
                ":id" => $this->id,
                ":first_name" => $this->first_name,
                ":last_name" => $this->last_name,
                ":email" => $this->email,
                ":date_of_birth" => $this->date_of_birth,
                ":county" => $this->county,
                ":city" => $this->city,
                ":role" => $this->role,
                ":phone" => $this->phone,
                ":phone_visible" => $this->phone_visible,
                ":about" => $this->about
            ]);
            if ($result)
            {
                return true;
            }
            else
            {
                $this->postErrors[] = "Nem sikerült a profilod frissítése! Próbáld újra!";
            }
        }
        return false;
    }

    public function delete()
    {
        $conn = Database::getConnection();
        $sql = "DELETE FROM `users`
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
            $this->postErrors[] = "Nem sikerült a profilod törlése! Próbáld újra!";
        }
    }

}