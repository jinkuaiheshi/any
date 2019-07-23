<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table = 'city';
    public $timestamps = false;
    protected $primaryKey = 'id';

}
