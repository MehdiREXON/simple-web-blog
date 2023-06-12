<?php
namespace App\Classes;

class Session
{
    
    public static function get($name)
    {
        if(isset($_SESSION[$name]))
            return $_SESSION[$name];
        return null;
    }

    public static function set($name,$value)
    {
        $_SESSION[$name] =$value; 
    }

    public static function has($name)
    {
        if(isset($_SESSION[$name]))
            return true;
        return false;

    }

    public static function forget($name)
    {
        unset($_SESSION[$name]);
        return true;
    }

    public static function flush($name,$value = null)
    {
        if(self::has($name))
        {
            $session = self::get($name);
            self::forget($name);
            return $session;
        }
        else
            self::set($name,$value);
    }
}