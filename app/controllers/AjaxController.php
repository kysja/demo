<?php

namespace app\controllers;

use app\models\Ajax;

class AjaxController
{
    public static function stars() : string
    {
        $result = Ajax::stars($_GET['id'],$_GET['rate']);
        return $result;
    }

    public static function citySearch() : string
    {
        $result = Ajax::citySearch();
        return $result;
    }

}