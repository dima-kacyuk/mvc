<?php

require_once 'common/View.php';
require_once 'common/Application.php';
require_once 'common/Controller.php';
require_once 'common/Database.php';
require_once 'common/Model.php';
require_once 'models/User.php';
require_once 'models/News.php';
require_once 'models/Parse.php';
require_once 'models/Gmail.php';
require_once 'controllers/SiteController.php';

session_start();

$url = $_GET['test'];
echo $url;die();
//new SiteController($url);
//print_r($_GET);
//$main = new common\Application($url);
//$main = new \controllers\SiteController($url);
//echo $url;
//var_dump($_GET);
