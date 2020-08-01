<?php


namespace models;


use common\Database;

class Parse extends Database
{

    public function addNews($title, $description, $date, $image)
    {
        $connect = new Database();

        return mysqli_query($connect->connect, "INSERT INTO news (title, description, date, image) VALUES ('$title', '$description', '$date', '$image')");
    }

    public function checkLastNews()
    {
        $connect = new Database();

        return mysqli_query($connect->connect, "SELECT `date` FROM news ORDER BY date DESC LIMIT 1");
    }

}