<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Alarm;
use App\Admin\Area;
use App\Admin\City;
use App\Admin\Company;
use App\Admin\Monitor;
use App\Admin\Organization;
use App\Admin\Province;
use App\Admin\Street;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class OperationController extends CommonController
{
    //
    public function alarmlist(Request $request){

        if(empty(session('old_token')))
        {
            $this->getOldToken('anyun','ayzl8888');
        }
        $data=$this->old_curl('electrical/detector/get_list.php',['token'=>session('old_token'),'Customer'=>'Chin0','rows'=>9999]);
        $data=$data->info->rows;

        $orgs=Organization::where('parent_id','!=','0')->where('is_deleted',0)->where('is_old',1)->select('crcid','name')->get();
        //$p_company=D('Company')->field('name,id,province_code,city_code,area_code')->where(['isdel'=>0])->select();
        $company = Company::where('is_deleted',0)->select('id','name','province_code','city_code','area_code')->get();
        $kkk = array();
        $uuu = array();
        $alarms = array();
        foreach($company as $k=>$v)
        {
            $uuu[$v['name']]=$v['id'];
            $uuu[$v['name'].'_province']=$v['province_code'];
            $uuu[$v['name'].'_city']=$v['city_code'];
            $uuu[$v['name'].'_area']=$v['area_code'];


        }

        $tmp = array();
        foreach($orgs as $k=>$v)
        {
            $tmp[$v['crcid']]=$v['name'];
        }
        $status = $request['status'];
        if($status==''){
            $status = 9;
        }

        foreach($data as $k=>$v){
            //获取离线的设备
            if($v->AlarmText=='离线')
            {
                if(!isset($uuu[$v->CustomerName])){
                    continue;
                }
                $offline[$k]['company_name']=$v->CustomerName;
                if(!isset($tmp[$v->CRCID])){
                    $offline[$k]['org_name']='';
                }else{
                    $offline[$k]['org_name']=$tmp[$v->CRCID];
                }
                $offline[$k]['code']='Y'.$v->CRCID;
                $offline[$k]['alarm_type']='offline';
                $offline[$k]['last_update_time']=$v->UpdataDate;
                $offline[$k]['id']=$uuu[$v->CustomerName];
                $offline[$k]['province_code']=$uuu[$v->CustomerName.'_province'];
                $offline[$k]['city_code']=$uuu[$v->CustomerName.'_city'];
                $offline[$k]['area_code']=$uuu[$v->CustomerName.'_area'];
                $offline[$k]['SimCard']=$v->SimCard;

            }else{

                if($status != 2) {
                    $AlarmWord=ltrim($v->AlarmWord,'[');
                    $AlarmWord=rtrim($AlarmWord,']');

                    $alarmWords=explode(',',$AlarmWord);
                    if($alarmWords){
                        foreach($alarmWords as $k1=>$v1) {

                            $kkk['company_name'] = $v->CustomerName;
                            if (!isset($tmp[$v->CRCID])) {
                                $kkk['org_name'] = '';
                            } else {
                                $kkk['org_name'] = $tmp[$v->CRCID];
                            }
                            $kkk['code'] = 'Y' . $v->CRCID;
                            $kkk['SimCard'] =$v->SimCard;
                            $kkk['last_update_time'] = $v->AlarmDate.'至'.$v->UpdataDate;

                            if (!isset($uuu[$v->CustomerName . '_province'])) {
                                $kkk['province_code'] = '';
                            } else {
                                $kkk['province_code'] = $uuu[$v->CustomerName . '_province'];
                            }
                            if (!isset($uuu[$v->CustomerName . '_city'])) {
                                $kkk['city_code'] = '';
                            } else {
                                $kkk['city_code'] = $uuu[$v->CustomerName . '_city'];
                            }
                            if (!isset($uuu[$v->CustomerName . '_area'])) {
                                $kkk['area_code'] = '';
                            } else {
                                $kkk['area_code'] = $uuu[$v->CustomerName . '_area'];
                            }


                            if (((int)$v1 === 2 && (int)$status == 9) || ((int)$v1 == 2 && (int)$status == 5)) {

                                $kkk['alarm_type'] = 'Il1';
                            } elseif (((int)$v1 === 3 && (int)$status == 9) || ((int)$v1 == 3 && (int)$status == 4)) {
                                //超温.  $status=3;

                                $kkk['alarm_type'] = 't1';

                            } elseif (((int)$v1 ===4 && (int)$status == 9) || ((int)$v1 == 4 && (int)$status == 3)) {
                                //过载
                                $kkk['alarm_type'] = 'Ia';
                            }elseif (((int)$v1 === '' && (int)$status != 2) || ((int)$v1 == '' && (int)$status != 2)) {
                                //过载
                                $kkk['alarm_type'] = '';
                            }

                            if (isset($kkk['alarm_type'])&&$kkk['alarm_type'])
                            {
                                $alarms[] = $kkk;

                            }
                        }
                    }



                }


            }


        }




        //开始处理天一达产品E开头的产品
        if($status != 2) {
            $data = Alarm::with('Company','Organization');
            if($status == 3){
                $data = $data->where('alarm_type','Ia')->orwhere('alarm_type','Ib')->orWhere('alarm_type','Ic')->where('last_update_time','>',strtotime(date("Y-m-d"),time()))->get();
            }elseif ($status == 4){
                $data = $data->where('alarm_type','t1')->orwhere('alarm_type','t2')->orWhere('alarm_type','t3')->orWhere('alarm_type','t4')->where('last_update_time','>',strtotime(date("Y-m-d"),time()))->get();
            }elseif ($status == 5){
                $data = $data->where('alarm_type','Il1')->where('last_update_time','>',strtotime(date("Y-m-d"),time()))->get();
            }else{
                $data = $data->where('last_update_time','>',strtotime(date("Y-m-d"),time()))->get();
            }
            $offs = array();
            $off = array();

            foreach ($data as $lixian){

                $off['company_name'] = $lixian->Company->name;
                $off['org_name'] = isset($lixian->Organization->name)?$lixian->Organization->name:'';
                $off['code'] = $lixian->code;

                $vaule = substr($lixian->code,1,7);

                $dev =  Redis::hMGet('dev',(int)$vaule);
                foreach ($dev as $vvv){
                    $off['SimCard'] = json_decode($vvv)->iccid;

                }

                $off['last_update_time'] = date('Y-m-d H:i:s',$lixian->alarm_time) .'至'.date('Y-m-d H:i:s',$lixian->last_update_time);
                $off['province_code'] = $lixian->Company->province_code;
                $off['city_code'] = $lixian->Company->city_code;
                $off['area_code'] = $lixian->Company->area_code;
                $off['alarm_type'] = $lixian->alarm_type;

                $offs[] = $off;
            }


            $alalm=array_merge($offs,$alarms);

        }else{
            $alalm='';
        }

        //新产品离线

        //E开头的产品离线设备 30分钟之内不算
        $monitors = array();
        $monitor = Monitor::where('is_deleted',0)->where('code','like','E%')->get();
        foreach ($monitor as $k=>$v){
            $monitors[$k] = substr($v->code,1,7);
        }

        $data = array();
        foreach ($monitors as $kk=> $vaule){


            $online =  Redis::hMGet('online',(int)$vaule);

            if($online){
                foreach ($online as $k => $on){
                    //dd($vaule);
                    $tm = substr($on,strpos($on,",")+1);
                    if($tm){
                        if(time() - $tm >= 1800){

                            $datas['time'] = $tm;
                            $datas['code'] = 'E'.$vaule;

                            $data[] = $datas;
                        }
                    }
                }
            }
        }

        //拿到离线的设备的code跟离线时间
        $offline_E =array();
        foreach ($data as $k=> $vv){

            $monitor = Monitor::with('Company','Organization')->where('code','like',$vv['code'].'_0101')->where('is_deleted',0)->first();

            $offline_E[$k]['company_name']=$monitor->Company->name;

            $offline_E[$k]['org_name']=$monitor->Organization->name;

            $offline_E[$k]['code']=$vv['code'];
            $vaule = substr($vv['code'],1,7);

            $dev =  Redis::hMGet('dev',(int)$vaule);
            foreach ($dev as $vvv){
                $offline_E[$k]['SimCard'] = json_decode($vvv)->iccid;

            }

            $offline_E[$k]['alarm_type']='offline';

            $offline_E[$k]['last_update_time']=date('Y-m-d H:i:s',$vv['time']);
            $offline_E[$k]['id']=$monitor->Company->id;
            $offline_E[$k]['province_code']=$monitor->Company->province_code;
            $offline_E[$k]['city_code']=$monitor->Company->city_code;

            $offline_E[$k]['area_code']=$monitor->Company->area_code;
        }

        $province = $request['province'] != '' ? $request['province'] : 0;
        $city = $request['city'] != '' ? $request['city'] : 0;
        $area = $request['area'] != '' ? $request['area'] : 0;

        $data_p = array();

        if($status == 2 ){

            $data = array_merge($offline,$offline_E);
        }elseif($status == 9 ){
            $data = array_merge($offline,$alalm,$offline_E);
        }else{
            $data = $alarms;
        }

        if($province||$city||$area){
            foreach ($data as $vv){
                if($province){
                    if($province == $vv['province_code']){
                        if($city && $city != 0){
                            if($city == $vv['city_code']){
                                if($area && $area != 0){
                                    if($area == $vv['area_code']){
                                        $data_p[]  =$vv;
                                    }
                                }else{
                                    $data_p[]  =$vv;
                                }
                            }
                        }else{
                            $data_p[]  =$vv;
                        }
                    }
                }
            }
            $provinces = Province::All();
            $citys = City::where('province_code',$province)->get();
            $areas = Area::where('city_code',$city)->get();

            return view('admin/operation_alarmlist')->with('status',$status)->with('data', $data_p)->with('province',$provinces)->with('area',$area)->with('city',$city)->with('prov',$province)->with('citys',$citys)->with('areas',$areas);
        }else{
            $province = Province::All();
            return view('admin/operation_alarmlist')->with('status',$status)->with('data', $data)->with('province',$province)->with('prov','')->with('city','')->with('area','');

        }


//        //所属省
//        $province = Province::All();
//
//        return view('admin/operation_alarmlist')->with('status',$status)->with('data', $data)->with('province',$province);
    }
    public function getCity($province){
        if($province){

            $city = City::where('province_code',$province)->get();
            $str = '<option value=0>请选择</option>';
            foreach ($city as $value){
                $str .= '<option value='.$value->code.'>'.$value->name.'</option>';
            }
            return $str;
        }
    }
    public function getArea($city){
        if($city){

            $area = Area::where('city_code',$city)->get();
            $str = '<option value=0>请选择</option>';
            foreach ($area as $value){
                $str .= '<option value='.$value->code.'>'.$value->name.'</option>';
            }
            return $str;
        }
    }
    public function getStreet($area){
        if($area){

            $street = Street::where('area_code',$area)->get();
            $str = '<option value=0>请选择</option>';
            foreach ($street as $value){
                $str .= '<option value='.$value->code.'>'.$value->name.'</option>';
            }
            return $str;
        }
    }
    public function yyyy(){
        if(empty(session('old_token')))
        {

            $this->getOldToken();
        }else{
            $this->getOldToken();
        }
        //获取完所有的json数据-----佰腾设备
        $data=$this->old_curl('electrical/detector/get_customer_list.php',['token'=>session('old_token'),'Customer'=>'Chin0','rows'=>9999]);
        $data=$data->info->rows;
        $str = '';
        foreach ($data as $v){
            $company = Company::where('is_deleted',0)->where('name',$v->Name)->first();
            if(!$company){
                $str .= $v->Name.'<br />';
            }


        }
        dd($str);
    }
    public function zzz(){

       // Redis::set('name', 'guwenjie');
//        $values = Redis::get('daily:1000001:20190415');
//        dd((decbin($values)));
        $aa = hmacsha1('G6G8BaxzMPQduinQoP7XSVdkUNhRTTK4','clientId123456deviceNamejialan_mqttproductKeya1hA6v5caxy');

        dd($aa);
    }
}
