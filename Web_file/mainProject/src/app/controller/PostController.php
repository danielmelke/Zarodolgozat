<?php

namespace app\controller;

require_once('src/app/model/User.php');
require_once('src/app/model/Post.php');
require_once('src/app/model/Cart.php');
require_once('src/app/model/Product.php');
require_once('src/app/model/ShopPost.php');
use app\model\Post;
use app\model\User;
use app\model\Cart;
use app\model\Product;
use app\model\ShopPost;


class PostController extends CommonController{
    
    protected $controllerName = 'post';

    public function actionIndex()
    {
        if (isset($_GET['order']))
        {
            $posts = Post::findAll($_GET['order']);
        }
        else
        {
            $posts = Post::findAll("DESC");
        }

        $this->title = "Posztok";
        
        return $this->render('index', [
            "posts" => $posts
        ]);
    }

    public function actionView($id)
    {
        $post = Post::findOneById($id);

        $this->title = "Poszt megtekintése";

        return $this->render('view', [
            "post" => $post
        ]);
    }

    public function actionCreate()
    {
        $this->title = 'Új poszt létrehozása';

        $post = new Post();
        $user = User::findOneByUserId($_SESSION['user_id']);
        $cart_id = "";
        
        if (isset($_POST['post']) && isset($_SESSION['user_id'])) {
            if ($_POST['post']['category'] == "shopping")
            {
                $shopPost = new ShopPost();
                $shopPost->create($user->getUser_id());
                $cart_id = $shopPost->getCart_id();
                $rows = $_POST['row'];
                foreach($rows as $row)
                {
                    $cart = new Cart();
                    $cart->setId($shopPost->getCart_id());
                    $cart->setProduct_id($row['product_name']);
                    $cart->setAmount($row['cart_amount']);
                    $cart->setMeasure($row['cart_measure']);
                    $cart->setContent($row['cart_content']);
                    $cart->create();
                }
            }
            $post->load($_POST['post'], $user, $cart_id);
            if ($post->create()) {
                header("Location: index.php?controller=post&action=index&create=success");
                exit();
            }
            header("Location: index.php?controller=post&action=create&create=error");
            exit();
        }

        return $this->render('create', [
            'post' => $post
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Post::findOneById($id);
        $user = User::findOneByUserId($post->getAuthor_id());

        $this->title = "Poszt szerkesztés";

        if (isset($_POST['post'])) 
        {
            $post->load($_POST['post'], $user);
            if ($post->update()) 
            {
                header("Location: index.php?controller=post&action=index&update=success");
                exit();
            }
            else
            {
                header("Location: index.php?controller=post&action=index&update=error");
                exit();
            }
        }

        return $this->render("update", [
            "post" => $post
        ]);
    }

    public function actionDelete($id)
    {
        $post = Post::findOneById($id);

        if ($post->getAuthor_id() == $_SESSION['user_id']) 
        {
            if ($post->delete()) {
                header("Location: index.php?controller=post&action=index&delete=success");
                exit();
            } else {
                header("Location: index.php?controller=post&action=index&delete=error");
                exit();
            }
        }
    }

    public function actionHelper($id)
    {
        $post = Post::findOneById($id);
        $post->setHelper_id($_SESSION['user_id']);

        if ($post->setHelper())
        {
            header("Location: index.php?controller=post&action=view&id=" . $post->getId() . "&helper=success");
            exit();
        }
        else
        {
            header("Location: index.php?controller=post&action=view&id=" . $post->getId() . "&helper=error");
            exit();
        }

        return $this->render("view", [
            "post" => $post
        ]);
    }

    public function actionEnd($id)
    {
        $post = Post::findOneById($id);

        if ($post->endStatus())
        {
            header("Location: index.php?controller=post&action=view&id=" . $post->getId() . "&end=success");
            exit();
        }
        else
        {
            header("Location: index.php?controller=post&action=view&id=" . $post->getId() . "&end=error");
            exit();
        }
    }
}