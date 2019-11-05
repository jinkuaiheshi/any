<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Area;
use App\Admin\City;
use App\Admin\Company;
use App\Admin\Gas;
use App\Admin\GasLog;
use App\Admin\Province;
use App\Admin\Street;
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
                $ok = GasLog::where('status',7)->where('time','>=',$time)->count();
                $no = GasLog::wherein('status',[1,4,3])->where('time','>=',$time)->count();
                $alarmType = array($ok,$no);

                $newAlarm = GasLog::with('Company','Gas')->take(5)->orderBy('time','DESC')->where('status',14)->orwhere('status',1)->get();


            }

        }

        return view('admin/new_gas')->with('data',$data)->with('company',$company)->with('map1',\GuzzleHttp\json_encode($tmps))->with('fenbus',json_encode($fenbus))->with('newAlarm',$newAlarm)->with('alarmType',json_encode($alarmType));
    }
    public function gas_map(){
        $islogin = session('islogin');

        if($islogin->type == 1){
            $companys = Gas::All()->groupBy('company_id')->count();
            $data = Gas::All()->count();

            //
            $gas = Gas::groupby('company_id')->get();

            $map = array();
            $maps= array();
            foreach ($gas as $v ){
                $company = Company::where('id',$v->company_id)->first();
                //查看他下面的烟感是否有报警的
                $qiti = Gas::where('company_id',$company->id)->get();
                foreach ($qiti as $vv){

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$vv->cid.'/datapoints?datastream_id=3200_0_5503');//抓取指定网页
                    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
                    curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:O89xx4iKd3AgHuyDWHZhsbE4qlQ='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
                    $datas = curl_exec($ch);//运行curl

                    foreach (json_decode($datas)->data->datastreams as $vvv){

                        foreach ($vvv->datapoints as $vvvv){

                            if(time()-strtotime($vvvv->at) >= 300 ){
                                $map['flag'] = 1;
                            }else{
                                $map['flag'] = 2;
                            }
                        }
                    }

                }
                $map['fid'] = $company->id;;
                $map['fLong'] =$company->lng;
                $map['fLati'] =$company->lat;
                $map['content'] =$company->name;
                $map['show'] = 'true';
                $maps[] = $map;

            }
            //地图json
            $gas = Gas::groupby('company_id')->get();
            $json = array();
            $mapDate = array();
            array_push($mapDate,array(
                'id' => 0,
                'pId' => -1,
                'name' => '全国',
                'open' => true,
                'checked' => true
            ));

            foreach ($gas as $v){
                $company = Company::where('id',$v->company_id)->first();

                if(!isset($json[$company->id])) {
                    if (!isset($json[$company->province_code])) {
                        $json[$company->province_code]['id'] = $company->province_code;
                        $json[$company->province_code]['pId'] = 0;
                        $province = Province::where('code', $company->province_code)->first();

                        $json[$company->province_code]['name'] = $province->name;
                        $json[$company->province_code]['open'] = false;
                        $json[$company->province_code]['checked'] = true;
                        $mapDate[] = $json[$company->province_code];
                    }

                    if (!isset($json[$company->city_code])) {
                        $json[$company->city_code]['id'] = $company->city_code;
                        $json[$company->city_code]['pId'] = $company->province_code;
                        $city = City::where('code', $company->city_code)->first();

                        $json[$company->city_code]['name'] = $city->name;
                        $json[$company->city_code]['open'] = false;
                        $json[$company->city_code]['checked'] = true;
                        $mapDate[] = $json[$company->city_code];
                    }
                    if (!isset($json[$company->area_code])) {
                        $json[$company->area_code]['id'] = $company->area_code;
                        $json[$company->area_code]['pId'] = $company->city_code;
                        $area = Area::where('code', $company->area_code)->first();

                        $json[$company->area_code]['name'] = $area->name;
                        $json[$company->area_code]['open'] = false;
                        $json[$company->area_code]['checked'] = true;
                        $mapDate[] = $json[$company->area_code];
                    }
                    if (!isset($json[$company->street_code])) {
                        $json[$company->street_code]['id'] = $company->street_code;
                        $json[$company->street_code]['pId'] = $company->area_code;
                        $street = Street::where('code', $company->street_code)->first();

                        $json[$company->street_code]['name'] = $street->name;
                        $json[$company->street_code]['open'] = false;
                        $json[$company->street_code]['checked'] = true;
                        $mapDate[] = $json[$company->street_code];
                    }
                    if (!isset($json[$company->id])) {
                        $json[$company->id]['id'] = $company->id;
                        $json[$company->id]['pId'] = $company->street_code;


                        $json[$company->id]['name'] = $company->name;
                        $json[$company->id]['open'] = true;
                        $json[$company->id]['checked'] = true;
                        $json[$company->id]['url'] = '/admin/new/gas/login/' . $company->id;
                        $mapDate[] = $json[$company->id];
                    }
                }
            }





        }
        return view('admin/gas_map')->with('data',$data)->with('company',$companys)->with('map',json_encode($maps))->with('mapDate',json_encode($mapDate));
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
