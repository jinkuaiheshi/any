<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Gas extends Model
{
    //
    protected $table = 'gas';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function Company()
    {
        return $this->hasOne('App\Admin\Company','id','company_id');
    }
    public function User()
    {
        return $this->hasOne('App\Admin\User','id','uid');
    }
}
