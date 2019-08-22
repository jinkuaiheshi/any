<?php

namespace App\Http\Controllers\Admin;

use App\Admin\City;
use App\Admin\Company;
use App\Admin\Smoke;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SmokeController extends CommonController
{
    //
    public function index(){
        $islogin = session('islogin');
        if($islogin->type == 1){
            $data = Smoke::All();
        }
        return view('admin/smoke')->with('data',$data);
    }
    public function dianliang(){
        $ch = curl_init();//初始化curlhttp://api.heclouds.com/devices/528079844/datapoints? datastream_id=3200_0_5503
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/528079844/datapoints?datastream_id=3200_0_5501');//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //curl_setopt($ch, CURLOPT_POSTFIELDS, '528079844');
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $dianliang = array();
        foreach (json_decode($data)->data->datastreams as $v){
            $dianliang['time'] = $v->datapoints['0']->at;
            $dianliang['value'] = $v->datapoints['0']->value;
        }

        return redirect(url()->previous())->with('dianliang',$dianliang)->withInput();
    }
    public function yanwu(){
        $ch = curl_init();//初始化curlhttp://api.heclouds.com/devices/528079844/datapoints? datastream_id=3200_0_5503
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/528079844/datapoints?datastream_id=3200_0_5503');//抓取指定网页
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
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/528079844/datapoints?datastream_id=3200_0_5503&start='.$start.'&end='.$end);//抓取指定网页
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
    public function nongdu(){
        $ch = curl_init();//初始化curlhttp://api.heclouds.com/devices/528079844/datapoints? datastream_id=3200_0_5503
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/528079844/datapoints?datastream_id=3200_0_5504');//抓取指定网页
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
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/528079844/datapoints?datastream_id=3200_0_5504&start='.$start.'&end='.$end);//抓取指定网页
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
    public function mute(){
        $ch = curl_init();//初始化curlhttp://api.heclouds.com/devices/528079844/datapoints? datastream_id=3200_0_5503
        curl_setopt($ch, CURLOPT_URL,'http://api.heclouds.com/devices/528079844/datapoints?datastream_id=3200_0_5505');//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER ,array('api-key:BtlWp3lrdfRJ7cggnoAd7Tp2c=A='));//这里要用自己的api-key 我用###########把自己的隐藏掉了
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //curl_setopt($ch, CURLOPT_POSTFIELDS, '528079844');
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        dd($data);
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
            


        }
        return view('admin/new_smoke')->with('data',$data)->with('company',$company)->with('map1',\GuzzleHttp\json_encode($tmps));
    }
}
