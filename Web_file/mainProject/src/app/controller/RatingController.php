<?php

namespace app\controller;

require_once('src/app/model/User.php');
require_once('src/app/model/Post.php');
require_once('src/app/model/Rating.php');
use app\model\User;
use app\model\Post;
use app\model\Rating;

class RatingController extends CommonController
{
    protected $controllerName = 'rating';

    public function actionCreate($id)
    {
        $this->title = "Értékelés létrehozása";
        $post = Post::findOneById($id);

        if (isset($_POST['rating']['value']) && isset($_SESSION['user_id']))
        {
            $rating = new Rating();
            $rating->setPost_id($id);
            $rating->load($post->getHelper_id(), $_POST['rating']['value']);
            if ($rating->create()){
                header("Location: index.php?controller=post&action=view&id=" . $id . "rating=success");
                exit();
            }
        }
    }
}