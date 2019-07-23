<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Monitor;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BaiTengController extends CommonController
{
    //
    public function index(){
        if(empty(session('old_token')))
        {

            $this->getOldToken();
        }else{
            $this->getOldToken();
        }

        //获取完所有的json数据-----佰腾设备
        $data=$this->old_curl('electrical/detector/get_customer_list.php',['token'=>session('old_token'),'Customer'=>'Chin0','rows'=>9999]);
        $data=$data->info->rows;

        dd($data);
        return view('admin/baiteng_customer_list')->with('data',$data);

    }
    public function monitor(){
        if(empty(session('old_token')))
        {

            $this->getOldToken();
        }else{
            $this->getOldToken();
        }
        //获取完所有的json数据-----佰腾设备
        $data=$this->old_curl('electrical/detector/get_list.php',['token'=>session('old_token'),'Customer'=>'Chin0','rows'=>9999]);
        $data=$data->info->rows;
        dd($data);
        return view('admin/baiteng_monitor')->with('data',$data);
    }
    public function alarm_info($ID){
        if($ID){

            $islogin = session('islogin');

            if($islogin->type == 1){
                if(empty(session('old_token')))
                {
                    $this->getOldToken('anyun','ayzl8888');
                }
                $data=$this->old_curl('electrical/detector/get_port_log.php',['token'=>session('old_token'),'ID'=>$ID]);
                //$data=$data->info;
              //  dd($data->info->mA->Port['0']->data);
                //dd($data);
                if($data->code == '0'){
                    $health['mAtime'] =  json_encode($data->info->mA->Time); //漏电回路时间轴
                    $health['mAdata'] =  json_encode($data->info->mA->Port['0']->data); //漏电回路数据轴

                    $health['Atime'] =  json_encode($data->info->A->Time); //电流回路数据轴
                    $health['AdataA'] =  json_encode($data->info->A->Port['0']->data); //电流回路数据轴
                    $health['AdataB'] =  json_encode($data->info->A->Port['1']->data); //电流回路数据轴
                    $health['AdataC'] =  json_encode($data->info->A->Port['2']->data); //电流回路数据轴

                    $health['oCtime'] =  json_encode($data->info->oC->Time); //温度回路数据轴
                    $health['oCdataA'] =  json_encode($data->info->oC->Port['0']->data); //温度回路数据轴
                    $health['oCdataB'] =  json_encode($data->info->oC->Port['1']->data); //温度回路数据轴
                    $health['oCdataC'] =  json_encode($data->info->oC->Port['2']->data); //温度回路数据轴
                    $health['oCdataD'] =  json_encode($data->info->oC->Port['3']->data); //温度回路数据轴

                    $health['Level0'] = trim(strrchr($data->info->Level['0'],';'),';');
                    $health['Level1'] = trim(strrchr($data->info->Level['1'],';'),';');
                    $health['Level2'] = trim(strrchr($data->info->Level['2'],';'),';');
                    $health['Level3'] = trim(strrchr($data->info->Level['3'],';'),';');
                    $health['Level4'] = trim(strrchr($data->info->Level['4'],';'),';');
                    $health['Level5'] = trim(strrchr($data->info->Level['5'],';'),';');
                    $health['Level6'] = trim(strrchr($data->info->Level['6'],';'),';');
                    $health['Level7'] = trim(strrchr($data->info->Level['7'],';'),';');


                    //dd( json_encode($health['mA_time']));
                    $health['alarm'] = $data->info->grade->alarm;//报警次数
                    $health['online'] = $data->info->grade->online;//在线率
                    $health['handled'] = $data->info->grade->handled;//处理速度
                }


            }
            return view('admin/baiteng_bt_port_log')->with('data',$data)->with('health',$health);


        }
    }
    public function reset($ID){
        if($ID){
            $islogin = session('islogin');
            if($islogin->type == 1){
                if(empty(session('old_token')))
                {
                    $this->getOldToken('anyun','ayzl8888');
                }
                $data=$this->old_curl('electrical/detector/reset.php',['token'=>session('old_token'),'ID'=>$ID]);

            }else{
                $pwd = $this->think_decrypt($islogin->encrypt,'ujdu9*93j');
                if(empty(session('old_token')))
                {
                    $this->getOldToken($islogin->username,$pwd);
                    $data=$this->old_curl('electrical/detector/reset.php',['token'=>session('old_token'),'ID'=>$ID]);

                }
            }
            if($data->code == '0'){
                return redirect(url()->previous())->with('message', '设备复位成功')->with('type','success')->withInput();
            }else{
                return redirect(url()->previous())->with('message', '设备复位失败')->with('type','danger')->withInput();
            }
        }

    }
    public function get_agent_cust_list(){
        if(empty(session('old_token')))
        {

            $this->getOldToken();
        }else{
            $this->getOldToken();
        }
        //获取完所有的json数据-----佰腾设备
        $data=$this->old_curl('electrical/detector/get_list',['token'=>session('old_token'),'Customer'=>'Chin0']);
        dd($data);

        return view('admin/baiteng_customer_list')->with('data',$data);
    }
    public function getMonitorDianling($ID){
        if(empty(session('old_token')))
        {

            $this->getOldToken();
        }else{
            $this->getOldToken();
        }

        $data=$this->old_curl('electrical/detector/get_degrees_log.php',['token'=>session('old_token'),'type'=>'year','ID'=>$ID]);
        dd($data);
    }
    public function customer_info($ID){
        if($ID){
            if(empty(session('old_token')))
            {

                $this->getOldToken();
            }else{
                $this->getOldToken();
            }
            
        }
    }
    public function  bt(){
        $islogin = session('islogin');


//        $pwd = $this->think_decrypt($islogin->encrypt,'ujdu9*93j');
//        dd($pwd);
//        $this->getOldToken($islogin->username,$pwd);
//
//
//
//
//        $data=$this->old_curl('electrical/detector/get_list.php',['token'=>session('old_token'),'Customer'=>'Chin0','rows'=>9999]);
//        $data=$data->info->rows;
//        dd($data);

        if($islogin->type == 1){
            if(empty(session('old_token')))
            {
                $this->getOldToken('anyun','ayzl8888');
            }
            $data=$this->old_curl('electrical/detector/get_list.php',['token'=>session('old_token'),'Customer'=>'Chin0','rows'=>9999]);
            $data=$data->info->rows;

        }
       // dd($data);
        return view('admin/monitor_bt')->with('data',$data);
    }
    public function v1(){
        $islogin = session('islogin');
        if($islogin->type == 1){
            $data = Monitor::where('is_deleted',0)->where('code','like','E0000%')->get();
        }
        return view('admin/monitor_v1')->with('data',$data);
    }
}
