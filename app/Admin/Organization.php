<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    //
    protected $table = 'organization';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
