<?php

namespace ReactBlog\Backend\models;

use ReactBlog\Backend\models\BaseModel;

class UserModel extends BaseModel
{
    public function checkUserExists($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username;";
        $params = [
            'username' => $username,
        ];
        return $this->query($sql, $params);
    }

    public function checkPassword($username, $password)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT * FROM users WHERE username = :username AND password = :password;";
        $params = [
            'username' => $username,
            'password' => $hashed,
        ];
        return !!$this->query($sql, $params);
    }

    public function createUser($username, $password)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password);";
        $params = [
            'username' => $username,
            'password' => $hashed,
        ];
        return $this->query($sql, $params);
    }

}