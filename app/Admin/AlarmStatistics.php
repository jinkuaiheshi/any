<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class AlarmStatistics extends Model
{
    //
    protected $table = 'alarm_statistics';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
