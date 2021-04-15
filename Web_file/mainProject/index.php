<?php
use app\model\User;
use app\model\Post;
use app\model\Offer;
use app\model\Rating;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

require("vendor/autoload.php");
require_once("src/app/controller/UserController.php");
require_once("src/app/controller/PostController.php");
require_once("src/app/controller/OfferController.php");
require_once("src/app/controller/ProductController.php");
require_once("src/app/controller/RatingController.php");
require_once("src/app/controller/SiteController.php");

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

session_start();

$controllerName = !empty($_GET['controller'])?ucfirst($_GET['controller']) . "Controller":"UserController";
$actionName = !empty($_GET['action'])?"action".ucfirst($_GET['action']):"actionIndex";
// var_dump($controllerName);
// var_dump($actionName);

$content = "";

if($controllerName == "UserController")
{
    $controller = new app\controller\UserController;
    if($actionName == "actionIndex")
    {
        $content = $controller->actionIndex();
        $title = "Főoldal";
    }
    else if($actionName == "actionLogin")
    {
        $content = $controller->actionLogin();
        $title = "Bejelentkezés";
    }
    else if($actionName == "actionRegister")
    {
        $content = $controller->actionRegister();
        $title = "Regisztráció";
    }
    else if($actionName == "actionUpdate")
    {
        $content = $controller->actionUpdate($_GET['id']);
        $title = "Profil";
    }
    else if($actionName == "actionLogout")
    {
        $content = $controller->actionLogout();
    }
    else if($actionName == "actionProfile")
    {
        $title = "Profil";
        if (!empty($_SESSION['user_id'])) 
        {
            $content = $controller->actionProfile($_SESSION['user_id']);
        }
        else
        {
            $content = '<div class="alert alert-warning text-center">Az oldal eléréséhez be kell jelentkezned!</div>';
        }
    }
    else if($actionName == "actionPosts")
    {
        $title = "Saját posztok";
        $content = $controller->actionPosts($_GET['order']);
    }
    else if($actionName == "actionOffers")
    {
        $title = "Saját hírdetések";
        $content = $controller->actionOffers($_GET['order']);
    }
    else if($actionName == "actionDelete")
    {
        $title = "Profil törlése";
        $content = $controller->actionDelete($_GET['id']);
    }
}

if($controllerName == "PostController")
{
    $controller = new \app\controller\PostController();
    if($actionName == "actionIndex")
    {
        $content = $controller->actionIndex();
        $title = "Posztok";
    }
    else if($actionName == "actionCreate")
    {
        $content = $controller->actionCreate();
        $title = "Új poszt létrehozása";
    }
    else if($actionName == "actionUpdate")
    {
        $content = $controller->actionUpdate($_GET['id']);
        $title = "Poszt szerkesztése";
    }
    else if($actionName == "actionDelete")
    {
        $content = $controller->actionDelete($_GET['id']);
        $title = "Poszt törlése";
    }
    else if($actionName == "actionView")
    {
        $content = $controller->actionView($_GET['id']);
        $title = "Poszt megtekintése";
    }
    else if($actionName == "actionHelper")
    {
        $content = $controller->actionHelper($_GET['id']);
        $title = "Poszt megtekintése";
    }
    else if($actionName == "actionEnd")
    {
        $content = $controller->actionEnd($_GET['id']);
        $title = "Poszt megtekintése";
    }
}

if ($controllerName == "OfferController")
{
    $controller = new \app\controller\OfferController();
    if($actionName == "actionIndex")
    {
        $content = $controller->actionIndex();
        $title = "Keres-kínál hírdetések";
    }
    else if($actionName == "actionCreate")
    {
        $content = $controller->actionCreate();
        $title = "Új hírdetés létrehozása";
    }
    else if($actionName == "actionUpdate")
    {
        $content = $controller->actionUpdate($_GET['id']);
        $title = "Hírdetés szerkesztése";
    }
    else if($actionName == "actionDelete")
    {
        $content = $controller->actionDelete($_GET['id']);
        $title = "Hírdetés törlése";
    }
    else if($actionName == "actionView")
    {
        $content = $controller->actionView($_GET['id']);
        $title = "Hírdetés megtekintése";
    }
}

if ($controllerName == "ProductController")
{
    $controller = new \app\controller\ProductController();
    if($actionName == "actionCreate")
    {
        $content = $controller->actionCreate();
        $title = "Új elem hozzáadása";
    }
}

if ($controllerName == "RatingController")
{
    $controller = new \app\controller\RatingController();
    if($actionName == "actionCreate")
    {
        $content = $controller->actionCreate($_GET['post_id']);
        $title = "Új értékelés létrehozása";
    }
}

if ($controllerName == "SiteController")
{
    $controller = new \app\controller\SiteController();
    if ($actionName == "actionAbout")
    {
        $content = $controller->actionAbout();
        $title = "Az oldalról";
    }
}


include("src/app/view/templates/main-template.php");

?>