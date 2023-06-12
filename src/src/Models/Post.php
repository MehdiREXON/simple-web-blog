<?php

namespace App\Models;

use App\Entities\PostEntity;

class Post extends Model
{
    protected $fileName  = 'posts';
    protected $entityClass = PostEntity::class;
}