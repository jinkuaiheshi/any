<?php

namespace App\Http\Controllers\Admin;

use App\Admin\AlarmLog;
use App\Admin\Area;
use App\Admin\City;
use App\Admin\Company;
use App\Admin\Province;
use App\Admin\Smoke;
use App\Admin\SmokeLog;
use App\Admin\Street;
use App\Http\Controllers\CommonController;
use App\Service\AliSms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SmokeController extends CommonController
{
    //
    public function index(){
        $islogin = session('islogin');
        if($islogin->type == 1){
            $data = Smoke::with('User')->get();
        }
        return view('admin/smoke')->with('data',$data);
    }
    public function dianliang($cid){
        $ch = curl_init();//初始化curlhttp://api.heclouds.com/devices/528079844/datapoints? datastream_id=3200_0_5503
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$cid.'/datapoints?datastream_id=3200_0_5501');//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //curl_setopt($ch, CURLOPT_POSTFIELDS, '528079844');
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        $dianliang = array();
        foreach (json_decode($data)->data->datastreams as $v){
            $dianliang[$cid]['time'] = $v->datapoints['0']->at;
            $dianliang[$cid]['value'] = $v->datapoints['0']->value;
        }

        return redirect(url()->previous())->with('dianliang',$dianliang[$cid])->withInput();
    }
    public function yanwu($cid){
        $ch = curl_init();//初始化curlhttp://api.heclouds.com/devices/528079844/datapoints? datastream_id=3200_0_5503
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$cid.'/datapoints?datastream_id=3200_0_5503');//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //curl_setopt($ch, CURLOPT_POSTFIELDS, '528079844');
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $yanwu = array();

        foreach (json_decode($data)->data->datastreams as $v){
            $yanwu['time'] = $v->datapoints['0']->at;
            $yanwu['value'] = $v->datapoints['0']->value;
        }
        $end = str_replace(" ","T",date("Y-m-d H:i:s"));
        $start = str_replace(" ","T",date("Y-m-d H:i:s",strtotime("-0 year -3 month -0 day")));

        $ch = curl_init();//初始化curlhttp://api.heclouds.com/devices/528079844/datapoints? datastream_id=3200_0_5503
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$cid.'/datapoints?datastream_id=3200_0_5503&start='.$start.'&end='.$end);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //curl_setopt($ch, CURLOPT_POSTFIELDS, '528079844');
        $datas = curl_exec($ch);//运行curl
        $time = array();
        $value = array();
        foreach (json_decode($datas)->data->datastreams as $v){

            foreach ($v->datapoints as $vv){
                $time[] = $vv->at;
                $value[] = $vv->value;
            }
        }

        return redirect(url()->previous())->with('yanwu',$yanwu)->with('time',\GuzzleHttp\json_encode($time))->with('value',\GuzzleHttp\json_encode($value))->withInput();
    }
    public function alarmLog(){
        $smoke = Smoke::All();
        foreach ($smoke as $value){
            $end = str_replace(" ","T",date("Y-m-d H:i:s"));
            $start = str_replace(" ","T",date("Y-m-d H:i:s",strtotime("-0 year -3 month -0 day")));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$value->cid.'/datapoints?datastream_id=3200_0_5503&start='.$start.'&end='.$end);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            $datas = curl_exec($ch);//运行curl


            foreach (json_decode($datas)->data->datastreams as $v){

                foreach ($v->datapoints as $vv){
                    $alarm_log = new SmokeLog();
                    $alarm_log->status = $vv->value;
                    $alarm_log->time = $vv->at;
                    $alarm_log->cid = $value->cid;
                    $alarm_log->company_id = $value->company_id;
                    $alarm_log->save();
                }
            }

        }
    }
    public function nongdu($cid){
        $ch = curl_init();//初始化curlhttp://api.heclouds.com/devices/528079844/datapoints? datastream_id=3200_0_5503
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$cid.'/datapoints?datastream_id=3200_0_5504');//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //curl_setopt($ch, CURLOPT_POSTFIELDS, '528079844');
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $nongdu = array();

        foreach (json_decode($data)->data->datastreams as $v){
            $nongdu['time'] = $v->datapoints['0']->at;
            $nongdu['value'] = $v->datapoints['0']->value;
        }

        $end = str_replace(" ","T",date("Y-m-d H:i:s"));
        $start = str_replace(" ","T",date("Y-m-d H:i:s",strtotime("-0 year -3 month -0 day")));

        $ch = curl_init();//初始化curlhttp://api.heclouds.com/devices/528079844/datapoints? datastream_id=3200_0_5503
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$cid.'/datapoints?datastream_id=3200_0_5504&start='.$start.'&end='.$end);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //curl_setopt($ch, CURLOPT_POSTFIELDS, '528079844');
        $datas = curl_exec($ch);//运行curl
        $time = array();
        $value = array();
        foreach (json_decode($datas)->data->datastreams as $v){

            foreach ($v->datapoints as $vv){

                $time[] = $vv->at;

                $value[] = $vv->value;
            }
        }

        return redirect(url()->previous())->with('nongdu',$nongdu)->with('time',\GuzzleHttp\json_encode($time))->with('value',\GuzzleHttp\json_encode($value))->withInput();
    }
    public function mute($cid){
        $ch = curl_init();//初始化curlhttp://api.heclouds.com/devices/528079844/datapoints? datastream_id=3200_0_5503
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$cid.'/datapoints?datastream_id=3200_0_5505');//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //curl_setopt($ch, CURLOPT_POSTFIELDS, '528079844');
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        if(json_decode($data)->error == 'succ'){
            return redirect(url()->previous())->with('message', '设备消音成功')->with('type','success')->withInput();
        }
    }
    public function smoke(){
        $islogin = session('islogin');
        if($islogin->type == 1){
            $company = Smoke::All()->groupBy('company_id')->count();
            $data = Smoke::All()->count();

            //地图坐标

            $map = DB::table('smoke')
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
            $alarmgroup = DB::table('smoke_log')
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
                    $fenbu['name']='烟雾报警';
                }
                if($value->status==2){
                    $fenbu['name']='设备静音';
                }
                if($value->status==4){
                    $fenbu['name']='低压';
                }
                if($value->status==5){
                    $fenbu['name']='传感器故障';
                }
                if($value->status==8){
                    $fenbu['name']='指示模块已接收平台下发单次静音指令';
                }
                if($value->status==9){
                    $fenbu['name']='指示模块已接收平台下发连续静音指令';
                }

                if($value->status==10){
                    $fenbu['name']='拆卸报警';
                }
                if($value->status==11){
                    $fenbu['name']='拆卸恢复';
                }
                if($value->status==14){
                    $fenbu['name']='测试键在正常状态按下';
                }
                if($value->status==15){
                    $fenbu['name']='测试键在低压状态按下';
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

        }elseif($islogin->type == 3){

            $company = 1;
            $data = Smoke::where('company_id',$islogin->company_id)->count();

            //地图坐标

            $map = DB::table('smoke')
                ->where('company_id',$islogin->company_id)
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
            $alarmgroup = DB::table('smoke_log')
                ->where('company_id',$islogin->company_id)
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
                    $fenbu['name']='烟雾报警';
                }
                if($value->status==2){
                    $fenbu['name']='设备静音';
                }
                if($value->status==4){
                    $fenbu['name']='低压';
                }
                if($value->status==5){
                    $fenbu['name']='传感器故障';
                }
                if($value->status==8){
                    $fenbu['name']='指示模块已接收平台下发单次静音指令';
                }
                if($value->status==9){
                    $fenbu['name']='指示模块已接收平台下发连续静音指令';
                }

                if($value->status==10){
                    $fenbu['name']='拆卸报警';
                }
                if($value->status==11){
                    $fenbu['name']='拆卸恢复';
                }
                if($value->status==14){
                    $fenbu['name']='测试键在正常状态按下';
                }
                if($value->status==15){
                    $fenbu['name']='测试键在低压状态按下';
                }

                $fenbu['value'] = $value->nums;
                $fenbus[] = $fenbu;
                //设备状态

                $time = date('Y-m-d 00:00',strtotime("-0 year -3 month -0 day"));
                $ok = SmokeLog::where('status',7)->where('company_id',$islogin->company_id)->where('time','>=',$time)->count();
                $no = SmokeLog::wherein('status',[1,4,5,10,14,15])->where('company_id',$islogin->company_id)->where('time','>=',$time)->count();
                $alarmType = array($ok,$no);

                $newAlarm = SmokeLog::with('Company','Smoke')->where('company_id',$islogin->company_id)->take(5)->orderBy('time','DESC')->where('status',14)->orwhere('status',1)->get();

            }
        }

        return view('admin/new_smoke')->with('data',$data)->with('company',$company)->with('map1',\GuzzleHttp\json_encode($tmps))->with('fenbus',json_encode($fenbus))->with('newAlarm',$newAlarm)->with('alarmType',json_encode($alarmType));
    }
    public function new_map(){
        $islogin = session('islogin');
        if($islogin->type == 1) {
            $companys = Smoke::All()->groupBy('company_id')->count();
            $data = Smoke::All()->count();

            //
            $smoke = Smoke::groupby('company_id')->get();

            $map = array();
            $maps= array();
            foreach ($smoke as $v ){
                $company = Company::where('id',$v->company_id)->first();
                //查看他下面的烟感是否有报警的
                $yangan = Smoke::where('company_id',$company->id)->get();
                foreach ($yangan as $vv){

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$vv->cid.'/datapoints?datastream_id=3200_0_5503');//抓取指定网页
                    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
                    curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
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
            $smoke = Smoke::groupby('company_id')->get();
            $json = array();
            $mapDate = array();
            array_push($mapDate,array(
                'id' => 0,
                'pId' => -1,
                'name' => '全国',
                'open' => true,
                'checked' => true
            ));
            foreach ($smoke as $v){
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
                        $json[$company->id]['url'] = '/admin/new/smoke/login/' . $company->id;
                        $mapDate[] = $json[$company->id];
                    }
                }
            }




            return view('admin/new_map')->with('data',$data)->with('company',$companys)->with('map',json_encode($maps))->with('mapDate',json_encode($mapDate));
        }elseif($islogin->type == 3){
            $companys = 1;
            $data = Smoke::where('company_id',$islogin->company_id)->count();

            //
            $smoke = Smoke::where('company_id',$islogin->company_id)->groupby('company_id')->get();

            $map = array();
            $maps= array();
            foreach ($smoke as $v ){
                $company = Company::where('id',$v->company_id)->first();
                //查看他下面的烟感是否有报警的

                $map['flag'] = 1;
                $map['fid'] = $company->id;;
                $map['fLong'] =$company->lng;
                $map['fLati'] =$company->lat;
                $map['content'] =$company->name;
                $map['show'] = 'true';
                $maps[] = $map;

            }

            //地图json
            $smoke = Smoke::groupby('company_id')->get();
            $json = array();
            $mapDate = array();
            array_push($mapDate,array(
                'id' => 0,
                'pId' => -1,
                'name' => '全国',
                'open' => true,
                'checked' => true
            ));
            foreach ($smoke as $v){
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
                        $json[$company->id]['url'] = '/admin/new/smoke/login/' . $company->id;
                        $mapDate[] = $json[$company->id];
                    }
                }
            }




            return view('admin/new_map')->with('data',$data)->with('company',$companys)->with('map',json_encode($maps))->with('mapDate',json_encode($mapDate));
        }

    }
    public function login($company_id){
        if($company_id){

            $smoke = Smoke::with('Company')->where('company_id',$company_id)->get();
            $pro = array();
            $pros = array();
            foreach ($smoke as $v){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$v->cid.'/datapoints?datastream_id=3200_0_5503');//抓取指定网页
                curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
                curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
                $datas = curl_exec($ch);//运行curl




                foreach (json_decode($datas)->data->datastreams as $vvv){

                    foreach ($vvv->datapoints as $vvvv){

                        $pro['name'] = $v->name;
                        $pro['time'] = $vvvv->at;
                        $pro['status'] = $vvvv->value;
                        $pro['cid'] = $v->cid;
                        $pro['IMEI'] = $v->IMEI;
                        $pros[] = $pro;

                    }
                }


            }
        }
        return view('admin/new_pro')->with('smoke',$pros)->with('company_id',$company_id);
    }
    public function new_pro(){
        $islogin = session('islogin');
        if($islogin->type == 1){

           $smoke = Smoke::with('Company')->get();
            $pro = array();
            $pros = array();
           foreach ($smoke as $v){
               $ch = curl_init();
               curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$v->cid.'/datapoints?datastream_id=3200_0_5503');//抓取指定网页
               curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
               curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
               $datas = curl_exec($ch);//运行curl




               foreach (json_decode($datas)->data->datastreams as $vvv){

                   foreach ($vvv->datapoints as $vvvv){

                       $pro['name'] = $v->name;
                       $pro['time'] = $vvvv->at;
                       $pro['status'] = $vvvv->value;
                       $pro['cid'] = $v->cid;
                       $pro['IMEI'] = $v->IMEI;
                       $pros[] = $pro;

                   }
               }


           }


        }
        return view('admin/new_pro')->with('smoke',$pros);
    }
    public function info($cid){
        if($cid){
            $company_id = SmokeLog::where('cid',$cid)->first();
            $log = SmokeLog::with('Company','Smoke')->where('cid',$cid)->wherein('status',[1,4,5,10,14,15])->orderBy('time','DESC')->take(20)->get();
            $end = str_replace(" ","T",date("Y-m-d H:i:s"));
            $start = str_replace(" ","T",date("Y-m-d H:i:s",strtotime("-0 year -3 month -0 day")));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$cid.'/datapoints?datastream_id=3200_0_5503&start='.$start.'&end='.$end);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            $datas = curl_exec($ch);//运行curl


            $time = array();
            $value = array();

            $zhuangtai = array();
            foreach (json_decode($datas)->data->datastreams as $vvv){

                foreach ($vvv->datapoints as $vvvv){
                    $time[] = date('Y-m-d H:i:s',strtotime($vvvv->at));
                    $value[] =$vvvv->value ;

                }
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/'.$cid.'/datapoints?datastream_id=3200_0_5504&start='.$start.'&end='.$end);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            $datas = curl_exec($ch);//运行curl

            $time2 = array();
            $value2 = array();


            foreach (json_decode($datas)->data->datastreams as $vvv){

                foreach ($vvv->datapoints as $vvvv){
                    $time2[] = date('Y-m-d H:i:s',strtotime($vvvv->at));
                    $value2[] =$vvvv->value ;
                }
            }


            return view('admin/new_info')->with('time',\GuzzleHttp\json_encode($time))->with('zhuangtai',\GuzzleHttp\json_encode($value))->with('time2',\GuzzleHttp\json_encode($time2))->with('nongdu',\GuzzleHttp\json_encode($value2))->with('log',$log)->with('company_id',$company_id->company_id);
        }
    }
    public function add(Request $request){
        if ($request->isMethod('POST')) {
            $IMEI = $request['IMEI'];
            $smoke = Smoke::where('IMEI',$IMEI)->first();
            if($smoke){
                return redirect(url()->previous())->with('message', '设备已经存在，无法继续添加')->with('type','danger')->withInput();
            }else{
                $islogin = session('islogin');
                $smoke = new Smoke();
                $smoke->name = $request['name'];
                $smoke->IMEI = $request['IMEI'];
                $smoke->cid = $request['cid'];
                $smoke->api = 'BtlWp3lrdfRJ7cggnoAd7Tp2c=A=';
                $smoke->uid = $islogin->id;
                if($smoke->save()){
                    return redirect(url()->previous())->with('message', '设备添加成功')->with('type','success')->withInput();
                }

            }
        }
    }
    public function tick(Request $request){
        if ($request->isMethod('POST')) {
            $raw_input = file_get_contents('php://input');

            $resolved_body = \Util::resolveBody($raw_input);
            if($resolved_body['ds_id'] == '3200_0_5503'){
                $smoke = Smoke::where('cid',$resolved_body['dev_id'])->first();

                if($smoke){
                    $smokeLog = new  SmokeLog();
                    $smokeLog->status = $resolved_body['value'];
                    $smokeLog->time = date('Y-m-d H:i:s',substr($resolved_body['at'],0,10));
                    $smokeLog->cid = $resolved_body['dev_id'];
                    $smokeLog->company_id = $smoke->company_id;
                    $smokeLog->save();
                }else{
                    return $resolved_body;
                }

                //打电话
                if($resolved_body['value'] == 1||$resolved_body['value'] == 4||$resolved_body['value'] == 5||$resolved_body['value'] == 14||$resolved_body['value'] == 15||$resolved_body['value'] == 10){

                    $company = Company::where('id',$smoke->company_id)->first();

                    if($resolved_body['value'] == 1){
                        $rule = '烟雾报警';
                    }
                    if($resolved_body['value'] == 4){
                        $rule = '低压';
                    }
                    if($resolved_body['value'] == 5){
                        $rule = '传感器故障';
                    }
                    if($resolved_body['value'] == 14){
                        $rule = '测试键在正常状态按下';
                    }
                    if($resolved_body['value'] == 15){
                        $rule = '测试键在低压状态按下';
                    }
                    if($resolved_body['value'] == 10){
                        $rule = '拆卸报警';
                    }
                    if($company->phone1){
                        AliSms::sendSms(AliSms::$defaultSignName,'SMS_172883345',$company->phone1,array('name'=> $smoke->name,'time'=>date('Y-m-d H:i:s',substr($resolved_body['at'],0,10)),'rule'=>$rule));
                    }
                    if($company->phone2){
                        AliSms::sendSms(AliSms::$defaultSignName,'SMS_172883345',$company->phone2,array('name'=> $smoke->name,'time'=>date('Y-m-d H:i:s',substr($resolved_body['at'],0,10)),'rule'=>$rule));
                    }
                    if($company->phone3){
                        AliSms::sendSms(AliSms::$defaultSignName,'SMS_172883345',$company->phone3,array('name'=> $smoke->name,'time'=>date('Y-m-d H:i:s',substr($resolved_body['at'],0,10)),'rule'=>$rule));
                    }
                    if($company->phone4){
                        AliSms::sendSms(AliSms::$defaultSignName,'SMS_172883345',$company->phone4,array('name'=> $smoke->name,'time'=>date('Y-m-d H:i:s',substr($resolved_body['at'],0,10)),'rule'=>$rule));
                    }

                }


            }

        }else{
            $raw_input = file_get_contents('php://input');

            $resolved_body = \Util::resolveBody($raw_input);
            echo $resolved_body;
        }




    }
    public function week($company_id){
        return view('admin/new_port')->with('company_id',$company_id);
    }
    public function week_port(Request $request){
        if ($request->isMethod('POST')) {
            $start = $request['week'];
            $end = date('Y-m-d',strtotime($start)+86400*6);
            $data = SmokeLog::whereBetween('time',[$start,$end])->where('company_id',$request['company_id'])->get();

            $time = array();
            $value = array();
            foreach ($data as $v){
                $time[] = $v->time;
                $value[] = $v->status;

            }



        }
        return view('admin/new_port_smoke')->with('log', $data)->with('data','success')->with('company_id',$request['company_id'])->with('time',\GuzzleHttp\json_encode($time))->with('zhuangtai',\GuzzleHttp\json_encode($value));
    }
    public function month($company_id){
        return view('admin/new_port_month')->with('company_id',$company_id);
    }
    public function month_port(Request $request){
        if ($request->isMethod('POST')) {
            $start = date('Y-m-d',strtotime($request['year'].$request['month'].'01'));

            $end = date('Y-m-d',strtotime($request['year'].$request['month'].'31'));
            $data = SmokeLog::whereBetween('time',[$start,$end])->where('company_id',$request['company_id'])->get();

            $time = array();
            $value = array();
            foreach ($data as $v){
                $time[] = $v->time;
                $value[] = $v->status;

            }
        }
        return view('admin/new_port_smoke_month')->with('log', $data)->with('data','success')->with('company_id',$request['company_id'])->with('time',\GuzzleHttp\json_encode($time))->with('zhuangtai',\GuzzleHttp\json_encode($value));
    }
}
