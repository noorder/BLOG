<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;

class MainController extends Controller
{
    public function indexAction()
    {
        $this->view->render('Главная страница');
    }

    public function aboutAction()
    {
        $this->view->render('О сайте');
    }

    public function contactAction()
    {
        if(!empty($_POST)) {
            if(!$this->model->contactValidate($_POST)) {
                $this->view->message('error', $this->model->error);
            }
            mail('schekalaev@gmail.com', 'Сообщение из блога', $_POST['name'] . '|' . $_POST['email'] . '|' . $_POST['text']);
            $this->view->message('success', 'форма работает');
        }
        $this->view->render('Контакты');
    }

    public function postAction()
    {
        $this->view->render('Пост');
    }
}
