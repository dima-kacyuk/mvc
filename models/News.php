<?php

namespace models;

use common\Database;

class News extends Database
{

    public function findAll(){

        $connect = new Database();

        return mysqli_query($connect->connect, "SELECT * FROM news");
    }

    public function findOne($id)
    {
        $connect = new Database();

        return mysqli_query($connect->connect, "SELECT * FROM news WHERE id = $id");
    }

    public function editNews($id, $title, $description, $date, $image)
    {
        $connect = new Database();

        return mysqli_query($connect->connect, "UPDATE news SET title='$title', description = '$description', date = '$date', image = '$image' WHERE id = '$id'");
    }

    public function pagination($pageResult, $limit)
    {
        $connect = new Database();

        return mysqli_query($connect->connect, "SELECT * FROM news ORDER BY date DESC LIMIT $pageResult, $limit");

    }

    public function searchNews($search)
    {
        $connect = new Database();

        return mysqli_query($connect->connect, "SELECT * FROM news WHERE title LIKE '%$search%' ORDER BY date DESC");
    }

    public function deleteNews($id)
    {
        $connect = new Database();

        return mysqli_query($connect->connect, "DELETE FROM news WHERE id = $id");
    }

}