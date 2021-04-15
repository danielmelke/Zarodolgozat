<?php

namespace app\controller;

use app\model\User;

require_once('CommonController.php');
require_once('src/app/model/User.php');

class UserController extends CommonController{

    protected $controllerName = 'user';

    public function actionIndex()
    {
        $title = "Főoldal";
        
        return $this->render("index");
    }

    public function actionLogin()
    {
        $user = new User();
        if(!empty($_POST['email']) && !empty($_POST['password']))
        {
            $user = User::findOneByEmail($_POST['email']);
            if($user->login($_POST['password']))
            {
                header("Location: index.php?controller=user&action=index&login=success");
                exit();
            }
            header("Location: index.php?controller=user&action=login&login=error");
            exit();
        }

        $this->title = "Bejelentkezés";
        return $this->render("login", [
            "user" => $user
        ]);
    }

    public function actionLogout()
    {
        $_SESSION['user_id'] = '';
        unset($_SESSION['user_id']);
        header("Location: index.php?controller=user&action=index");
        exit();
    }

    public function actionRegister()
    {
        $title = "Regisztráció";

        $user = new User();

        if (isset($_POST['user'])) {
            $user->load($_POST['user']);
            if ($user->register()) {
                header("Location: index.php?controller=user&action=login&register=success");
                exit();
            }
            else{
                header("Location: index.php?controller=user&action=register&register=error");
                exit();
            }
        }

        return $this->render("register", [
            "user" => $user
        ]);
    }

    public function actionProfile($user_id)
    {
        $title = "Profil";

        if (isset($_SESSION['user_id']))
        {
            if ($user_id == $_SESSION['user_id']) 
            {
                $profile = User::findOneByUserId($_SESSION['user_id']);
            }
            else
            {
                $profile = User::findOneByUserId($user_id);
            } 
        }

        return $this->render("profile", [
            "user" => $profile
        ]);
    }

    public function actionPosts($order)
    {
        $title = "Saját posztok";

        $user = User::findOneByUserId($_SESSION['user_id']);

        return $this->render("posts", [
            "user" => $user
        ]);
    }

    public function actionOffers($order)
    {
        $title = "Saját hírdetések";

        $user = User::findOneByUserId($_SESSION['user_id']);

        return $this->render("offers", [
            "user" => $user
        ]);
    }

    public function actionUpdate($id)
    {
        $title = "Profil";

        $user = User::findOneById($id);
        
        if (isset($_POST['user'])) {
            $user->loadUpdate($_POST['user']);
            if ($user->update()) {
                header("Location: index.php?controller=user&action=profile&id=" . $user->getId() . "&update=success");
                exit();
            }
        }

        return $this->render("profile", [
            "user" => $user
        ]);
    }

    public function actionDelete($id)
    {
        $title = "Profil törlése";

        $user = User::findOneById($id);

        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user->getUser_id())
        {
            if ($user->delete())
            {
                $_SESSION['user_id'] = '';
                unset($_SESSION['user_id']);    
                header("Location: index.php?controller=user&action=index");
                exit;
            }
        }
    }
}