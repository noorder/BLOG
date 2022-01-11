<?php

namespace application\core;

class View
{

    public $path; //путь
    public $route2;
    public $layout = 'default'; //шаблон. то что не включено в тег body

    public function __construct($route)
    { //получаем роут из Controller.php
        $this->route2 = $route;
        $this->path = $route['controller'] . '/' . $route['action']; //путь
    }

    public function render($title, $vars = [])
    {
        extract($vars);
        $path = 'application/views/' . $this->path . '.php';
        if (file_exists($path)) { //проверяю наличие файла
            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'application/views/layouts/' . $this->layout . '.php'; //создаю полный пуь для выбора шаблона
        } else 'Вид не найден ' . $this->path;
    }


    public static function errorCode($code)
    {
        http_response_code($code);
        $path = 'application/views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }

    public function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }

    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }

    public function location($url)
    {
        exit(json_encode(['url' => $url]));
    }
}
