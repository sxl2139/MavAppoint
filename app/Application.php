<?php

class Application
{
    static $container = [];

    public function __construct($config = [])
    {
        self::$container["config"] = $config;
    }

    public function run()
    {
        //prerequisite, middleware
        $this->addRoute();
        $this->dispatch();
    }

    private function addRoute(){
        self::$container["route"] = require("routes.php");
    }

    private function dispatch() {
        require (__DIR__ . "../misc/helpers.php");
        $c = isset($_REQUEST['c']) ? mav_decrypt($_REQUEST['c']) : "index"; //Default Login
        $a = isset($_REQUEST['a']) ? mav_decrypt($_REQUEST['a']) : "default"; //Use defaultAction() as default
//print_r($c . " || " . $a);die();
        if(isset(self::$container["route"][$c]) && isset(self::$container["route"][$c][$a])){
            require (__DIR__ . "/Controllers/" . ucfirst($c) . "Controller.php");
            $controller = ucfirst($c) . "Controller";
            $controller = new $controller();
            $action = $a . "Action";
            $content = json_encode($controller->$action());
//print_r($content);die();
            $action = self::$container["route"][$c][$a];
            if($action == $a) {
                echo $content;
            } else {
                $this->view($action, $content);
            }
        } else {
            die($c . " " . $a . "Action not found");
        }
    }

    private function view($view, $content){
        include("Views/" . $view . ".php");
    }
}