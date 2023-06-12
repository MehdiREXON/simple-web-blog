<?php

namespace App\Entities;

class UserEntity
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $date;

    public function __construct($array)
    {
        $this->id = $array['id'];
        $this->firstName = $array['first_name'];
        $this->lastName = $array['last_name'];
        $this->email = $array['email'];
        $this->password = $array['password'];
        $this->date = $array['date'];
    }

    public function toArray()
    {
        return[
            "id" =>$this->id,
            "first_name" =>$this->firstName,
            "last_name" =>$this->lastName,
            "email" =>$this->email,
            "password" =>$this->password,
            "date" =>$this->date
        ];
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getFullName()
    {
        return ucfirst($this->firstName) . ' ' . ucfirst($this->lastName);
    }
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
    public function getDate()
    {
        return $this->date;
    }

    public function getTimestamp()
    {
        return strtotime($this->date);
    }
}