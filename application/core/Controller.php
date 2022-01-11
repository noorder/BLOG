<?php
//БАЗОВЫЙ КОНТРОЛЛЕР. ВЫЗЫВАЕТСЯ АВТО В НАЧАЛЕ ВЫПОЛНЕНИЯ КОДА
namespace application\core;

use application\core\View;

abstract class Controller
{
    public $route;
    public $view;
    public $acl;

    public function __construct($route)
    {
        $this->route = $route;
        if (!$this->checkAcl()) {
            View::errorCode(403);
        }
        $this->view = new View($route); //отправка роут в View.php  
        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name)
    {
        $path = 'application\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }

    public function checkAcl()
    {
        $this->acl = require 'application/acl/' . $this->route['controller'] . '.php';
        if ($this->isAct('all')) {
            return true;
        } elseif (isset($_SESSION['autorize']['id']) and $this->isAct('autorize')) {
            return true;
        } elseif (!isset($_SESSION['autorize']['id']) and $this->isAct('guest')) {
            return true;
        } elseif (isset($_SESSION['admin']) and $this->isAct('admin')) {
            return true;
        }
        return false;
    }

    public function isAct($key)
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }
}
