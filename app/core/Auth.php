<?php 

namespace app\core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    public static function loginProcess($post) : bool
    {
        $login = trim($post['login']);
        $password = trim($post['password']);
        if (!empty($login) && !empty($password)) {
            $users = config('users');
            if (in_array($login, array_keys($users))) {
                if (password_verify($password, $users[$login]) === true) {
                    $token = self::jwtSetToken($login);
                    setcookie('auth_token', $token, time() + 60*60*24*30, '/');
                    return true;
                }
            }
        }
        Session::set('authError', 'Wrong login or password');
        return false;
    }
    
    public static function authCheck() : bool
    {
        $token = $_COOKIE['auth_token'] ?? null;
        if ($token) {
            $jwtPayload = self::jwtGetPayload($token);
            if ($jwtPayload->exp > time() && in_array($jwtPayload->login, ['demo']))
                return true;
        }
        return false;
    }
    
    public static function jwtSetToken($login) : string
    {
        $jwtKey = config('jwt_key');
        $jwtPayload = ['login' => $login, 'exp' => time() + 60*60*24*30];
        $token = JWT::encode($jwtPayload, $jwtKey, 'HS256');
        return $token;
    }

    public static function jwtGetPayload($token) : object
    {
        $jwtKey = config('jwt_key');
        $data = JWT::decode($token, new Key($jwtKey, 'HS256'));
        return $data;
    }

    public static function logout() : void
    {
        setcookie('auth_token', '', time() - 3600, '/');
    }

}