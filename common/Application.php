<?php


namespace common;


class Application
{

    public function __construct($url)
    {
        /*
        $this->url = $url;

        $subUrl = explode("/", $url);

        if(count($subUrl) == 1){
            $toUpperCase = strtoupper($url[0]);
            $url[0] = $toUpperCase;
            $tmpUrl = 'action' . $url;
        } elseif (count($subUrl) == 2){
            if(count($_GET) > 1){
                $tempArray = [];
                foreach ($_GET as $key=>$value){
                    array_push($tempArray, $value);
                }
                $toUpperCase = strtoupper($subUrl[1][0]);
                $subUrl[1][0] = $toUpperCase;
                $tempUrl = 'action' . $subUrl[1];
                //var_dump($tem_url[1]);
                $this->$tempUrl($tempArray[1]);
                exit();
            }
            else {
                $toUpperCase = strtoupper($subUrl[1][0]);
                $subUrl[1][0] = $toUpperCase;
                $tempUrl = 'action' . $subUrl[1];
                $this->$tempUrl();
            }
        } elseif (count($subUrl) == 3){
            $toUpperCase = strtoupper($subUrl[2][0]);
            $subUrl[2][0] = $toUpperCase;
            $tempUrl = 'action' . $subUrl[2];
        }

        //var_dump($url);

        $this->$tmpUrl();
        */
        /*
        switch ($url) {
            case 'contacts':
                $this->actionContacts();
                break;
            case 'news/allnews':
                $this->actionAllnews();
                break;
            case 'news/singlenews':
                print_r($_GET);
                $id = $_GET['id'];
                var_dump($id);
                $this->actionSinglenews($id);
                break;
        }

        if($url == 'news/singlenews'){
            $this->actionSinglenews(18);
        }
        */
    }

}