<?php

namespace App\Models;
use App\Entities\UserEntity;

class User extends Model
{
    protected $fileName = 'users';
    protected $entityClass = UserEntity::class;

    public function authenticationUser($email,$password)
    {
        $data =  $this->database->getData();
        $user = array_filter($data,
        function ($item)use($email,$password)
        {
            if($item->getEmail() == $email and $item->getPassword() == $password)
                return true;
            return false;   
        });

        $user = array_values($user);
        if(count($user))
            return $user[0];
    }
}