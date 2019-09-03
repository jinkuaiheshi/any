<?php

namespace App\Http\Controllers\Admin;

use App\Admin\City;
use App\Admin\Company;
use App\Admin\Mac;
use App\Admin\Monitor;
use App\Admin\Provider;
use App\Admin\Province;
use App\Admin\Terminal;
use App\Admin\TerminalAlarmLog;
use App\Admin\TerminalLeakage;
use App\Admin\TerminalPower;
use App\Admin\TerminalStatus;
use App\Admin\TerminalTemp;
use App\Admin\User;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Session;
use AliyunMNS\Client;
use Psy\Util\Json;
use Illuminate\Support\Facades\Redis;

class TerminalController extends CommonController
{
    //
    public function index(){
        $islogin = session('islogin');


       // $mns = new \CreateQueueAndSendMessage($accessId,$accessKey,$endPoint);
        //dd($mns->run());
        if($islogin->type == 1){


            $token = $this->mandunToken();
            $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';
            $accessToken = json_decode($token)->data->accessToken;


            //session(['accessToken' => $accessToken]);
            $method = 'GET_PROJECTS';
            $client_id ='O000002093';
            $timestamp = date('YmdHis',time());
            //dd($accessToken,$method,$client_id,$timestamp);
            $sign = md5($accessToken.$client_id.$method.$timestamp.$APP_SECRET);

            $url = 'https://open.snd02.com/invoke/router.as';

            $param = $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign];
            $o = "";
            foreach ( $param as $k => $v )
            {
                $o.= "$k=" . urlencode( $v ). "&" ;
            }
            $param = substr($o,0,-1);

            $ch = curl_init();//初始化curl
            curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
            //https请求需要加上此行
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
            $data = curl_exec($ch);//运行curl
            curl_close($ch);

           $terminal = json_decode($data)->data;
            $sum = count(json_decode($data)->data);
            //告警分类


        }

