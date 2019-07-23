<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    //
    protected $table = 'user_type';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
