<?php

namespace common;

class Database
{

    protected $connect;

    public function __construct()
    {
        $this->connect = mysqli_connect("localhost", "root", "", "test");
    }

}