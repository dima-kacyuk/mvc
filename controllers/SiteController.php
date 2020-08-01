<?php

namespace controllers;

use common\Controller;
use models\Gmail;
use models\News;
use models\Parse;
use models\User;

class SiteController extends Controller
{
    public $url;

    public function __construct($url)
    {
        $this->url = $url;

        $subUrl = explode("/", $url);

        if(count($subUrl) == 1){
            $toUpperCase = strtoupper($url[0]);
            $url[0] = $toUpperCase;
            $tempUrl = 'action' . $url;
            $this->$tempUrl();
        }
        elseif (count($subUrl) == 2) {
            if(count($_GET) > 1) {
                $tempArray = [];
                foreach ($_GET as $key=>$value)
                {
                    array_push($tempArray, $value);
                }
                $toUpperCase = strtoupper($subUrl[1][0]);
                $subUrl[1][0] = $toUpperCase;
                $tempUrl = 'action' . $subUrl[1];
                $this->$tempUrl($tempArray[1]);
                exit();
            }
            else {
                $toUpperCase = strtoupper($subUrl[1][0]);
                $subUrl[1][0] = $toUpperCase;
                $tempUrl = 'action' . $subUrl[1];
                $this->$tempUrl();
            }
        }

    }

    //Пользователи

    public function actionLogin()
    {
        if(empty($_SESSION['username'])){
            $this->render('user/login');
        }
        else {
            header("Location: ?test=user/personalarea");
        }

    }

    public function actionAuthorization()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = trim($username);
        $password = trim($password);

        $user = new User();
        $db = $user->findOne($username);

        $result = mysqli_fetch_array($db);

