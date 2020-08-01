<?php

namespace common;

class View
{

    public function render($view, $data = [])
    {
        require_once("views/" . $view . ".php");
    }

}