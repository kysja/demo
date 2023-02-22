<?php

namespace app\core;

use app\core\Router;

class View
{
    public static function render($path, $data = []) : string
    {
        extract($data);
        $viewGlobal = self::getViewGlobal();
        ob_start();
        include base_path('views/' . $path . '.view.php');
        $content = ob_get_clean();
        return $content;
    }


    private static function getViewGlobal() : array
    {
        $viewGlobal = ['title' => config('title'), 'uri' => Router::getUri()];
        $viewGlobal['flash'] = Session::getFlash() ?? null;
        return $viewGlobal;
    }

}
