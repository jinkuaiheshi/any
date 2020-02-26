<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZhihuichengshiController extends CommonController
{
  public function index(){
     $token =  $this->getZhihui_Token();
     dd($token);
     $data = array();
      $data['detectorName']= 'dhy';
      $data['mainframeId']= '100';
      $data['orgId']= '100';

      $param=['token'=>$token,'timeStamp'=>time(),'type'=>0,'data'=>$data];
      $url='report/detector';
      $post_url='http://211.91.56.3:8100/IFCSI/'.$url;
      $o = "";

      foreach ( $param as $k => $v )
      {
          $o.= "$k=" . urlencode( $v ). "&" ;
      }
      $param = substr($o,0,-1);

      $ch = curl_init();//初始化curl
      curl_setopt($ch, CURLOPT_URL,$post_url);//抓取指定网页
      curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
      curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
      curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
      //https请求需要加上此行
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
      $res = curl_exec($ch);//运行curl
  }
}
