<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    //
    protected $table = 'street';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
