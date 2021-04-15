<?php
namespace app\controller;


class CommonController {

    public $title = "";
    protected $controllerName = null;

    protected function render($view,$data = []){
        extract($data);
        ob_start();
        include("src/app/view/{$this->controllerName}/{$view}.php");
        return ob_get_clean();
    }

    public function getTitle()
    {
        return $this->title;
    }

}