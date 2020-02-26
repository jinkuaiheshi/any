<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Service\AliSms;

class Sms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'redis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dev =  Redis::hMGet('dev','60');
        if(!$dev){
            AliSms::sendSms(AliSms::$defaultSignName,'SMS_172883345','18768534692',array('name'=> 'redis','time'=>date('Y-m-d H:i:s'),'rule'=>'服务器'));
        }
    }
}
