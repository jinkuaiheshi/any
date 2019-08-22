<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class TerminalAlarmLog extends Model
{
    //
    protected $table = 'terminal_alarm_log';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
