<?php

namespace App\Models;
use App\Classes\Database;
use App\Exceptions\{DoesNotExistsException,InvalidMethodException};

abstract class Model
{
    protected $database;
    protected $fileName;
    protected $entityClass;

    public function __construct()
    {
        $this->database = new Database($this->fileName,$this->entityClass);
    }

    public function getAllData()
    {
        return $this->database->getData();
    }

    public function getDataById($id)
    {
        $data = $this->database->getData();

        $array  = array_filter($data,
        function ($item ) use ($id)
        {
            return $item->getId() == $id;
        }
        );
        $data = array_values($array);

        if (count($data))
            return $data[0];
        else
            throw new DoesNotExistsException("There is not any {$this->entityClass}");
    }

    public function getLastData()
    {
        $data = $this->database->getData();
        uasort($data,
            function($first,$second)
            {
                return ($first->getId() > $second->getId()) ? -1 :1;
            }
        );
        
        $data = array_values($data);
   
        if (count($data))
            return $data[0];
        else
            throw new DoesNotExistsException("There is not any {$this->entityClass}");
    }
    
    public function getFirstData()
    {
        $data = $this->database->getData();
        uasort($data,
            function($first,$second)
            {
                return ($first->getId() < $second->getId() ? -1 : 1);
            }
        );
        $data = array_values($data);

        if (count($data))
            return $data[0];
        else
            throw new DoesNotExistsException("There is not any {$this->entityClass}");
    }

    public function sortData($method,$ascending = true)
    {
        if ($this instanceof Setting)
            throw new InvalidMethodException('The sortData method is not applicable to Setting objects');

        $allowedMethods = ['getId', 'getView', 'getDate'];

        if (!in_array($method, $allowedMethods))
            throw new \InvalidArgumentException("Invalid method: {$method}. Allowed methods are: " . implode(', ', $allowedMethods));
        
        $data = $this->database->getData();

        uasort($data,
            function($first,$second)use ($method,$ascending)
            {
                if ($method == 'getDate')
                    return ($ascending)? ($first->getTimestamp() < $second->getTimestamp()) : ($second->getTimestamp() < $first->getTimestamp());
                else
                    return ($ascending)? ($first->$method() < $second->$method()) : ($second->$method() < $first->$method());
            }
        );

        $data = array_values($data);

        if (count($data))
            return $data;
        else
            throw new DoesNotExistsException("There is not any {$this->entityClass}");
    }

    public function filterData($method,$value)
    {
        $data = $this->database->getData();
        
        $data = array_filter($data,
            function ($item)use($value,$method)
            {
                return str_contains($item->$method(),$value);
            }
        );

        $data = array_values($data);

        if (count($data))
            return $data;
        else
            throw new DoesNotExistsException("Counln't find {$value} in {$method}");
    }

    public function createData($new)
    {
        $data = $this->database->getData();
        $data[] = $new;
        
        $this->database->setData($data);
    }

    public function deleteData($id)
    {
        $data = $this->database->getData();
        $newData = array_filter($data,
            function($item)use ($id)
            {
                return $item->getId() == $id ? false : true;
            }
        );
        $newData = array_values($newData);
        $this->database->setData($newData);
    }

    public function editData($new)
    {
        $data = $this->database->getData();
        $newData = array_map(
            function($item)use ($new)
            {
                return $item->getId() == $new->getId() ? $new : $item;
            }
            ,$data
        );
        $newData = array_values($newData);
        $this->database->setData($newData);
    }
}