        //return view('admin/lot_index')->with('data',$terminal)->with('sum',$sum)->with('mac',Mac::count());
        return view('admin/terminal_mandun')->with('data',$terminal);
    }
    public function alarmLog(){

        $mac = Mac::All();
        foreach ($mac as $v){
            $token = $this->mandunToken();
            $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';
            $accessToken = json_decode($token)->data->accessToken;

            $projectCode = 'P00000001204';
            $method = 'GET_BOX_ALARM';
            $client_id ='O000002093';
            $timestamp = date('YmdHis',time());
            $mac = $v->mac;
            $start = date('Y-m-d 00:00',strtotime("-1 year -0 month -0 day"));
            $end	 = date('Y-m-d 00:00',strtotime("-0 year -0 month -0 day"));

            $pageSize = '9999';
            $sign = md5($accessToken.$client_id.$end.$mac.$method.$pageSize.$projectCode.$start.$timestamp.$APP_SECRET);



            $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
            $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'start'=>$start,'end'=>$end,'pageSize'=>9999];
            $o = "";
            foreach ( $param as $k => $vv )
            {
                $o.= "$k=" . urlencode( $vv ). "&" ;
            }
            $param = substr($o,0,-1);

            $ch = curl_init();//初始化curl
            curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
            //https请求需要加上此行
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
            $data = curl_exec($ch);//运行curl
            curl_close($ch);
            $info = json_decode($data)->data;

            foreach ($info->datas as $value){

                $terminalAlarmLog = new TerminalAlarmLog();
                $terminalAlarmLog->auto_id = $value->auto_id;
                $terminalAlarmLog->node = $value->node;
                $terminalAlarmLog->type = $value->type;
                $terminalAlarmLog->time = $value->time;
                $terminalAlarmLog->typeNumber = $value->typeNumber;
                $terminalAlarmLog->addr = $value->addr;
                $terminalAlarmLog->info = $value->info;
                $terminalAlarmLog->mac = $v->id;
                $terminalAlarmLog->save();
            }
        }

    }
    public function lot(){
        $islogin = session('islogin');


        // $mns = new \CreateQueueAndSendMessage($accessId,$accessKey,$endPoint);
        //dd($mns->run());
        if($islogin->type == 1){


            $token = $this->mandunToken();
            $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';
            $accessToken = json_decode($token)->data->accessToken;


            //session(['accessToken' => $accessToken]);
            $method = 'GET_PROJECTS';
            $client_id ='O000002093';
            $timestamp = date('YmdHis',time());
            //dd($accessToken,$method,$client_id,$timestamp);
            $sign = md5($accessToken.$client_id.$method.$timestamp.$APP_SECRET);

            $url = 'https://open.snd02.com/invoke/router.as';

            $param  = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign];
            $o = "";
            foreach ( $param as $k => $v )
            {
                $o.= "$k=" . urlencode( $v ). "&" ;
            }
            $param = substr($o,0,-1);

            $ch = curl_init();//初始化curl
            curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
            //https请求需要加上此行
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
            $data = curl_exec($ch);//运行curl
            curl_close($ch);
            $terminal = json_decode($data)->data;
            $sum = count(json_decode($data)->data);

            $time = date('Y-m-d 00:00',strtotime("-0 year -3 month -0 day"));
           // $alarmgroup = TerminalAlarmLog::select('typeNumber')->where('time','<=',$time)->groupBy('typeNumber')->get();

            $alarmgroup = DB::table('terminal_alarm_log')
                ->select('typeNumber', DB::raw('count(typeNumber) as nums'),'info')
                ->where('time','>=',$time)
                ->groupBy('typeNumber')
                ->get();

            $fenbu = array();
            $fenbus = array();
            $title = array( 1 =>'',);
            foreach ($alarmgroup as $value ){
                $fenbu['name'] = $value->info;
                $fenbu['value'] = $value->nums;
                $fenbus[] = $fenbu;

            }

            //预警 报警分布
            $yujing = TerminalAlarmLog::where('info','like','%预警')->where('time','>=',$time)->count();
            $baojing = TerminalAlarmLog::where('info','like','%报警')->where('time','>=',$time)->count();
            $alarmType = array($yujing,$baojing);

            //最新5条报警
            $listalatm = array();
            $listalatms = array();
            $newAlarm = TerminalAlarmLog::take(5)->orderBy('time','DESC')->get();
            foreach ($newAlarm as $v){
                $mac = Mac::where('id',$v->mac)->first();

                if($mac){
                    $company = Company::where('id',$mac->company_id)->first();
                    $city = City::where('code',$company->city_code)->first();
                    $listalatm['company'] =$company->name ;
                    $listalatm['city'] =$city->name ;

                    $listalatm['info'] =$v->info ;
                    $listalatm['time'] =$v->time ;
                    $listalatms[] = $listalatm;

                }
            }

            //企业接入



        }elseif($islogin->type == 3){
            $islogin = session('islogin');

            $terminal = Mac::where('company_id',$islogin->id)->count();
            $sum = 1;
        }

        return view('admin/lot_index')->with('data',$terminal)->with('sum',$sum)->with('mac',Mac::count())->with('userinfo',$islogin)->with('fenbus',json_encode($fenbus))->with('title',json_encode($title))->with('alarmType',json_encode($alarmType))->with('newAlarm',$listalatms);

    }
    public function map(){
        return view('admin/lot_map')->with('mac',Mac::count());
    }
    public function duilie(){
        $accessId = "LTAI32xr6egWoWsF";
        $accessKey = "YdY7ZvRZqEzxDPG62f7wm6uxmjFfzh";
        $endPoint = "http://1504563645010586.mns.cn-shanghai.aliyuncs.com/";
        $client = new Client($endPoint, $accessId, $accessKey);
        $terminal = Terminal::All();
        while(true){
            foreach ($terminal as $value){
                $queueName ='aliyun-iot-'.$value->ProductKey;
                $queue = $client->getQueueRef($queueName);

                $receiptHandle = NULL;
                    $res = $queue->receiveMessage(10);

                    if ($res->getMessageBodyMD5())
                    {

                        $data  =  $res->getMessageBody();
                        $topic_power = '/'.$value->ProductKey.'/'.$value->DeviceName.'/user/power';
                        $topic_leakage = '/'.$value->ProductKey.'/'.$value->DeviceName.'/user/leakage';
                        $topic_temp = '/'.$value->ProductKey.'/'.$value->DeviceName.'/user/temp';
                        $topic_status = '/'.$value->ProductKey.'/'.$value->DeviceName.'/user/status';
                        $topic_device = '/'.$value->ProductKey.'/'.$value->DeviceName.'/user/device';
                        //$topic_power = '/'.$value->ProductKey.'/'.$value->DeviceName.'/user/power';

                        // dd(json_decode($data));
                        if(json_decode($data)->topic == $topic_power){
                           // dd('power'.base64_decode(json_decode($data)->payload));
                            $dataTer = new TerminalPower();
                            $dataTer->TimeStamp = date('Y-m-d H:i:s',json_decode($data)->timestamp);
                            $dataTer->ProductKey = $value->ProductKey;
                            $dataTer->DeviceName = $value->DeviceName;
                            $dataTer->DeviceSecret = $value->DeviceSecret;
                            $dataTer->Lines = base64_decode(json_decode($data)->payload);
                            $dataTer->save();
                            $receiptHandle = $res->getReceiptHandle();
                            $queue->deleteMessage($receiptHandle);
                        }elseif(json_decode($data)->topic == $topic_leakage){
                            $dataTer = new TerminalLeakage();
                            $dataTer->TimeStamp = date('Y-m-d H:i:s',json_decode($data)->timestamp);
                            $dataTer->ProductKey = $value->ProductKey;
                            $dataTer->DeviceName = $value->DeviceName;
                            $dataTer->DeviceSecret = $value->DeviceSecret;
                            $dataTer->Lines = base64_decode(json_decode($data)->payload);
                            $dataTer->save();
                            $receiptHandle = $res->getReceiptHandle();
                            $queue->deleteMessage($receiptHandle);
                        }elseif(json_decode($data)->topic == $topic_temp){
                            //dd('temp'.base64_decode(json_decode($data)->payload));
                            $dataTer = new TerminalTemp();
                            $dataTer->TimeStamp = date('Y-m-d H:i:s',json_decode($data)->timestamp);
                            $dataTer->ProductKey = $value->ProductKey;
                            $dataTer->DeviceName = $value->DeviceName;
                            $dataTer->DeviceSecret = $value->DeviceSecret;
                            $dataTer->Lines = base64_decode(json_decode($data)->payload);
                            $dataTer->save();
                            $receiptHandle = $res->getReceiptHandle();
                            $queue->deleteMessage($receiptHandle);
                        }elseif(json_decode($data)->topic == $topic_status){
                            $dataTer = TerminalStatus::where('ProductKey',$value->ProductKey)->where('DeviceName',$value->DeviceName)->where('DeviceSecret',$value->DeviceSecret)->first();
                            if($dataTer){
                                $dataTer->TimeStamp = date('Y-m-d H:i:s',json_decode($data)->timestamp);
                                $dataTer->Lines = base64_decode(json_decode($data)->payload);
                                $dataTer->update();
                                $receiptHandle = $res->getReceiptHandle();
                                $queue->deleteMessage($receiptHandle);
                            }else{
                                $dataTer = new TerminalStatus();
                                $dataTer->TimeStamp = date('Y-m-d H:i:s',json_decode($data)->timestamp);
                                $dataTer->ProductKey = $value->ProductKey;
                                $dataTer->DeviceName = $value->DeviceName;
                                $dataTer->DeviceSecret = $value->DeviceSecret;
                                $dataTer->Lines = base64_decode(json_decode($data)->payload);
                                $dataTer->save();
                                $receiptHandle = $res->getReceiptHandle();
                                $queue->deleteMessage($receiptHandle);
                            }
                        }elseif(json_decode($data)->topic == $topic_device){
                            $dataTer = Terminal::where('ProductKey',$value->ProductKey)->where('DeviceName',$value->DeviceName)->where('DeviceSecret',$value->DeviceSecret)->first();
                            if($dataTer){
                                $dataTer->TimeStamp = date('Y-m-d H:i:s',json_decode($data)->timestamp);
                                $dataTer->Lines = base64_decode(json_decode($data)->payload);
                                $dataTer->update();
                                $receiptHandle = $res->getReceiptHandle();
                                $queue->deleteMessage($receiptHandle);
                            }
                        };
                        //return base64_decode(json_decode($data)->payload);
                    }

                    //删除队列里面的数据



            }
        }


        dd(11123);

    }
    public function getTerminalInfo($id){
       if($id){
           $terminal = Terminal::where('id',$id)->first();
           $data = array();
           if($terminal){
               $temp = json_decode($terminal->Lines,true);
               $data['lan'] = $temp['LAN'];
               $data['ControllerID'] = $temp['ControllerID'];
               $data['Category'] = $temp['Category'];
               $data['SSID'] = $temp['SSID'];
               $data['Version'] = $temp['Version'];
               $data['str'] = '';

               foreach ($temp['Lines'] as $value){
                    if($value['isLeakage'] == 0){
                        $value['isLeakage'] = '不显示漏电值,没有漏电保护功能';
                    }elseif($value['isLeakage'] == 1){
                        $value['isLeakage'] = '显示漏电值,有漏电保护功能,可以实现远程漏电自检';
                    }elseif($value['isLeakage'] == 2){
                        $value['isLeakage'] = '只显示漏电值,没有漏电保护功能,可以修改漏电预警值';
                    }
                   if($value['Enable_Switch'] == 0){
                       $value['Enable_Switch'] = '可以手动开关';
                   }elseif($value['Enable_Switch'] == 1){
                       $value['Enable_Switch'] = '不能手动开关';
                   }
                   if($value['Model'] == '1P'){
                       $value['Model'] = $value['Model'].'(1p按键)';
                   }elseif($value['Model'] == '1P_R'){
                       $value['Model'] = $value['Model'].'(1p按键)';
                   }elseif($value['Model'] == '1PN_R'){
                       $value['Model'] = $value['Model'].'(1PN按键(漏电))';
                   }elseif($value['Model'] == '1PN_H'){
                       $value['Model'] = $value['Model'].'(1PN手柄)';
                   }elseif($value['Model'] == '3PN_H'){
                       $value['Model'] = $value['Model'].'(3PN手柄)';
                   }elseif($value['Model'] == 'ARC_XY32'){
                       $value['Model'] = $value['Model'].'(故障电弧产品)';
                   }elseif($value['Model'] == '3PN_S'){
                       $value['Model'] = $value['Model'].'(三相塑壳断路器)';
                   }




                   $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center'.'">';
                   $data['str'] .= ' <label for="'.'name'.'"  class="'.' col-form-label label200'.'" >线路：</label>';
                   $data['str'] .= ' <div  style="'.'float:left; width: 250px;'.'">';
                   $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['LineNo'].' >';
                   $data['str'] .= '</div>';
                   $data['str'] .= '</div>';
                   $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center'.'">';
                   $data['str'] .= '<label for="'.'name'.'" class="'.'col-form-label label200'.'" >线路ID：</label>';
                   $data['str'] .= '<div  style="'.'float:left; width: 250px;'.'">';
                   $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['LineID'].' >';
                   $data['str'] .= '</div>';
                   $data['str'] .= '</div>';
                   $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center'.'">';
                   $data['str'] .= '<label for="'.'name'.'" class="'.'col-form-label label200'.'" >漏电保护：</label>';
                   $data['str'] .= '<div  style="'.'float:left; width: 500px;'.'">';
                   $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['isLeakage'].' >';
                   $data['str'] .= '</div>';
                   $data['str'] .= '</div>';
                   $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center'.'">';
                   $data['str'] .= '<label for="'.'name'.'" class="'.'col-form-label label200'.'" >断路器：</label>';
                   $data['str'] .= '<div  style="'.'float:left; width: 250px;'.'">';
                   $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['Model'].' >';
                   $data['str'] .= '</div>';
                   $data['str'] .= '</div>';
                   $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center;margin-bottom: 30px;'.'">';
                   $data['str'] .= '<label for="'.'name'.'" class="'.'col-form-label label200'.'" >物理开关：</label>';
                   $data['str'] .= '<div  style="'.'float:left; width: 250px;'.'">';
                   $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['Enable_Switch'].' >';
                   $data['str'] .= '</div>';
                   $data['str'] .= '</div>';
               }


               return $data;
           }
       }
    }
    public function power($id){
        if($id){
            $terminal = Terminal::where('id',$id)->first();
            $power = TerminalPower::where('DeviceName',$terminal->DeviceName)->where('TimeStamp','like',date('Y-m-d',time()).'%')->orderBy('TimeStamp','desc')->get();
            return view('admin/terminal_power')->with('data',$power);
        }
    }
    public function leakage($id){
        if($id){
            $terminal = Terminal::where('id',$id)->first();
            $leakage = TerminalLeakage::where('DeviceName',$terminal->DeviceName)->where('TimeStamp','like',date('Y-m-d',time()).'%')->orderBy('TimeStamp','desc')->get();
            return view('admin/terminal_leakage')->with('data',$leakage);
        }
    }
    public function temp($id){
        if($id){
            $terminal = Terminal::where('id',$id)->first();
            $temp = TerminalTemp::where('DeviceName',$terminal->DeviceName)->where('TimeStamp','like',date('Y-m-d',time()).'%')->orderBy('TimeStamp','desc')->get();
            return view('admin/terminal_temp')->with('data',$temp);
        }
    }
    public function getTerminalPower($id){
        if($id) {
            $power = TerminalPower::where('id', $id)->first();
            $data = array();
            if($power){
                $temp = json_decode($power->Lines,true);
                $data['csq'] = $temp['csq'];
                $data['str'] = '';
                foreach ($temp['Lines'] as $value){
                    $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center'.'">';
                    $data['str'] .= ' <label for="'.'name'.'"  class="'.' col-form-label label200'.'" >线路：</label>';
                    $data['str'] .= ' <div  style="'.'float:left; width: 250px;'.'">';
                    $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['LineNo'].' >';
                    $data['str'] .= '</div>';
                    $data['str'] .= '</div>';
                    $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center'.'">';
                    $data['str'] .= ' <label for="'.'name'.'"  class="'.' col-form-label label200'.'" >线路电压：</label>';
                    $data['str'] .= ' <div  style="'.'float:left; width: 250px;'.'">';
                    $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['Voltage'].' >';
                    $data['str'] .= '</div>';
                    $data['str'] .= '</div>';
                    $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center'.'">';
                    $data['str'] .= ' <label for="'.'name'.'"  class="'.' col-form-label label200'.'" >线路电流：</label>';
                    $data['str'] .= ' <div  style="'.'float:left; width: 250px;'.'">';
                    $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['Current'].' >';
                    $data['str'] .= '</div>';
                    $data['str'] .= '</div>';
                    $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center;margin-bottom: 30px;'.'">';
                    $data['str'] .= ' <label for="'.'name'.'"  class="'.' col-form-label label200'.'" >线路功率：</label>';
                    $data['str'] .= ' <div  style="'.'float:left; width: 250px;'.'">';
                    $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['Power'].' >';
                    $data['str'] .= '</div>';
                    $data['str'] .= '</div>';
                }
                return $data;
            }
        }
    }
    public function getTerminalLeakage($id){
        if($id) {
            $leakage = TerminalLeakage::where('id', $id)->first();
            $data = array();
            if($leakage){
                $temp = json_decode($leakage->Lines,true);

                $data['str'] = '';
                foreach ($temp['Lines'] as $value){
                    $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center'.'">';
                    $data['str'] .= ' <label for="'.'name'.'"  class="'.' col-form-label label200'.'" >线路：</label>';
                    $data['str'] .= ' <div  style="'.'float:left; width: 250px;'.'">';
                    $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['LineNo'].' >';
                    $data['str'] .= '</div>';
                    $data['str'] .= '</div>';
                    $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center;margin-bottom: 30px;'.'">';
                    $data['str'] .= ' <label for="'.'name'.'"  class="'.' col-form-label label200'.'" >漏电值(mA)：</label>';
                    $data['str'] .= ' <div  style="'.'float:left; width: 250px;'.'">';
                    $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['Current'].' >';
                    $data['str'] .= '</div>';
                    $data['str'] .= '</div>';

                }
                return $data;
            }
        }
    }
    public function getTerminalStatus($id){
        if($id) {

            $terminal = Terminal::where('id', $id)->first();
            $status = TerminalStatus::where('ProductKey',$terminal->ProductKey)->where('DeviceSecret',$terminal->DeviceSecret)->where('DeviceName',$terminal->DeviceName)->first();
            $data = array();

            if($status){
                $temp = json_decode($status->Lines,true);

                $data['str'] = '';
                foreach ($temp['Lines'] as $value){

                    if($value['Status'] == 0){
                        $value['Status'] = '关';
                    }elseif($value['Status'] == 1){
                        $value['Status'] = '开';
                    }
                    $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center'.'">';
                    $data['str'] .= ' <label for="'.'name'.'"  class="'.' col-form-label label200'.'" >线路：</label>';
                    $data['str'] .= ' <div  style="'.'float:left; width: 250px;'.'">';
                    $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['LineNo'].' >';
                    $data['str'] .= '</div>';
                    $data['str'] .= '</div>';
                    $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center;margin-bottom: 30px;'.'">';
                    $data['str'] .= ' <label for="'.'name'.'"  class="'.' col-form-label label200'.'" >线路状态：</label>';
                    $data['str'] .= ' <div  style="'.'float:left; width: 250px;'.'">';
                    $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['Status'].' >';
                    $data['str'] .= '</div>';
                    $data['str'] .= '</div>';

                }
                return $data;
            }
        }
    }
    public function getTerminalTemp($id){
        if($id) {

            $Temp = TerminalTemp::where('id', $id)->first();
            $data = array();


            if($Temp){
                $temp = json_decode($Temp->Lines,true);

                $data['str'] = '';
                foreach ($temp['Lines'] as $value){

                    $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center'.'">';
                    $data['str'] .= ' <label for="'.'name'.'"  class="'.' col-form-label label200'.'" >线路：</label>';
                    $data['str'] .= ' <div  style="'.'float:left; width: 250px;'.'">';
                    $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['LineNo'].' >';
                    $data['str'] .= '</div>';
                    $data['str'] .= '</div>';
                    $data['str'] .= '<div class="'.'form-group h-a'.'" style="'.'text-align: center;margin-bottom: 30px;'.'">';
                    $data['str'] .= ' <label for="'.'name'.'"  class="'.' col-form-label label200'.'" >线路温度：</label>';
                    $data['str'] .= ' <div  style="'.'float:left; width: 250px;'.'">';
                    $data['str'] .= ' <input class="'.'form-control'.'" type="'.'text'.'"  name="'.'Version'.'" readonly  value='.$value['Temp'].' >';
                    $data['str'] .= '</div>';
                    $data['str'] .= '</div>';

                }
                return $data;
            }
        }
    }
    public function add(Request $request){
        if ($request->isMethod('POST')) {
            $ProductKey = $request['ProductKey'];
            $DeviceSecret= $request['DeviceSecret'];
            $DeviceName = $request['DeviceName'];

        }
    }
    public function token(){
       $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';
       $accessToken = json_decode($token)->data->accessToken;
       $method = 'GET_PROJECTS';
       $client_id ='O000002093';
       $timestamp = date('YmdHis',time());
       //dd($accessToken,$method,$client_id,$timestamp);
        $sign = md5($accessToken.$client_id.$method.$timestamp.$APP_SECRET);
       
        $url = 'https://open.snd02.com/invoke/router.as';

        $param = $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        dd($data);
        return $data;
    }
    public function info($projectCode){


        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        //session(['accessToken' => $accessToken]);
        $method = 'GET_BOXES';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        //dd($accessToken,$method,$client_id,$timestamp);

        $sign = md5($accessToken.$client_id.$method.$projectCode.$timestamp.$APP_SECRET);

        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
     
        $info = json_decode($data)->data;

        return view('admin/terminal_info')->with('data',$info)->with('projectCode',$projectCode);

    }
    public function getTerminalShishi($mac,$projectCode){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        //session(['accessToken' => $accessToken]);
        $method = 'GET_BOX_CHANNELS_REALTIME';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        //dd($accessToken,$method,$client_id,$timestamp);

        $sign = md5($accessToken.$client_id.$mac.$method.$projectCode.$timestamp.$APP_SECRET);

        $url = 'https://open.snd02.com/invoke/router.as';

        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac];

        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $info = json_decode($data)->data;

        return view('admin/terminal_shishi')->with('data',$info)->with('mac',$mac)->with('projectCode',$projectCode);
    }
    public function getTerminalShuju(Request $request,$addr){

        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;
        $projectCode = $request['projectCode'];
        //session(['accessToken' => $accessToken]);
        $method = 'GET_BOX_CHANNELS_REALTIME';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        //dd($accessToken,$method,$client_id,$timestamp);

        $sign = md5($accessToken.$client_id.$request['mac'].$method.$projectCode.$timestamp.$APP_SECRET);

        $url = 'https://open.snd02.com/invoke/router.as';

        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$request['mac']];

        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $info = json_decode($data)->data;

        $shuju = array();
        foreach ($info as $value){
            if($value->addr == $addr ){
                $shuju[] = $value;
            }
        }

        return $shuju;
    }
    public function alarm($mac,$projectCode){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_BOX_ALARM';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());

        $start = date('Y-m-d H:i',strtotime("-0 year -1 month -0 day"));
        $end	 = date('Y-m-d H:i',time());
        $pageSize = '9999';
        $sign = md5($accessToken.$client_id.$end.$mac.$method.$pageSize.$projectCode.$start.$timestamp.$APP_SECRET);

        

        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'start'=>$start,'end'=>$end,'pageSize'=>9999];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        return view('admin/terminal_alarm')->with('data',$info->datas)->with('projectCode',$projectCode);

    }
    public function electric($mac,$projectCode){
        $year = date('Y',time());
        $years = array();
        for ($i =0;$i<10;$i++){
            $years[] = $year-$i;
        }

        return view('admin/terminal_electric')->with('projectCode',$projectCode)->with('years',$years)->with('mac',$mac);
    }
    public function voltage($mac,$projectCode){
        $year = date('Y',time());
        $years = array();
        for ($i =0;$i<10;$i++){
            $years[] = $year-$i;
        }

        return view('admin/terminal_voltage')->with('projectCode',$projectCode)->with('years',$years)->with('mac',$mac);
    }
    public function galvanic($mac,$projectCode){
        $year = date('Y',time());
        $years = array();
        for ($i =0;$i<10;$i++){
            $years[] = $year-$i;
        }

        return view('admin/terminal_galvanic')->with('projectCode',$projectCode)->with('years',$years)->with('mac',$mac);
    }
    public function leakages($mac,$projectCode){
        $year = date('Y',time());
        $years = array();
        for ($i =0;$i<10;$i++){
            $years[] = $year-$i;
        }

        return view('admin/terminal_leakages')->with('projectCode',$projectCode)->with('years',$years)->with('mac',$mac);
    }
    public function temperature($mac,$projectCode){


        return view('admin/terminal_temperature')->with('projectCode',$projectCode)->with('mac',$mac);
    }
    public function electric_year(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_BOX_MON_POWER';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = $request['years'];
        $sign = md5($accessToken.$client_id.$mac.$method.$projectCode.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;
        $type = 1;
        return view('admin/terminal_electric_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }
    public function electric_month(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_BOX_DAY_POWER';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = explode('-',$request['month'])['0'];
        $month = explode('-',$request['month'])['1'];
        $sign = md5($accessToken.$client_id.$mac.$method.$month.$projectCode.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year,'month'=>$month];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        $type = 2;
        return view('admin/terminal_electric_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }
    public function electric_day(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_BOX_HOUR_POWER';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = explode('-',$request['day'])['0'];
        $month = explode('-',$request['day'])['1'];
        $day= explode('-',$request['day'])['2'];
        $sign = md5($accessToken.$client_id.$day.$mac.$method.$month.$projectCode.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year,'month'=>$month,'day'=>$day];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        $type = 3;
        return view('admin/terminal_electric_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }
    public function voltage_year(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_BOX_MON_AVG_VOLTAGE';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = $request['years'];
        $sign = md5($accessToken.$client_id.$mac.$method.$projectCode.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        $type = 1;
        return view('admin/terminal_voltage_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }
    public function voltage_month(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_BOX_DAY_AVG_VOLTAGE';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = explode('-',$request['month'])['0'];
        $month = explode('-',$request['month'])['1'];
        $sign = md5($accessToken.$client_id.$mac.$method.$month.$projectCode.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year,'month'=>$month];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        $type = 2;
        return view('admin/terminal_voltage_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }
    public function voltage_day(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_BOX_HOUR_AVG_VOLTAGE';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = explode('-',$request['day'])['0'];
        $month = explode('-',$request['day'])['1'];
        $day= explode('-',$request['day'])['2'];
        $sign = md5($accessToken.$client_id.$day.$mac.$method.$month.$projectCode.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year,'month'=>$month,'day'=>$day];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        $type = 3;
        return view('admin/terminal_voltage_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }



    public function galvanic_month(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_STATISTIC_CURRENT';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = explode('-',$request['month'])['0'];
        $month = explode('-',$request['month'])['1'];
        $statsType = 2;
        $sign = md5($accessToken.$client_id.$mac.$method.$month.$projectCode.$statsType.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year,'month'=>$month,'statsType'=>$statsType];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        $type = 2;
        return view('admin/terminal_galvanic_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }
    public function galvanic_day(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_STATISTIC_CURRENT';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = explode('-',$request['day'])['0'];
        $month = explode('-',$request['day'])['1'];
        $day= explode('-',$request['day'])['2'];
        $statsType = 2;
        $sign = md5($accessToken.$client_id.$day.$mac.$method.$month.$projectCode.$statsType.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year,'month'=>$month,'day'=>$day,'statsType'=>$statsType];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        $type = 3;
        return view('admin/terminal_galvanic_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }
    public function leakages_month(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_STATISTIC_LEAKAGE';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = explode('-',$request['month'])['0'];
        $month = explode('-',$request['month'])['1'];
        $statsType = 2;
        $sign = md5($accessToken.$client_id.$mac.$method.$month.$projectCode.$statsType.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year,'month'=>$month,'statsType'=>$statsType];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        $type = 2;
        return view('admin/terminal_leakages_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }
    public function leakages_day(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_STATISTIC_LEAKAGE';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = explode('-',$request['day'])['0'];
        $month = explode('-',$request['day'])['1'];
        $day= explode('-',$request['day'])['2'];
        $statsType = 2;
        $sign = md5($accessToken.$client_id.$day.$mac.$method.$month.$projectCode.$statsType.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year,'month'=>$month,'day'=>$day,'statsType'=>$statsType];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        $type = 3;
        return view('admin/terminal_leakages_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }
    public function temperature_month(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_STATISTIC_TEMPERATURE';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = explode('-',$request['month'])['0'];
        $month = explode('-',$request['month'])['1'];
        $statsType = 2;
        $sign = md5($accessToken.$client_id.$mac.$method.$month.$projectCode.$statsType.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year,'month'=>$month,'statsType'=>$statsType];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        $type = 2;
        return view('admin/terminal_temperature_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }
    public function temperature_day(Request $request){
        $token = $this->mandunToken();
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';

        $accessToken = json_decode($token)->data->accessToken;

        $method = 'GET_STATISTIC_TEMPERATURE';
        $client_id ='O000002093';
        $timestamp = date('YmdHis',time());
        $projectCode = $request['y_projectCode'];
        $mac = $request['y_mac'];
        $year = explode('-',$request['day'])['0'];
        $month = explode('-',$request['day'])['1'];
        $day= explode('-',$request['day'])['2'];
        $statsType = 2;
        $sign = md5($accessToken.$client_id.$day.$mac.$method.$month.$projectCode.$statsType.$timestamp.$year.$APP_SECRET);



        $url = 'https://open.snd02.com/invoke/router.as';

//       $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode];
        $param = ['client_id'=>$client_id,'method'=>$method,'access_token'=>$accessToken,'timestamp'=>$timestamp,'sign'=>$sign,'projectCode'=>$projectCode,'mac'=>$mac,'year'=>$year,'month'=>$month,'day'=>$day,'statsType'=>$statsType];
        $o = "";
        foreach ( $param as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $param = substr($o,0,-1);

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //https请求需要加上此行
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $info = json_decode($data)->data;

        $type = 3;
        return view('admin/terminal_temperature_port')->with('data',$info)->with('projectCode',$projectCode)->with('type',$type);
    }
    public function user(){
        $user = User::with('Mac')->where('is_deleted',0)->where('is_old',9)->get();
        $projectCode = 'P00000001204';
        $mac  = Mac::with('User')->where('id','>',0)->get();

        return view('admin/terminal_user')->with('data',$user)->with('mac',$mac)->with('projectCode',$projectCode);
    }
    public function companyAdd( Request $request){
        if ($request->isMethod('POST')) {

            $name = trim($request['name']);
            $company = Company::where('is_deleted', 0)->where('name', $name)->first();
            if ($company) {
                return redirect(url()->previous())->with('message', '企业名称已经存在无法继续添加')->with('type', 'danger')->withInput();
            } else {
                $company = new Company();
                $company->name = $name;
                $company->code = trim($request['username']);
                $company->province_code = trim($request['province']) == 0 ? '' : trim($request['province']);
                $company->city_code = trim($request['city']) == 0 ? '' : trim($request['city']);
                $company->area_code = trim($request['area']) == 0 ? '' : trim($request['area']);
                $company->street_code = trim($request['street']) === 0 ? '' : trim($request['street']);
                $company->provider_id = trim($request['provider']);
                $company->is_deleted = 2;
                $company->push_type = 1;
                $company->lng = trim($request['lng']) == '' ? '121' : round(trim($request['lng']), 4);
                $company->lat = trim($request['lat']) == '' ? '29' : round(trim($request['lat']), 4);
                $company->address = trim($request['address']);


                if ($request['pic']) {
                    $ext = substr($request['pic'], 11, 3);
                    if ($ext == 'jpe') {
                        $ext = substr($request['pic'], 11, 4);
                    }

                    $base_img = str_replace('data:image/' . $ext . ';base64,', '', $request['pic']);
                    $pic_path = 'pic_' . time() . '.' . $ext;
                    Storage::disk('pic')->put($pic_path, base64_decode($base_img));
                    $company->pic = $pic_path;

                }


                $company->remark = trim($request['remark']);
                $islogin = session('islogin');

                $company->create_time = date('Y-m-d H:i:s', time());
                $company->create_user = $islogin->id;
                $company->create_name = $islogin->fullname;
                //创建企业OK

                if ($company->save()) {
                    $user = new User();
                    $user->username = trim($request['username']);
                    $user->password = sha1('123456');
                    $user->fullname = $name;
                    $com = Company::where('name', $name)->first();
                    $user->type = 3;
                    $user->is_deleted = 0;
                    $user->is_old = 9;
                    $user->company_id = $com->id;
                    $user->create_time = date('Y-m-d H:i:s', time());
                    $user->create_user = $com->create_user;
                    $user->create_name = $com->create_name;
                    $user->encrypt = $this->think_encrypt('123456', 'ujdu9*93j');


                    if ($user->save()) {
                        return redirect('admin/terminal/user')->with('message', '添加企业成功')->with('type', 'success')->withInput();

                    } else {
                        return redirect(url()->previous())->with('message', '创建企业失败')->with('type', 'danger')->withInput();
                    }
                }
            }
        }

                 else {
                    $provider = Provider::where('is_deleted', 0)->get();
                    $province = Province::All();

                    return view('admin/terminal_company_add')->with('province', $province)->with('provider', $provider);
                }
    }
    public function band(Request $request){
        if ($request->isMethod('POST')) {

            $mac = Mac::where('id',$request['mac'])->first();
            if($mac){
                $mac->company_id = $request['companyId'];
                if($mac->update()){

                    $user = User::where('id',$request['companyId'])->first();
                    $user->is_terminal_band = 1;
                        if($user->update()){
                            return redirect(url()->previous())->with('message', '绑定设备成功')->with('type', 'success')->withInput();
                        }
                }else{
                    return redirect(url()->previous())->with('message', '绑定设备失败')->with('type', 'danger')->withInput();
                }
            }
        }
    }
    public function ningbo(){
        $company = Company::where('is_deleted',0)->where('city_code','330200')->get();
        $ids = array();
        foreach ( $company as $value){
            $ids[] = $value->id;
        }

        $monitor = Monitor::with('Company')->where('code','like','E000%')->whereIn('company_id',$ids)->where('is_deleted',0)->get();
        $sum = array();
        foreach ($monitor as $vv){
            $data = array();
            $data['code'] = $vv->code;
            $data['name'] = $vv->Company->name;
            $data['address'] = $vv->Company->address;
            $data['tel1'] = $vv->Company->phone1;
            $data['tel2'] = $vv->Company->phone2;
            $data['tel3'] = $vv->Company->phone3;
            $data['tel4'] = $vv->Company->phone4;

            $code = explode('_0101',$vv->code);
            $tmp = explode('E',$code[0]);
            $dev =  Redis::hMGet('dev',(int)$tmp['1']);
            foreach ($dev as $vvv){
                $data['iccid'] = json_decode($vvv)->iccid;
            }
            $sum[] = $data;
        }

        return view('admin/dhy_ningbo')->with('data',$sum);
    }
    public function yuhuan(){
        $company = Company::where('is_deleted',0)->where('city_code','331000')->get();
        $ids = array();
        foreach ( $company as $value){
            $ids[] = $value->id;
        }

        $monitor = Monitor::with('Company')->whereIn('company_id',$ids)->where('is_deleted',0)->get();
        //dd($monitor);
        $sum = array();
        foreach ($monitor as $vv){
            $data = array();
            $data['code'] = $vv->code;
            $data['name'] = $vv->Company->name;
            $data['address'] = $vv->Company->address;
            $data['tel1'] = $vv->Company->phone1;
            $data['tel2'] = $vv->Company->phone2;
            $data['tel3'] = $vv->Company->phone3;
            $data['tel4'] = $vv->Company->phone4;

            if($vv->simcard){
                $data['iccid'] = $vv->simcard;
            }else{
                $code = explode('_0101',$vv->code);
                $tmp = explode('E',$code[0]);
                $dev =  Redis::hMGet('dev',(int)$tmp['1']);
                foreach ($dev as $vvv){
                    $data['iccid'] = json_decode($vvv)->iccid;
                }
            }

            $sum[] = $data;
        }

        return view('admin/dhy_ningbo')->with('data',$sum);
    }
    public function wuxi(){
        $company = Company::where('is_deleted',0)->where('province_code','320000')->orwhere('province_code','310000')->get();
        $ids = array();
        foreach ( $company as $value){
            $ids[] = $value->id;
        }

        $monitor = Monitor::with('Company','Organization')->whereIn('company_id',$ids)->where('is_deleted',0)->get();
        //dd($monitor);
        $sum = array();
        foreach ($monitor as $vv){
            $data = array();
            $data['code'] = $vv->code;
            $data['name'] = $vv->Company->name;
            $data['address'] = $vv->Company->address;

            $data['tel1'] = $vv->Company->phone1;
            $data['tel2'] = $vv->Company->phone2;
            $data['tel3'] = $vv->Company->phone3;
            $data['tel4'] = $vv->Company->phone4;

            $data['org'] = isset($vv->Organization->name) ? $vv->Organization->name:'';


            if($vv->simcard){
                $data['iccid'] = $vv->simcard;
            }else{
                $code = explode('_0101',$vv->code);
                $tmp = explode('E',$code[0]);

                $dev =  Redis::hMGet('dev',(int)$tmp['1']);
                foreach ($dev as $vvv){
                    $data['iccid'] = json_decode($vvv)->iccid;

                }
            }

            $sum[] = $data;
        }

        return view('admin/dhy_wuxi')->with('data',$sum);
    }

}
