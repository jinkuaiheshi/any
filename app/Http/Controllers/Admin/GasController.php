<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Company;
use App\Admin\Gas;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GasController extends CommonController
{

    public function gas(){
        $islogin = session('islogin');
        if($islogin->type == 1){
            $company = Gas::All()->groupBy('company_id')->count();
            $data = Gas::All()->count();

            //地图坐标

            $map = DB::table('gas')
                ->select('company_id', DB::raw('count(company_id) as coms'))
                ->groupBy('company_id')
                ->get();




            $tmps = array();
            $tmp = array();
            foreach ($map as $value){

                $companys = Company::with('City')->where('id',$value->company_id)->first();
                $tmp['name'] =$companys->City->name;
                $tmp['value'] = $value->coms;
                $tmps = array_prepend($tmps,$tmp);

            }
            //告警分类
            $alarmgroup = DB::table('gas_log')
                ->select('status', DB::raw('count(status) as nums'))

                ->groupBy('status')
                ->get();
            $fenbu = array();
            $fenbus = array();

            foreach ($alarmgroup as $value ){
                if($value->status==7){
                    $fenbu['name']='正常';
                }
                if($value->status==1){
                    $fenbu['name']='燃气报警';
                }
                if($value->status==2){
                    $fenbu['name']='设备静音';
                }
                if($value->status==4){
                    $fenbu['name']='低压';
                }
                if($value->status==3){
                    $fenbu['name']='传感器故障';
                }
                if($value->status==8){
                    $fenbu['name']='指示模块已接收平台下发单次静音指令';
                }
                if($value->status==9){
                    $fenbu['name']='指示模块已接收平台下发连续静音指令';
                }



                $fenbu['value'] = $value->nums;
                $fenbus[] = $fenbu;
                //设备状态

                $time = date('Y-m-d 00:00',strtotime("-0 year -3 month -0 day"));
                $ok = SmokeLog::where('status',7)->where('time','>=',$time)->count();
                $no = SmokeLog::wherein('status',[1,4,5,10,14,15])->where('time','>=',$time)->count();
                $alarmType = array($ok,$no);

                $newAlarm = SmokeLog::with('Company','Smoke')->take(5)->orderBy('time','DESC')->where('status',14)->orwhere('status',1)->get();

            }

        }

        return view('admin/new_smoke')->with('data',$data)->with('company',$company)->with('map1',\GuzzleHttp\json_encode($tmps))->with('fenbus',json_encode($fenbus))->with('newAlarm',$newAlarm)->with('alarmType',json_encode($alarmType));
    }
    public function tick(Request $request){
        if ($request->isMethod('POST')) {
            $raw_input = file_get_contents('php://input');

            $resolved_body = \Util::resolveBody($raw_input);
            if($resolved_body['ds_id'] == '3200_0_5503'){
                $gas = Gas::where('cid',$resolved_body['dev_id'])->first();
                $gasLog = new  GasLog();
                $gasLog->status = $resolved_body['value'];
                $gasLog->time = date('Y-m-d H:i:s',substr($resolved_body['at'],0,10));
                $gasLog->cid = $resolved_body['dev_id'];
                $gasLog->company_id = $gas->company_id;
                $gasLog->save();
                //打电话
                if($resolved_body['value'] == 1||$resolved_body['value'] == 4||$resolved_body['value'] == 3||$resolved_body['value'] == 14||$resolved_body['value'] == 15||$resolved_body['value'] == 10){

                    $company = Company::where('id',$gas->company_id)->first();

                    if($resolved_body['value'] == 1){
                        $rule = '烟雾报警';
                    }
                    if($resolved_body['value'] == 4){
                        $rule = '低压';
                    }
                    if($resolved_body['value'] == 3){
                        $rule = '传感器故障';
                    }

                    if($resolved_body['value'] == 10){
                        $rule = '拆卸报警';
                    }
                    if($company->phone1){
                        AliSms::sendSms(AliSms::$defaultSignName,'SMS_172883345',$company->phone1,array('name'=> $gas->name,'time'=>date('Y-m-d H:i:s',substr($resolved_body['at'],0,10)),'rule'=>$rule));
                    }
                    if($company->phone2){
                        AliSms::sendSms(AliSms::$defaultSignName,'SMS_172883345',$company->phone2,array('name'=> $gas->name,'time'=>date('Y-m-d H:i:s',substr($resolved_body['at'],0,10)),'rule'=>$rule));
                    }
                    if($company->phone3){
                        AliSms::sendSms(AliSms::$defaultSignName,'SMS_172883345',$company->phone3,array('name'=> $gas->name,'time'=>date('Y-m-d H:i:s',substr($resolved_body['at'],0,10)),'rule'=>$rule));
                    }
                    if($company->phone4){
                        AliSms::sendSms(AliSms::$defaultSignName,'SMS_172883345',$company->phone4,array('name'=> $gas->name,'time'=>date('Y-m-d H:i:s',substr($resolved_body['at'],0,10)),'rule'=>$rule));
                    }

                }


            }

        }else{
            $raw_input = file_get_contents('php://input');

            $resolved_body = \Util::resolveBody($raw_input);
            echo $resolved_body;
        }




    }
}
