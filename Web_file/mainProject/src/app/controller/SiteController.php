<?php


namespace app\controller;


class SiteController extends CommonController
{
    protected $controllerName = "site";

    public function actionIndex()
    {
        $this->title = 'Főoldal';

        return $this->render('index');
    }

    protected function render($view, $data = [])
    {
        ob_start();
        include("src/helper/{$view}.php");
        return ob_get_clean();
    }

    public function actionAbout()
    {
        $this->title = "Az oldalról";

        return $this->render("about");
    }
}