        if(empty($result['password'])) {
            $this->render('user/login');
            exit('Неверно введен логин или пароль.');
        }
        else {

            if($password == $result['password'])
            {
                $_SESSION['username'] = $result['username'];
                $_SESSION['id'] = $result['id'];
                header("Location: ?test=user/personalarea");
                //print_r($_SESSION);
            }
            else {
                $this->render('user/login');
                exit('Неверно введен логин или пароль.');
            }
        }
    }

    public function actionPersonalarea()
    {
        $this->render('user/personalarea');
    }

    public function actionLogout()
    {
        session_unset();
        header("Location: ?test=user/login");
    }

    public function actionRegistration()
    {
        if(empty($_SESSION['username'])){
            $this->render('user/registration');
        }
        else {
            header("Location: ?test=user/personalarea");
        }
    }

    public function actionReg()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        $username = trim($username);
        $password = trim($password);
        $confirmPassword = trim($confirmPassword);

        if(strcasecmp($password, $confirmPassword) != 0)
        {
            $this->render('user/registration');
            exit('Введеные пароли не совпадают.');
        }

        $user = new User();
        $db = $user->findOne($username);

        $result = mysqli_fetch_array($db);

        if(!empty($result['id'])) {
            $this->render('user/registration');
            exit('Введенное имя пользователя уже занято, попробуйте другое...');
        }
        else {
            $save = $user->createUser($username, $password);

            if ($save === true) {

                $this->render('user/login');
                echo "Вы успешно зарегестрировались. Теперь можете авторизироваться.";

            } else {

                $this->render('user/registration');

                echo "Ошибка регистрации.";

            }
        }
    }

    //Новости

    public function actionSearch()
    {
        if(!empty($_SESSION['username'])){

            $searchTitle = $_POST['searchTitle'];

            if(empty($searchTitle)) {
                header("Location: ?test=news/allnews");
            }
            else {

                $news = new News();
                $db = $news->searchNews(trim($searchTitle));

                $this->render('/news/allnews', [
                    'result' => $db,
                ]);

            }

        }
        else {
            header("Location: ?test=user/login");
        }
    }

    public function actionAllnews()
    {
        if(!empty($_SESSION['username'])){
            $news = new News();
            $db = $news->findAll();

            $limit = 2;

            $resultNumber = mysqli_num_rows($db);

            $pageNumbers = ceil($resultNumber/$limit);

            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $pageResult = ($page-1) * $limit;

            //var_dump($_GET['page'],$pageResult, $limit);

            $result = $news->pagination($pageResult, $limit);

            $this->render('/news/allnews', [
                'result' => $result,
                'pageNumbers' => $pageNumbers
            ]);

        }
        else {
            header("Location: ?test=user/login");
        }
    }

    public function actionSinglenews($id)
    {
        if(!empty($_SESSION['username'])){
            $news = new News();
            $db = $news->findOne($id);
            $this->render('/news/singlenews', $db);
        }
        else {
            header("Location: ?test=user/login");
        }
    }

    public function actionEditnews($id)
    {
        if(!empty($_SESSION['username']) && $_SESSION['id'] == 1){
            $news = new News();
            $db = $news->findOne($id);
            $this->render('/news/editnews', $db);
        }
        else {
            header("Location: ?test=user/login");
        }
    }

    public function actionEdit($id)
    {
        if(!empty($_SESSION['username']) && $_SESSION['id'] == 1) {
            $title = $_POST['title'];
            $description = $_POST['description'];

            $news = new News();
            $db = $news->findOne($id);

            $result = mysqli_fetch_array($db);

            if (empty($_POST['date'])) {
                $date = $result['date'];
            } else {
                $date = $_POST['date'];
            }

            //var_dump($_FILES['file_upload']);

            if ($_FILES['file_upload']['error'] > 0) {
                $image = $result['image'];
                //var_dump("123");
            } else {
                $uploaddir = '/var/www/mvc/web/images/';
                $uploadfile = $uploaddir . basename($_FILES['file_upload']['name']);
                move_uploaded_file($_FILES['file_upload']['tmp_name'], $uploadfile);
                $image = $_FILES['file_upload']['name'];
                //var_dump("234");
            }

            $news = new News();
            $db = $news->editNews($id, $title, $description, $date, $image);

            if ($db === true) {
                echo '<script language="javascript">';
                echo 'alert("Новость успешно отредактирована.")';
                echo '</script>';
                header("Location: ?test=news/allnews");
            } else {
                echo '<script language="javascript">';
                echo 'alert("Ошибка редактирования.")';
                echo '</script>';
            }
        }
        else {
            header("Location: ?test=user/login");
        }

    }

    public function actionDeletenews($id)
    {
        if(!empty($_SESSION['username']) && $_SESSION['id'] == 1) {
            $news = new News();
            $news->deleteNews($id);
            header("Location: ?test=news/allnews");
        }
        else {
            header("Location: ?test=user/login");
        }
    }

    public function actionParse()
    {

        $parse = new Parse();

        $db = $parse->checkLastNews();

        $lastDateArray = [];

        foreach ($db as $value){
            $lastDateArray = $value;
        }

        $lastTableDate = $lastDateArray['date'];

        //echo $lastTableDate . '<br>';

        $getPage = file_get_contents('http://www.dailynebraskan.com/news/');

        preg_match_all('/<div class="card-body"><div class="card-headline"><h3 class="tnt-headline ">(.+?)<\/h3>/su', $getPage, $title);

        $titleToString = implode(" ", $title[1]);

        preg_match_all('/href="(.+?)"/', $titleToString, $titleLinksArray);

        preg_match_all('/class="tnt-asset-link">(.+?)<\/a>/su', $titleToString, $titleNamesArray);

        preg_match_all('/<time datetime="(.+?)" class="asset-date text-muted">/su', $getPage, $date);

        //print_r($date[1]);

        preg_match_all('/data-srcset="(.+Cresize) 200w,/', $getPage, $image);

        $newDateArray = [];

        foreach ($date[1] as $value){
            array_push($newDateArray, $value);
        }

        //var_dump($newDateArray);

        for ($i = 0; $i<3; $i++){

            if($lastTableDate < $newDateArray[$i]){
                $getTitle = trim($titleNamesArray[1][$i]);

                $singlePageNews = file_get_contents('http://www.dailynebraskan.com/' . $titleLinksArray[1][$i]);

                preg_match_all('/<p dir="ltr">(.+?)<\/p>/', $singlePageNews, $description);

                $getDescription = implode(" ", $description[1]);

                $getDate = $date[1][$i];

                $url = $image[1][$i];

                $getImageName = strstr(basename($url), '?', true);

                $path = '/var/www/mvc/web/images/' . $getImageName;

                file_put_contents($path, file_get_contents($url));

                $parse->addNews($getTitle, $getDescription, $getDate, $getImageName);

            }

            //$gmail = new Gmail('dima.kacyuk@gmail.com', 'fad12345');
            //$gmail->send('vip.dima19@gmail.com.com', 'Заголовок письма', 'Это текст самого письма бла бла бла бла');

            header("Location: ?test=user/personalarea");
            exit('Данные успешно добавленны.');

        }
    }

}