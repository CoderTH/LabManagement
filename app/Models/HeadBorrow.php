<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadBorrow extends Model
{
    protected $table = "head_borrow";
    public $timestamps = true;
    protected $primaryKey = "approval_id";
}
