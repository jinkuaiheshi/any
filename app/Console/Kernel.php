<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Redis;
use App\Service\AliSms;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $dev =  Redis::hMGet('dev','60');
            if($dev){
                AliSms::sendSms(AliSms::$defaultSignName,'SMS_172883345','18768534692',array('name'=> 'redis','time'=>date('Y-m-d H:i:s'),'rule'=>'服务器'));
            }else{
                AliSms::sendSms(AliSms::$defaultSignName,'SMS_172883345','18768534692',array('name'=> 'redis','time'=>date('Y-m-d H:i:s'),'rule'=>'服务器'));
            }
        })->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
