<?php

namespace App\Classes;

class Upload
{
    private const UPLOAD_DIR = './assets/images/';
    private $name;
    private $type;
    private $size;
    private $temp;
    private $exetnsion;
    
    public function __construct($array)
    {
        $this->name = $array['name'];
        $this->type = $array['type'];
        $this->size = $array['size'];
        $this->temp = $array['tmp_name'];
        $this->exetnsion =pathinfo($this->name,PATHINFO_EXTENSION);
    }

    public function upload()
    {
        $newName = time() . '.' . $this->exetnsion;
        $address = self::UPLOAD_DIR . $newName;

        if(move_uploaded_file($this->temp,$address))
            return "images/$newName";
        else
            return false;
    }
    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }
    public function getSize()
    {
        return $this->size /1024;
    }
    public function getTemp()
    {
        return $this->temp;
    }
    public function getExtension()
    {
        return $this->exetnsion;
    }

    public function isFile()
    {
        return $this->name!= '';
    }
}