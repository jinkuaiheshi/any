<?php

namespace App\Http\Controllers\Admin;


use App\Admin\Alarm;
use App\Admin\AlarmStatistics;
use App\Admin\Area;
use App\Admin\City;
use App\Admin\Company;
use App\Admin\Monitor;
use App\Admin\Organization;
use App\Admin\Provider;
use App\Admin\ProviderBand;
use App\Admin\Province;
use App\Admin\Street;
use App\Admin\User;
use App\Admin\UserGroup;
use App\Admin\UserType;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Service\AliSms;
use Storage;

class SysController extends CommonController
{
    //
    public function company(Request $request){
        $company = Company::where('is_deleted',0);
        if($request['province']){
            $company = $company->where('province_code',$request['province']);
            $province = $request['province'];
            $citys = City::where('province_code',$province)->get();
        }else{
            $province='';
            $citys = '';
        }
        if($request['city']){
            $company = $company->where('city_code',$request['city']);
            $city = $request['city'];
            $areas = Area::where('city_code',$city)->get();
        }else{
            $city = '';
            $areas = '';
        }
        if($request['area']){
            $company = $company->where('area_code',$request['area']);
            $area = $request['area'];
            $streets = Street::where('area_code',$request['area'])->get();

        }else{
            $area = '';
            $streets = '';
        }
        if($request['street']){
            $company = $company->where('street_code',$request['street']);
            $street = $request['street'];
        }else{
            $street = '';
        }
        $data = $company->get();
        $provinces = Province::All();

        return view('admin/sys_company')->with('company',$data)->with('provinces',$provinces)->with('province',$province)->with('city',$city)->with('area',$area)->with('street',$street)->with('citys',$citys)->with('areas',$areas)->with('streets',$streets);
    }
    public function user_auth(){
        $data = UserType::where('status',1)->orderBy('orderBy','ASC')->get();
        return view('admin/sys_auth')->with('data',$data);
    }
    public  function user_auth_add(Request $request){
        if ($request->isMethod('POST')) {
            $name = trim($request['name']);
            $userType = UserType::where('name',$name)->first();
            if($userType){
                return redirect(url()->previous())->with('message', '用户组名称已经存在,无法继续添加')->with('type','danger')->withInput();
            }else{
                $userType = new UserType();
                $userType->name = $name;
                $userType->status = 1;
                $userType->created_time = date('Y-m-d H:i:s', time());
                $userType->orderBy = 1;
                
                if($userType->save()){
                    return redirect(url()->previous())->with('message', '添加用户组成功')->with('type','success')->withInput();
                }


            }
        }
    }
    public function user_auth_del($id){
            if($id){
                $userType = UserType::where('id',$id)->first();
                if($userType->delete()){
                    return redirect(url()->previous())->with('message', '删除用户组成功')->with('type','success')->withInput();
                }else{
                    return redirect(url()->previous())->with('message', '删除用户组失败')->with('type','danger')->withInput();
                }
            }
    }
    public function getUserType($id){
            if($id){
                $userType = UserType::where('id',$id)->first();
                return $userType;
            }
    }
    public function user_auth_up(Request $request){
        if ($request->isMethod('POST')) {
            $userType = UserType::where('id',trim($request['id']))->first();
            $userType->name = trim($request['name']);
            $userType->orderBy = trim($request['order']);
            if($userType->update()){
                return redirect(url()->previous())->with('message', '更新用户组成功')->with('type','success')->withInput();
            }else{
                return redirect(url()->previous())->with('message', '更新用户组失败')->with('type','danger')->withInput();
            }
        }
    }
    public function province(){
        $province = Province::All();
        return view('admin/sys_province')->with('province',$province);
    }
    public function city($id){
        if($id){
            $province = Province::where('id',$id)->first();
            $city = City::where('province_code',$province->code)->get();

            return view('admin/sys_city')->with('city',$city);
        }
    }
    public function area($id){
        if($id){
            $city = City::where('id',$id)->first();
            $area = Area::where('city_code',$city->code)->get();

            return view('admin/sys_area')->with('data',$area);
        }
    }
    public function street($id){
        if($id){
            $area = Area::where('id',$id)->first();
            $street = Street::where('area_coode',$area->code)->get();

            return view('admin/sys_street')->with('data',$street);
        }
    }
    public function getCompanyInfo($id){
        if($id){
            $data = array();
            $company = Company::where('id',$id)->first();

            $province = Province::where('code',$company->province_code)->first();
            $city = City::where('code',$company->city_code)->first();
            $area = Area::where('code',$company->area_code)->first();
            $street = Street::where('code',$company->street_code)->first();
            $data['name'] = $company->name;
            $data['add'] = $company->address;

            if($company->picture != ''){
                $data['pic'] = 'http://img.anyzeal.cn/'.$company->picture;
            }elseif($company->pic !=''){
                $data['pic'] =   url('storage/app/public/pic/').'/'.$company->pic;
            }else{
                $data['pic'] = 'http://img.anyzeal.cn/noPicture.png?imageMogr2/thumbnail/x400/interlace/1';
            }

            $data['province'] = $province->name;
            $data['city'] = $city->name;
            $data['area'] = $area->name;
            if($street){
                $data['street'] = $street->name;
            }else{
                $data['street'] = '';
            }

            return $data;
        }
    }



