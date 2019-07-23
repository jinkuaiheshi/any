<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Mac extends Model
{
    //
    protected $table = 'mac';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function User()
    {
        return $this->hasOne('App\Admin\User','id','company_id');
    }
}
