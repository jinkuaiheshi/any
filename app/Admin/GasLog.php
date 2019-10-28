<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class GasLog extends Model
{
    //
    protected $table = 'gas_log';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function Company()
    {
        return $this->hasOne('App\Admin\Company','id','company_id');
    }
    public function Gas()
    {
        return $this->hasOne('App\Admin\Gas','cid','cid');
    }
}