    public function companyEdit($id){
        if($id){
            $company = Company::where('id',$id)->first();
            $provider = Provider::where('is_deleted',0)->get();
            $province = Province::All();
            $city = City::where('province_code',$company->province_code)->get();
            $area = Area::where('city_code',$company->city_code)->get();
            $street = Street::where('area_code',$company->area_code)->get();

        }
        return view('admin/sys_company_edit')->with('company',$company)->with('provider',$provider)->with('province',$province)->with('city',$city)->with('area',$area)->with('street',$street);
    }
    public function companyUp(Request $request){
        if ($request->isMethod('POST')) {


            $company = Company::where('id',$request['id'])->first();


            if($request['area'] !== 0){
                $company->area_code = trim($request['area']);
            }

            if($request['street'] !== 0){
                $company->street_code = trim($request['street']);
            }

            $company->lng = trim($request['lng'])==''?'121':round(trim($request['lng']),4);
            $company->lat = trim($request['lat'])==''?'29':round(trim($request['lat']),4);
            $company->address = trim($request['address']);
            $company->remark = trim($request['remark']);
            $company->push_type = trim($request['push_type']);
            $company->name = trim($request['name']);


            if($request['pic']){
                $ext = substr($request['pic'] ,11, 3);
                if($ext =='jpe'){
                    $ext = substr($request['pic'] ,11, 4);
                }

                $base_img = str_replace('data:image/'.$ext.';base64,', '', $request['pic']);
                $pic_path = 'pic_' . time() . '.' . $ext;
                Storage::disk('pic')->put($pic_path,  base64_decode( $base_img));
                $company->pic = $pic_path;
                $company->picture = '';
            }

            $company->contact1 = trim($request['contact1']);
            $company->phone1 = trim($request['phone1']);
            $company->email1 = trim($request['email1']);

            $company->contact2 = trim($request['contact2']);
            $company->phone2 = trim($request['phone2']);
            $company->email2 = trim($request['email2']);

            $company->contact3 = trim($request['contact3']);
            $company->phone3 = trim($request['phone3']);
            $company->email3 = trim($request['email3']);

            $company->contact4 = trim($request['contact4']);
            $company->phone4 = trim($request['phone4']);
            $company->email4 = trim($request['email4']);

            $company->contact5 = trim($request['contact5']);
            $company->phone5 = trim($request['phone5']);
            $company->email5 = trim($request['email5']);


            if($company->update()){
                return redirect('admin/sys/company')->with('message', '更新企业信息成功')->with('type','success')->withInput();
            }else{
                return redirect(url()->previous())->with('message', '更新企业信息失败')->with('type','danger')->withInput();
            }




        }
    }
    public function phone(Request $request){
        if($request['tel'] && $request['contact'] && $request['cid'] ){
            $company = Company::where('id',$request['cid'])->first();

            $user = User::where('company_id',$company->id)->first();
            $pwd = $this->think_decrypt($user->encrypt,'ujdu9*93j');

            $ret = AliSms::sendSms(AliSms::$defaultSignName,AliSms::TEMP_ACCOUNT,$request['tel'],array('name'=> $company->name,'username'=>$company->code,'pwd'=>$pwd));
            if($ret->Code === 'OK') {
                $userInfo= array();
                $userInfo['push']['phone'] = $request['tel'];
                $userInfo['push']['time'] = date('Y-m-d h:i:s',time());
                $push = json_decode($company->push_info,true);

                $company->push_info = json_encode(array_prepend($userInfo,$push));
                if($company->update()){
                    return 'ok';
                }
            }

        }

    }

