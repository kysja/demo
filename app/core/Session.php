<?php 

namespace app\core;

class Session
{
    private static function start()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }
    
    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        self::start();
        return $_SESSION[$key] ?? null;
    }

    public static function delete($key)
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function getAndUnset($key)
    {
        self::start();
        $res = self::get($key);
        self::delete($key);
        return $res;
    }

    public static function close()
    {
        self::start();
        session_write_close();
    }

    public static function destroy()
    {
        self::start();
        session_destroy();
    }

    public static function setFlash($type, $value)
    {
        self::start();
        $_SESSION['flash'][] = ['type'=>$type, 'value'=>$value];
    }

    public static function getFlash() : ?array
    {
        self::start();
        $flash = $_SESSION['flash'] ?? null;
        self::deleteFlash();
        return $flash;
    }

    public static function deleteFlash()
    {
        self::start();
        unset($_SESSION['flash']);
    }
    
}