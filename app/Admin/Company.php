<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $table = 'company';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function User()
    {
        return $this->hasOne('App\Admin\User','create_user','create_user');
    }
    public function Province()
    {
        return $this->hasOne('App\Admin\Province','code','province_code');
    }
    public function City()
    {
        return $this->hasOne('App\Admin\City','code','city_code');
    }
    public function Area()
    {
        return $this->hasOne('App\Admin\Area','code','area_code');
    }
    public function Street()
    {
        return $this->hasOne('App\Admin\Street','code','street_code');
    }
}
