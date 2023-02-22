<?php

namespace app\controllers;

use app\core\View;

class PageController
{
    public static function about() : string
    {
        return View::render('pages/about', $data = ['title' => 'About Demo Project']);
    }

}