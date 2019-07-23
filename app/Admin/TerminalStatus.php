<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class TerminalStatus extends Model
{
    //
    protected $table = 'terminal_status';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
