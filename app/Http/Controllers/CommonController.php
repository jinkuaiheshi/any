<?php

namespace App\Http\Controllers;

use App\Admin\Log;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    //

    public function log($do,$title)
    {
        $log = new Log();
        $log->controller = request()->route()->getAction()['controller'];
        $log->created_time = date('Y-m-d H:i:s', time());
        $log->user = $do;
        $log->title = $title;
        $islogin = session('islogin');
        if($islogin){
            $log->do_admin = $islogin->username;
        }else{
            $log->do_admin = '';
        }
        if (!$log->save()) {
            return redirect('/admin/index')->with('message', '日志记录失败！')->with('type','danger');
        }

    }

    public function getOldToken($name,$pwd)
    {
        if($pwd== ''){
            $pwd = '123456';
        }

        $param=['name'=>$name,'pwd'=>$pwd];
        $url='user/check_log.php';
        $post_url='https://power.btiot.com.cn/API/v1/'.$url;
        //        $param = ['token'=>$this->token,'rows'=>999,'Customer'=>'Chin0'];

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
        $data = curl_exec($ch);//运行curl

        curl_close($ch);
        $data=json_decode($data);

        $info=$data->info->token;

        session(['old_token' => $info]);

    }
    public  function old_curl($url,$param)
    {
        $post_url='https://power.btiot.com.cn/API/v1/'.$url;
        //        $param = ['token'=>$this->token,'rows'=>999,'Customer'=>'Chin0'];

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
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        //存入数据库
        return json_decode($data);
    }

    /**
     * 系统加密方法
     * @param string $data 要加密的字符串
     * @param string $key  加密密钥
     * @param int $expire  过期时间 单位 秒
     * @return string
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
        public function think_encrypt($data, $key = '', $expire = 0) {
        $key  = md5($key);
        $data = base64_encode($data);
        $x    = 0;
        $len  = strlen($data);
        $l    = strlen($key);
        $char = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        $str = sprintf('%010d', $expire ? $expire + time():0);

        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
        }
        return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
    }

    /**
     * 系统解密方法
     * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
     * @param  string $key  加密密钥
     * @return string
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public  function think_decrypt($data, $key = ''){
        $key    = md5($key);
        $data   = str_replace(array('-','_'),array('+','/'),$data);
        $mod4   = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        $data   = base64_decode($data);
        $expire = substr($data,0,10);
        $data   = substr($data,10);

        if($expire > 0 && $expire < time()) {
            return '';
        }
        $x      = 0;
        $len    = strlen($data);
        $l      = strlen($key);
        $char   = $str = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }else{
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return base64_decode($str);
    }
    public function mandunToken(){
        $APP_KEY = 'O000002093';
        $APP_SECRET = '7B814218CC2A3EED32BD571059D58B2B';
        $post_url='https://open.snd02.com/oauth/authverify2.as';
        $redirect_uri = 'http://open.snd02.com/demo.jsp';
        //        $param = ['token'=>$this->token,'rows'=>999,'Customer'=>'Chin0'];
        $param = $param = ['response_type'=>'code','client_id'=>$APP_KEY,'redirect_uri'=>$redirect_uri,'uname'=>'ayzl01','passwd'=>'Ayzl888.com'];
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
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        $code = json_decode($data)->code;
        //code已经获得 揭下来获取access token
        $url = 'https://open.snd02.com/oauth/token.as';

        $client_secret = md5($APP_KEY.'authorization_code'.$redirect_uri.$code.$APP_SECRET);


        $param = $param = ['client_secret'=>$client_secret,'client_id'=>$APP_KEY,'grant_type'=>'authorization_code','redirect_uri'=>$redirect_uri,'code'=>$code];
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

        //  session(['accessToken' => json_decode($data)->data->accessToken]);
        //$accessToken = session('accessToken',);

        return $data;
    }
    public function GET_PROJECTS(){
        $token = mandunToken();
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
        return $data;
    }
    function think_filter(&$value){
        // TODO 其他安全过滤

        // 过滤查询特殊字符
        if(preg_match('/^(EXP|NEQ|GT|EGT|LT|ELT|OR|XOR|LIKE|NOTLIKE|NOT BETWEEN|NOTBETWEEN|BETWEEN|NOTIN|NOT IN|IN)$/i',$value)){
            $value .= ' ';
        }
    }
}
