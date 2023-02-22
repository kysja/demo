<?php

namespace app\controllers;

use app\core\Auth;
use app\core\View;
use app\core\Router;
use app\models\forms\LoginForm;

class AuthController
{
    public static function loginForm() : string
    {
        if (Auth::authCheck() === true)
            Router::redirect('/');
        $data['form'] = new LoginForm();
        $data['authError'] = $_SESSION['authError'] ?? null;
        unset($_SESSION['authError']);
    
        return View::render('auth/login', $data);
    }

    public static function loginProcess()
    {
        if (Auth::loginProcess($_POST) === true)
            Router::redirect('/');
        
        Router::redirect('/login');
    }

    public static function logout()
    {
        Auth::logout();
        Router::redirect('/login');
    }


    
}