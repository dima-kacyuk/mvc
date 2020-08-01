<?php

namespace models;

use common\Database;

class User extends Database
{

    public function findOne($username)
    {
        $connect = new Database();

        return mysqli_query($connect->connect, "SELECT * FROM user WHERE username ='$username'");
    }

    public function createUser($username, $password)
    {
        $connect = new Database();

        return mysqli_query($connect->connect, "INSERT INTO user (username, password) VALUES ('$username', '$password')");
    }

}