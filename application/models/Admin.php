<?php

namespace application\models;

use application\core\Model;

use Imagick;

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
        } elseif ($descriptionLen < 3 or $descriptionLen > 20) {
            $this->error = 'Описание должно сдержать от 3 до 20 символов';
            return false;
        } elseif ($textLen < 10 or $textLen > 500) {
            $this->error = 'Текст должно сдержать от 10 до 500 символов';
            return false;
        }

        if (empty($_FILES['img']['tmp_name']) and $type == 'add') {
            return false;
        }

        return true;
    }


    public function postAdd($post)
    {
        $params = [
            'name' => $post['name'],
            'description' => $post['description'],
            'text' => $post['text'],
        ];
        $this->db->query('INSERT INTO `posts` (`name`, `description`, `text` ) VALUES ( :name, :description, :text)', $params);
        return $this->db->lastInsertId();
    }

    public function postUploadImage($path, $id)
    {
        $img = new Imagick($path);
        $img->cropThumbnailImage(1024, 1024);
        $img->setImageCompressionQuality(80);
        $img->writeImage('public/materials/' . $id . '.jpg');
        //move_uploaded_file($path, 'public/materials/' . $id . '.jpg');
    }

    public function isPostExists($id)
    {
        $params = [
            'id' => $id,
        ];
        return $this->db->column('SELECT id FROM posts WHERE id = :id', $params);
    }

    public function postDelete($id)
    {
        $params = [
            'id' => $id,
        ];
        $this->db->query('DELETE FROM posts WHERE id = :id', $params);
        //  unlink('public/materials/' . $id . '.jpg');
    }

    public function postData($id)
    {
        $params = [
            'id' => $id,
        ];
        $this->db->query('SELECT * FROM posts WHERE id = :id', $params);
    }
}
