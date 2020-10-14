<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentAcceptance extends Model
{
    protected $table = "equipment_acceptance";
    public $timestamps = true;
    protected $primaryKey = "approval_id";
}
