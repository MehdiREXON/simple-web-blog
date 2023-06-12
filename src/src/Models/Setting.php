<?php

namespace App\Models;

use App\Entities\SettingEntity;

class Setting extends Model
{
    protected $fileName = "setting";
    protected $entityClass = SettingEntity::class;
}