<?php

require 'application/lib/Dev.php'; //подключаю обработчик ошибок, вывод массива, метод debug

use application\core\Router; //подключаю класс рутер


spl_autoload_register(function ($class) { //функция срабатывает до вывода ошибки
    $path = str_replace('\\', '/', $class . '.php');

    if (file_exists($path)) {
        require $path;
    }
});

session_start();

$router = new Router;
$router->run();
