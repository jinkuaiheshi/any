<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    //
    protected $table = 'provider';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function UserType()
    {
        return $this->hasOne('App\Admin\UserType','id','type');
    }
}
