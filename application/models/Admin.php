<?php

namespace application\models;

use application\core\Model;

class Admin extends Model
{
    public $error;

    public function loginValidate($post)
    {
        $config = require 'application/config/admin.php';
        if ($config['login'] != $post['login']) {
            $this->error = 'ERROR';
            return false;
        }
        return true;
    }

    public function postValidate($post, $type)
    {
        $nameLen = iconv_strlen($post['name']);
        $descriptionLen = iconv_strlen($post['description']);
        $textLen = iconv_strlen($post['text']);
        if ($nameLen < 3 or $nameLen > 20) {
            $this->error = 'Название должно сдержать от 3 до 20 символов';
            return false;
        } 
        elseif ($descriptionLen < 3 or $descriptionLen > 20) {
            $this->error = 'Название должно сдержать от 3 до 20 символов';
            return false;
        }
        elseif ($textLen < 10 or $textLen > 500) {
            $this->error = 'Имя должно сдержать от 10 до 500 символов';
            return false;
        }
        return true;
    }
}
