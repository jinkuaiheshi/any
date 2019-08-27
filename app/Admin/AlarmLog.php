<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class AlarmLog extends Model
{
    //
    protected $table = 'alarm_log';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
