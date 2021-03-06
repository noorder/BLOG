<?php

namespace application\controllers;

use application\core\Controller;

class AdminController extends Controller
{

    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }




    //проверяем соответсвие логина и пароля* с конфигом админа
    public function loginAction()
    {
        if (isset($_SESSION['admin'])) {
            $this->view->redirect('/admin/add');
        }
        if (!empty($_POST)) {
            if (!$this->model->loginValidate($_POST)) {
                $this->view->message('error', $this->model->error);
            }
            $_SESSION['admin'] = true;
            $this->view->location('admin/add');
        }

        $this->view->render('Вход');
    }



    public function addAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->postValidate($_POST, 'add')) {
                $this->view->message('error', $this->model->error);
            }
            $id = $this->model->postAdd($_POST);
            if (!$id) {
                $this->view->message('error', 'Пост не добавлен');
            }
            $this->model->postUploadImage($_FILES['img']['tmp_name'], $id);
            $this->view->message('success', 'Пост добавлен');
        }
        $this->view->render('Добавить пост');
    }



    public function editAction()
    {


        if (!$this->model->isPostExists($this->route['id'])) {
            $this->view->errorCode(404);
        }
        if (!empty($_POST)) {
            if (!$this->model->postValidate($_POST, 'edit')) {
                $this->view->message('error', $this->model->error);
            }
            $this->view->message('SUCCESS', 'OK');
        }
        $vars = [
            'data' => $this->model->postData($this->route['id']),
        ];

        $this->view->render('Редактировать пост', $vars);
    }

    public function deleteAction()
    {
        if (!$this->model->isPostExists($this->route['id'])) {
            $this->view->errorCode(404);
        }
        $this->model->postDelete($this->route['id']);
        $this->view->redirect('admin/posts');
    }

    public function logoutAction()
    {
        unset($_SESSION['admin']);
        $this->view->redirect('/admin/login');
    }



    public function postsAction()
    {
        $this->view->render('посты');
    }
}
