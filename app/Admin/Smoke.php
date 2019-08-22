<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Smoke extends Model
{
    //
    protected $table = 'smoke';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function Company()
    {
        return $this->hasOne('App\Admin\Company','id','company_id');
    }
}
