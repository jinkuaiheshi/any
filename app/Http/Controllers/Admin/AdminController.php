<?php

namespace App\Http\Controllers\Admin;

use App\Admin\User;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use Crypt;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends CommonController
{
    //
    public function login(Request $request){
        if ($request->isMethod('POST')) {
            $user = User::where('username', trim($request['username']))->first();
            if($user){
                if (Crypt::decrypt($user->suppwd) === $request['password']) {
                    //写入session

                    $user->last_login_time = date('Y-m-d H:i:s', time());

                    if($user->update()){
                        session(['islogin' => $user]);
                        return redirect('/admin/index');
                    }
                } else {
                    return redirect('/admin/login')->with('message', '密码错误，请重新输入!')->withInput();
                }
            }else {
                return redirect('/admin/login')->with('message', '用户名不存在或者密码错误')->withInput();
            }
        }else{

            return view('admin/login');
        }

    }
    public function forget()
    {
        dd(123);
    }
    public function index(){

        return view('admin/index');
    }
    public function logout(){
        //登出系统
        $islogin = session('islogin');
        if($islogin){
            session()->forget('islogin');
            return redirect('/admin/login')->with('message', '成功退出')->with('type','success')->withInput();
        }else{
            return redirect('/admin/login')->with('message', '您没有登入，无需退出')->with('type','danger');
        }
    }
}
