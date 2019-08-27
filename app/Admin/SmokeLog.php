<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class SmokeLog extends Model
{
    //
    protected $table = 'smoke_log';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function Company()
    {
        return $this->hasOne('App\Admin\Company','id','company_id');
    }
    public function Smoke()
    {
        return $this->hasOne('App\Admin\Smoke','cid','cid');
    }
}
