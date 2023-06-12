<?php

namespace App\Classes;

class Request
{
    private $attributes = [];
    private $method;
    private $url;


    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if($this->method == 'POST')
        {
            foreach($_POST as $key => $value)
            {
                $this->attributes[$key] = $value;
            }

            foreach($_FILES as $key => $value)
            {
                $this->attributes[$key] = new Upload($value);
            }
        }
        foreach($_GET as $key => $value)
        {
            $this->attributes[$key] = $value;
        }
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->attributes))
            return $this->attributes[$name];
        else
            return null;
    }
    #'cuz empty() doesnt like __get
    public function get($name)
    {
        if(array_key_exists($name, $this->attributes))
            return $this->attributes[$name];
        else
            return null;
    }
    public function has($name)
    {
        if(isset($this->attributes[$name]))
            return true;
        else
            return false;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUrl()
    {
        return $this->url;
    }
    
    public function isPostMethod()
    {
        return strtolower($this->method) == 'post';
    }
}