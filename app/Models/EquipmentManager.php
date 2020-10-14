<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentManager extends Model
{
    protected $table = "equipment_manager";
    public $timestamps = true;
    protected $primaryKey = "approval_id";
}
