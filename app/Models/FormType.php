<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormType extends Model
{
    protected $table = "form_type";
    public $timestamps = true;
    protected $primaryKey = "form_type_id";
}
