<?php
namespace App\Classes;

class Database
{
    private $databaseFileAddress;
    private $data;
    
    public function __construct($filename,$entityClass)
    {
        $this->databaseFileAddress = "./database/" .$filename . '.json';

        $file = fopen($this->databaseFileAddress,'r+');
        $database = fread($file,filesize($this->databaseFileAddress));
        fclose($file);

        $data = json_decode($database,true);
        $this->data = array_map(
            function($item)use($entityClass)
            {
                return new ($entityClass)($item);
            },
            $data
        );
    }
    public function setData($newData)
    {
        $this->data = $newData;
        $newData = array_map(
            function($item)
            {
                return $item->toArray();
            },
            $newData
        );
        $newData = json_encode($newData);

        $file = fopen($this->databaseFileAddress,"w+");
        fwrite($file,$newData);
        fclose($file);
        
        return $newData;
    }

    public function getData()
    {
        return $this->data;
    }
}