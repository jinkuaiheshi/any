<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    protected $table = 'province';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
