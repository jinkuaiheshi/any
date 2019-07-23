<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table = 'user';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function Mac()
    {
        return $this->hasOne('App\Admin\Mac','company_id','id');
    }
}
