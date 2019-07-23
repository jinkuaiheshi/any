<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    //
    protected $table = 'monitor';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function Organization()
    {
        return $this->hasOne('App\Admin\Organization','id','org_id');
    }
    public function Company()
    {
        return $this->hasOne('App\Admin\Company','id','company_id');
    }
}
