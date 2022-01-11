<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller
{
    public function loginAction()
    {
        $this->view->render('Вход');
    }

    public function logoutAction()
    {
        $this->view->render('Выход');
    }

    public function addAction()
    {
        $this->view->render('Добавить');
    }

    public function editAction()
    {
        $this->view->render('Редактировать');
    }

    public function deleteAction()
    {
        $this->view->render('Удалить');
    }
}