    public function taocan(Request $request){
        if($request['year'] && $request['cid']){
            $company = Company::where('id',$request['cid'])->first();
            $ret = AliSms::sendSms(AliSms::$defaultSignName,'SMS_169899509',$company->phone1,array('time'=> $request['year']));
            if($ret->Code === 'OK') {
                    return 'OK';
            }

        }
    }

    public function  companyAdd(Request $request){


        if ($request->isMethod('POST')) {

            $name = trim($request['name']);
            $company = Company::where('is_deleted',0)->where('name',$name)->first();
            if($company){
                return redirect(url()->previous())->with('message', '企业名称已经存在无法继续添加')->with('type','danger')->withInput();
            }else{
                $company = new Company();
                $company->name = $name;
                $company->province_code =   trim($request['province']) == 0 ? '' : trim($request['province']);
                $company->city_code = trim($request['city']) == 0 ? '' : trim($request['city']);
                $company->area_code = trim($request['area']) == 0 ? '' : trim($request['area']);
                $company->street_code = trim($request['street']) === 0  ? '' : trim($request['street']);
                $company->provider_id = trim($request['provider']);

                if($company->city_code== ''){
                    $whereCode ='A'.'3302';
                    $pr = 'A'.'3302';
                }else{
                    $whereCode ='A'.substr($company['city_code'], 0, 4);
                    $pr ='A'.substr($company['city_code'], 0, 4);
                }
                //dd($pr);

                $lastCode = Company::where('code','like',$whereCode.'%')->orderBy('id','Desc')->take(1)->first();
                if($lastCode){
                    $index = substr($lastCode->code, 5, 3)+1;
                    $company->code = $pr.$index;
                }else{
                    $index = '001';
                    $company->code = $pr.$index;
                }




                $company->lng = trim($request['lng'])==''?'121':round(trim($request['lng']),4);
                $company->lat = trim($request['lat'])==''?'29':round(trim($request['lat']),4);
                $company->address = trim($request['address']);


                if($request['pic']){
                    $ext = substr($request['pic'] ,11, 3);
                    if($ext =='jpe'){
                        $ext = substr($request['pic'] ,11, 4);
                    }

                    $base_img = str_replace('data:image/'.$ext.';base64,', '', $request['pic']);
                    $pic_path = 'pic_' . time() . '.' . $ext;
                    Storage::disk('pic')->put($pic_path,  base64_decode( $base_img));
                    $company->pic = $pic_path;

                }


                $company->push_type = trim($request['push_type']);
                $company->remark = trim($request['remark']);
                $islogin = session('islogin');

                $company->create_time =  date('Y-m-d H:i:s', time());
                $company->create_user = $islogin->id;
                $company->create_name = $islogin->fullname;
                //创建企业OK

                    if($company->save()){
                        $user = new User();
                        $user->username = $pr.$index;
                        $user->password = sha1('123456');
                        $user->fullname = $name;
                        $com = Company::where('name',$name)->first();
                        $user->type = 3;
                        $user->company_id = $com->id;
                        $user->create_time = date('Y-m-d H:i:s', time());
                        $user->create_user = $com->create_user;
                        $user->create_name = $com->create_name;
                        $user->encrypt = $this->think_encrypt('123456','ujdu9*93j');

                        if($user->save()){
                            $group = new UserGroup();
                            $use = User::where('username',$pr.$index)->first();
                            $group->user_id = $use->id;
                            $group->group_id = 7;
                            $group->create_time =date('Y-m-d H:i:s', time());
                            $group->create_user = $com->create_user;
                            if($group->save()){
                                return redirect('admin/sys/company')->with('message', '添加企业成功')->with('type','success')->withInput();
                            }

                        }
                    }else{
                        return redirect(url()->previous())->with('message', '创建企业失败')->with('type','danger')->withInput();
                    }


            }
        }else{
            $provider = Provider::where('is_deleted',0)->get();
            $province = Province::All();

            return view('admin/sys_company_add')->with('province',$province)->with('provider',$provider);
        }
    
    }
    public function provider(Request $request){

        if ($request->isMethod('POST')) {
            $provider = Provider::where('name',trim($request['fname']))->where('is_deleted',0)->first();
            if($provider){
                return redirect(url()->previous())->with('message', '服务商名称已经存在无法继续添加')->with('type','danger')->withInput();
            }else{
                $provider = new Provider();
                $provider->name = trim($request['fname']);
                $provider->service_no = trim($request['service_no']);
                $provider->province_code = trim($request['fprovince']);
                $provider->city_code = trim($request['fcity']);
                $provider->area_code = trim($request['farea']);
                $provider->address = trim($request['address']);
                $provider->contact_name = trim($request['contact_name']);
                $provider->contact_phone = trim($request['contact_phone']);
                $provider->create_time = date('Y-m-d H:i:s', time());
                $islogin = session('islogin');
                $provider->create_user = $islogin->id;
                $provider->create_name = $islogin->fullname;
                if($provider->save()){
                    return redirect(url()->previous())->with('message', '服务商添加成功')->with('type','success')->withInput();
                }
            }

        }else{
            $provider = Provider::with('UserType')->where('is_deleted',0)->get();
            $province =Province::All();
            $userType = UserType::All();
            return view('admin/sys_provider')->with('data',$provider)->with('userType',$userType)->with('province',$province);
        }

    }
    public function  setProvider($id){
        if($id){
            $provider = Provider::where('id',$id)->first();
            return $provider;
        }
    }
    public function superior(Request $request){
        if ($request->isMethod('POST')) {
            $type = $request['type'];
            $provider = Provider::where('id',$request['pid'])->first();

            if($type ) {
                //总代理
                $provider->type = $type;
                if ($request['is_superior'] == 1) {
                    $providerBand = new ProviderBand();
                    $providerBand->provider_id = $provider->id;
                    $providerBand->name = $provider->name;
                    //绑定父级
                    $providerParent = $provider::where('id', $request['superior'])->first();
                    if ($providerParent) {
                        $providerBand->parent_id = $providerParent->id;
                        $providerParent->is_superior = 1;
                    }
                }else{
                    $providerBand = new ProviderBand();
                    $providerBand->provider_id = $provider->id;
                    $providerBand->name = $provider->name;
                    $providerBand->parent_id = 0;
                    if($providerBand->save()&&$provider->update()){
                        return redirect(url()->previous())->with('message', '设置代理成功')->with('type','success')->withInput();
                    }else{
                        return redirect(url()->previous())->with('message', '设置代理失败')->with('type','danger')->withInput();
                    }

                }
            }
            if($providerBand->save()&&$provider->update()&&$providerParent->update()){
                return redirect(url()->previous())->with('message', '设置代理成功')->with('type','success')->withInput();
            }else{
                return redirect(url()->previous())->with('message', '设置代理失败')->with('type','danger')->withInput();
            }
        }
    }
    public function superior_del($id){
        if($id){
            $provider = Provider::where('id',$id)->first();
            if($provider->devs){
                return redirect(url()->previous())->with('message', '当前服务商下的企业存在设备，无法直接删除')->with('type','danger')->withInput();
            }else{
                if($provider->delete()){
                    return redirect(url()->previous())->with('message', '删除服务商成功')->with('type','success')->withInput();
                }
            }
        }
    }
    public function superior_subordinate($id){
            if($id){
                $provider = Provider::where('id',$id)->first();
                $ids = array();
                if($provider->is_superior == 1){
                    $tree = ProviderBand::where('parent_id',$id)->get();
                    if($tree){
                        foreach ($tree as $data){
                            $tmp = Provider::where('id',$data->provider_id)->first();
                            $ids[] = $tmp->id;
                            if($tmp->is_superior == 1){
                                $tree = ProviderBand::where('parent_id',$tmp->id)->get();
                            }
                            if($tree){
                                foreach ($tree as $data){
                                    $tmp = Provider::where('id',$data->provider_id)->first();
                                    $ids[] = $tmp->id;
                                    if($tmp->is_superior == 1){
                                        $tree = ProviderBand::where('parent_id',$tmp->id)->get();
                                        if($tree){
                                            foreach ($tree as $data){
                                                $tmp = Provider::where('id',$data->provider_id)->first();
                                                $ids[] = $tmp->id;
                                                if($tmp->is_superior == 1){
                                                    $tree = ProviderBand::where('parent_id',$tmp->id)->get();
                                                    if($tree){
                                                        foreach ($tree as $data){
                                                            $tmp = Provider::where('id',$data->provider_id)->first();
                                                            $ids[] = $tmp->id;
                                                            if($tmp->is_superior == 1){
                                                                $tree = ProviderBand::where('parent_id',$tmp->id)->get();

                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $superior = Provider::whereIn('id',$ids)->get();
                $province =Province::All();
                $userType = UserType::All();
                return view('admin/sys_provider')->with('data',$superior)->with('userType',$userType)->with('province',$province);

            }
    }
    public function setMonitor($id){
        if($id){
            $monitor = Monitor::with('Organization','Company')->where('is_deleted','0')->where('company_id',$id)->get();
            $data = array();
            foreach ($monitor as $k=>$v){
                $parent = Organization::where('id',$v->Organization->parent_id)->first();

                foreach (json_decode($v->Company->devs,true) as $vv){
                    if($vv['code'] == substr($v->code,0,8)){
                        $data[$k]['term'] = $vv['term'];
                    }
                }
                $data[$k]['id'] = $v->id;
                $data[$k]['parentName'] = $parent->name;
                $data[$k]['name'] = $v->Organization->name;
                $data[$k]['code'] = $v->code;
                $data[$k]['company'] = $v->Company->name;
                $data[$k]['start_time'] = date('Y-m-d h:i:s',$v->start_time);
            }

            return view('admin/sys_setMonitor')->with('data',$data);
        }
    }
    public function getMonitorGroup($id){

    }
    public function ccc(){
        set_time_limit(0);
        $area = Area::All();
        $str = 168;
        foreach ($area as $v){
            $host = "http://district.market.alicloudapi.com";
            $path = "/v3/config/district";
            $method = "GET";
            $appcode = "bcf8d53fbd2043e68dac43cc3accb9cd";
            $headers = array();
            array_push($headers, "Authorization:APPCODE " . $appcode);
            $querys = 'keywords='.$v->name.'&subdistrict=1&extensions=base';
            $bodys = "";
            $url = $host . $path . "?" . $querys;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_FAILONERROR, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            if (1 == strpos("$".$host, "https://"))
            {
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            }

            $data = json_decode(curl_exec($curl));

            if(isset($data->districts['0']->districts)){
                foreach ( $data->districts['0']->districts as $vv){
                    $street = new Street();
                    $street->name = $vv ->name;
                    $street->code = 'dhy'.$str;
                    $street->area_coode = $vv ->adcode;
                    $street->save();
                    $str++;

                }
                var_dump('完成'.$data->districts['0']->name.'的数据');
                flush();
                ob_flush();

            }


        }
        }

        public function jjj(){
            set_time_limit(0);
            $company = Company::where('is_deleted',0)->where('id','>=',401)->where('id','<=',500)->get();
            $str = '';

            foreach ($company as $vv){
                $curl = curl_init(); // 启动一个CURL会话

                $local ='location='.$vv->lat.','.$vv->lng;
                $url = 'https://apis.map.qq.com/ws/geocoder/v1/?'.$local.'&key=KM6BZ-AKTRX-SGN4D-72YUQ-Q7K6T-Z2FIO&get_poi=1';

                curl_setopt($curl, CURLOPT_URL, $url);

                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查

                $tmpInfo = curl_exec($curl);     //返回api的json对象
                //关闭URL请求
                curl_close($curl);
                $data = json_decode($tmpInfo, true);
                $title = $data['result']['address_reference']['town']['title'];
                $str.= '<<<'.$vv->id.'---'.$title.'>>>';
                flush();
                ob_flush();
                sleep(1);

            }

            dd($str);

        }
        public function ddd(){
            $company = Company::where('is_deleted',0)->where('provider_id',5)->orwhere('provider_id',15)->orwhere('provider_id',20)->orwhere('provider_id',21)->orwhere('provider_id',23)->orwhere('provider_id',24)->get();
            $con = array();
            $i = 0;
            foreach($company as $value){
                $monitor = Monitor::where('is_deleted',0)->where('company_id',$value->id)->count();
                $i += $monitor;
            }
            dd($i);

            $monitor = Monitor::where('is_deleted',0)->get();
            foreach ($monitor as $data ){

            }
        }

        public function dashboard(){
            //获取用户有多少佰腾设备
            //获取
            $islogin = session('islogin');

            if($islogin->type == 1){

            }elseif($islogin->type == 2){


            }elseif($islogin->type == 3){


            }



            //$detail['E1010'] = $monitor_E0000;


            return view('admin/sys_dashboard');
        }
        public function msd(){
        dd(123);
        }
        public function usage(){




            $company = Company::with('Province','City','Area','Street')->where('is_deleted','0')->get();
            return view('admin/dhy_usage')->with('data',$company);
        }
        public function alarm(){
            $islogin = session('islogin');
            if($islogin->type == 1){
                if(empty(session('old_token')))
                {
                    $this->getOldToken('anyun','ayzl8888');
                }
                $data=$this->old_curl('electrical/detector/get_list.php',['token'=>session('old_token'),'Customer'=>'Chin0','rows'=>9999]);
                $data=$data->info->rows;
                dd($data);

            }elseif($islogin->type == 2){

            }elseif($islogin->type == 3){

            }
        }
        public function baitengUp(){
            if(empty(session('old_token')))
            {
                $this->getOldToken('anyun','ayzl8888');
            }
            $data=$this->old_curl('electrical/detector/get_list.php',['token'=>session('old_token'),'Customer'=>'Chin0','rows'=>9999]);
            $data=$data->info->rows;
            $sum = array();
            foreach ( $data as $v){
                $monitor = Monitor::where('is_deleted',0)->where('code','Y'.$v->CRCID)->first();
                if(!$monitor){
                    $sum[] = $v;
                }
            }

            return view('admin/dhy_baiteng_up')->with('data',$sum);
        }
        public function jingbao(){

//            $end = strtotime(date("Y-m-d"),time());
//            $start = $end-86400;
//            $data = array();
//            //昨天所有警报次数
//            $alarm =Alarm::where('last_update_time','<=',$end)->where('alarm_time','>=',$start)->get();
//            $alarmCount = 0;
//            $alarm_Il = 0;
//            $alarm_t = 0;
//            $alarm_I = 0;
//            $alarm_coms = array();
//            $alarm_company = 0;
//            foreach ($alarm as $value){
//                if(($value->last_update_time - $value->alarm_time) >= 300 ){
//                    $alarmCount++;
//                    if($value->alarm_type == 'Il1'){
//                        $alarm_Il++;
//                    }elseif($value->alarm_type == 't1' ||$value->alarm_type == 't2' ||$value->alarm_type == 't3' ||$value->alarm_type == 't4' ){
//                        $alarm_t++;
//                    }elseif($value->alarm_type == 'Ia' || $value->alarm_type == 'Ib' || $value->alarm_type == 'Ic' ){
//                        $alarm_I++;
//                    }
//                    if(!in_array($value->company_id,$alarm_coms)){
//                        $alarm_company++;
//                        $alarm_coms[] = $value->company_id;
//                    }
//                }
//            }
//            $is_log = AlarmStatistics::where('day',date('Y-m-d',$start))->first();
//            if($is_log){
//                return redirect(url()->previous())->with('message', '已经存在数据统计,无法继续')->with('type','danger')->withInput();
//            }
//            $alarm_statistics = new AlarmStatistics();
//            $alarm_statistics->day = date('Y-m-d',$start);
//            $alarm_statistics->alarm_count = $alarmCount;
//            $alarm_statistics->alarm_company = $alarm_company;
//            $alarm_statistics->alarm_I = $alarm_I;
//            $alarm_statistics->alarm_t = $alarm_t;
//            $alarm_statistics->alarm_Il = $alarm_Il;
//
//            if($alarm_statistics->save()){
//                return redirect(url()->previous())->with('message', '统计成功')->with('type','success')->withInput();
//            }


            $data = AlarmStatistics::All();
            $datas='';
            return view('admin/sys_baojing')->with('data',$data)->with('datas',$datas);


        }
        public function jingbaoRun(){
            $end = strtotime(date("Y-m-d"),time());
            $start = $end-86400;
            $data = array();
            //昨天所有警报次数
            $alarm =Alarm::where('last_update_time','<=',$end)->where('alarm_time','>=',$start)->get();
            $alarmCount = 0;
            $alarm_Il = 0;
            $alarm_t = 0;
            $alarm_I = 0;
            $alarm_coms = array();
            $alarm_company = 0;
            foreach ($alarm as $value){
                if(($value->last_update_time - $value->alarm_time) >= 300 ){
                    $alarmCount++;
                    if($value->alarm_type == 'Il1'){
                        $alarm_Il++;
                    }elseif($value->alarm_type == 't1' ||$value->alarm_type == 't2' ||$value->alarm_type == 't3' ||$value->alarm_type == 't4' ){
                        $alarm_t++;
                    }elseif($value->alarm_type == 'Ia' || $value->alarm_type == 'Ib' || $value->alarm_type == 'Ic' ){
                        $alarm_I++;
                    }
                    if(!in_array($value->company_id,$alarm_coms)){
                        $alarm_company++;
                        $alarm_coms[] = $value->company_id;
                    }
                }
            }
            $is_log = AlarmStatistics::where('day',date('Y-m-d',$start))->first();
            if($is_log){
                return redirect(url()->previous())->with('message', '已经存在数据统计,无法继续')->with('type','danger')->withInput();
            }
            $alarm_statistics = new AlarmStatistics();
            $alarm_statistics->day = date('Y-m-d',$start);
            $alarm_statistics->alarm_count = $alarmCount;
            $alarm_statistics->alarm_company = $alarm_company;
            $alarm_statistics->alarm_I = $alarm_I;
            $alarm_statistics->alarm_t = $alarm_t;
            $alarm_statistics->alarm_Il = $alarm_Il;

            if($alarm_statistics->save()){
                return redirect(url()->previous())->with('message', '统计成功')->with('type','success')->withInput();
            }
        }
        public function jingbaoInfo($id){
            if($id){
                $alarmStatistics = AlarmStatistics::where('id',$id)->first();

                $time =strtotime($alarmStatistics->day);
                $alarm = Alarm::with('Company')->where('alarm_time','>=',$time)->where('last_update_time','<=',$time+86400)->get();
                $data =array();
                $datas =array();
               foreach ($alarm as $value){
                   if(($value->last_update_time - $value->alarm_time) >= 300 ){
                       $data['code'] = $value->code;
                       $data['alarm_type'] = $value->alarm_type;
                       $data['alarm_value'] = $value->alarm_value;
                       $data['alarm_time'] = date('Y-m-d H:i:s',$value->alarm_time);
                       $data['last_update_time'] = date('Y-m-d H:i:s',$value->last_update_time);
                       $data['alarm_chixu'] = ($value->last_update_time - $value->alarm_time)/60;
                       $data['company_name'] = $value->Company->name;
                       $data['limit_val'] = $value->limit_val;
                        $datas[] = $data;
                   }
               }
                $str = '';
                foreach ($datas as $vv){
                    $str .=
                            '<tr>'.
                            '<td>'.$vv['code'].'</td>'.
                            '<td>'.$vv['alarm_type'].'</td>'.
                            '<td>'.$vv['alarm_value'].'</td>'.
                            '<td>'.$vv['alarm_time'].'</td>'.
                            '<td>'.$vv['last_update_time'].'</td>'.
                            '<td>'.$vv['alarm_chixu'].'分钟'.'</td>'.
                            '<td>'.$vv['company_name'].'</td>'.
                            '<td>'.$vv['limit_val'].'</td>'.
                            '</tr>';


                }
                return $str;
            }


        }
}
