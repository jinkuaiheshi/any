<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/admin/smoke/http','Admin\SmokeController@http');//赛特维尔烟感
Route::any('/admin/login','Admin\AdminController@login' );
Route::get('/admin/logout','Admin\AdminController@logout' );

Route::any('/admin/forget','Admin\AdminController@forget' );
Route::group(['middleware'=>['web','Admin']],function() {
    Route::any('/admin/index','Admin\AdminController@index' );

    //系统主页
    Route::get('/admin/dashboard','Admin\SysController@dashboard' );//系统主页

    Route::get('/admin/usage','Admin\SysController@usage' );//套餐

    Route::get('/admin/alarm','Admin\SysController@alarm' );//报警详情

    Route::get('/admin/baiteng/up','Admin\SysController@baitengUp' );//佰腾数据同步

    Route::get('/admin/jingbao','Admin\SysController@jingbao' );
    Route::post('/admin/jingbao/info/{id}','Admin\SysController@jingbaoInfo' );
    Route::get('/admin/jingbaoRun','Admin\SysController@jingbaoRun');


    Route::get('/admin/lot','Admin\TerminalController@lot');//曼顿末端
    Route::get('/admin/map','Admin\TerminalController@map');//曼顿末端

    Route::get('/admin/alarm','Admin\TerminalController@alarmLog');//告警数据导入



    Route::get('/admin/smoke','Admin\SmokeController@index');//赛特维尔烟感
    Route::get('/admin/smoke/dianliang/{cid}','Admin\SmokeController@dianliang');//赛特维尔烟感
    Route::get('/admin/smoke/yanwu/{cid}','Admin\SmokeController@yanwu');//赛特维尔烟感
    Route::get('/admin/smoke/nongdu/{cid}','Admin\SmokeController@nongdu');//赛特维尔烟感
    Route::get('/admin/smoke/mute/{cid}','Admin\SmokeController@mute');//赛特维尔烟感
    Route::post('/admin/smoke/add','Admin\SmokeController@add');//赛特维尔烟感

    Route::get('/admin/new/smoke','Admin\SmokeController@smoke');//赛特维尔烟感


    //运营中心
    Route::get('/admin/operation/alarmlist','Admin\OperationController@alarmlist' );//报警详情
    Route::post('/admin/ajax/getCity/{province}','Admin\OperationController@getCity');
    Route::post('/admin/ajax/getArea/{city}','Admin\OperationController@getArea');
    Route::post('/admin/ajax/getStreet/{area}','Admin\OperationController@getStreet');
    Route::get('/admin/yyyy','Admin\OperationController@yyyy');
    Route::get('/admin/zzz','Admin\OperationController@zzz');//脚本返回地址所属街道

    //系统设置
    Route::any('/admin/sys/company','Admin\SysController@company');//企业管理
    Route::post('/admin/ajax/getCompanyInfo/{id}','Admin\SysController@getCompanyInfo');//企业管理
    Route::get('/admin/sys/company/edit/{id}','Admin\SysController@companyEdit');//企业管理
    Route::post('/admin/sys/company/up','Admin\SysController@companyUp');//企业管理
    Route::any('/admin/sys/company/add','Admin\SysController@companyAdd');//企业管理
    Route::any('/admin/sys/company/setMonitor/{id}','Admin\SysController@setMonitor');//监控点设置

    Route::any('/admin/sys/provider','Admin\SysController@provider');//服务商管理
    Route::post('/admin/ajax/setProvider/{type}','Admin\SysController@setProvider');
    Route::post('/admin/sys/provider/superior/up','Admin\SysController@superior');//服务商管理
    Route::get('/admin/sys/provider/del/{id}','Admin\SysController@superior_del');//服务商管理
    Route::get('/admin/sys/provider/subordinate/{id}','Admin\SysController@superior_subordinate');//服务商管理
    Route::any('/admin/sys/user/auth','Admin\SysController@user_auth');//用户级别管理
    Route::post('/admin/sys/user/auth/add','Admin\SysController@user_auth_add');//用户级别管理
    Route::get('/admin/sys/user/auth/del/{id}','Admin\SysController@user_auth_del');//用户级别管理
    Route::post('/admin/ajax/getUserType/{id}','Admin\SysController@getUserType');
    Route::post('/admin/sys/user/auth/up','Admin\SysController@user_auth_up');//用户级别管理
    Route::get('/admin/sys/province','Admin\SysController@province');//全国地区管理
    Route::get('/admin/sys/city/{id}','Admin\SysController@city');//全国地区管理
    Route::get('/admin/sys/area/{id}','Admin\SysController@area');//全国地区管理
    Route::get('/admin/sys/street/{id}','Admin\SysController@street');//全国地区管理
    Route::post('/admin/sub/phone','Admin\SysController@phone');
    Route::post('/admin/sub/taocan','Admin\SysController@taocan');


    //佰腾产品
    Route::get('/admin/baiteng/index','Admin\BaiTengController@index');//佰腾产品
    Route::get('/admin/baiteng/get_agent_cust_list','Admin\BaiTengController@get_agent_cust_list');//佰腾产品
    Route::get('/admin/baiteng/monitor','Admin\BaiTengController@monitor');//佰腾产品
    Route::get('/admin/baiteng/alarm_info/{ID}','Admin\BaiTengController@alarm_info');//报警日志
    Route::get('/admin/baiteng/reset/{ID}','Admin\BaiTengController@reset');//复位
    Route::get('/admin/baiteng/customer_info/{ID}','Admin\BaiTengController@customer_info');//设备一览
    Route::post('/admin/ajax/getMonitorDianling/{ID}','Admin\BaiTengController@getMonitorDianling');//电量

    //Route::get('/admin/ccc','Admin\SysController@ccc');//脚本写入街道信息
    Route::get('/admin/jjj','Admin\SysController@jjj');//脚本返回地址所属街道
    Route::get('/admin/jjj','Admin\SysController@jjj');//脚本返回地址所属街道
    //Route::get('admin/sys/provider','Admin\SysController@ddd');//测试


    Route::get('/admin/monitor/bt','Admin\BaiTengController@bt');//佰腾产品列表
    Route::get('/admin/monitor/v1','Admin\BaiTengController@v1');//佰腾产品列表



   // Route::get('/admin/msd','Admin\SysController@msd');//脚本返回地址所属街道
    Route::get('/admin/terminal','Admin\TerminalController@index');//佳岚末端
    Route::get('/admin/duilie','Admin\TerminalController@duilie');//佳岚末端
    Route::post('/admin/ajax/getTerminalInfo/{ID}','Admin\TerminalController@getTerminalInfo');//获取详细信息
    Route::post('/admin/ajax/getTerminalPower/{ID}','Admin\TerminalController@getTerminalPower');//获取详细信息
    Route::post('/admin/ajax/getTerminalLeakage/{ID}','Admin\TerminalController@getTerminalLeakage');//获取详细信息
    Route::post('/admin/ajax/getTerminalStatus/{ID}','Admin\TerminalController@getTerminalStatus');//获取详细信息
    Route::post('/admin/ajax/getTerminalTemp/{ID}','Admin\TerminalController@getTerminalTemp');//获取详细信息

    Route::post('/admin/ajax/getTerminalShuju/{addr}','Admin\TerminalController@getTerminalShuju');//获取详细信息


    Route::get('/admin/terminal/power/{id}','Admin\TerminalController@power');//功率
    Route::get('/admin/terminal/leakage/{id}','Admin\TerminalController@leakage');//漏电
    Route::get('/admin/terminal/temp/{id}','Admin\TerminalController@temp');//漏电
    Route::post('/admin/terminal/add','Admin\TerminalController@add');//漏电
    Route::get('/admin/terminal/token','Admin\TerminalController@token');//漏电
    Route::get('/admin/terminal/info/{projectCode}','Admin\TerminalController@info');//曼顿
    Route::get('/admin/terminal/shishi/{mac}/{projectCode}','Admin\TerminalController@getTerminalShishi');//获取实时数据
    Route::get('/admin/terminal/alarm/{mac}/{projectCode}','Admin\TerminalController@alarm');//获取告警数据
    Route::get('/admin/terminal/electric/{mac}/{projectCode}','Admin\TerminalController@electric');//获取告警数据
    Route::get('/admin/terminal/voltage/{mac}/{projectCode}','Admin\TerminalController@voltage');//获取告警数据
    Route::get('/admin/terminal/galvanic/{mac}/{projectCode}','Admin\TerminalController@galvanic');//获取告警数据
    Route::get('/admin/terminal/leakage/{mac}/{projectCode}','Admin\TerminalController@leakages');//获取告警数据
    Route::get('/admin/terminal/temperature/{mac}/{projectCode}','Admin\TerminalController@temperature');//获取告警数据
    Route::get('/admin/terminal/temperature/{mac}/{projectCode}','Admin\TerminalController@temperature');//漏电自保

    //电量
    Route::post('/admin/terminal/electric/year','Admin\TerminalController@electric_year');//获取告警数据
    Route::post('/admin/terminal/electric/month','Admin\TerminalController@electric_month');//获取告警数据
    Route::post('/admin/terminal/electric/day','Admin\TerminalController@electric_day');//获取告警数据
    //平均电压
    Route::post('/admin/terminal/voltage/year','Admin\TerminalController@voltage_year');//获取告警数据
    Route::post('/admin/terminal/voltage/month','Admin\TerminalController@voltage_month');//获取告警数据
    Route::post('/admin/terminal/voltage/day','Admin\TerminalController@voltage_day');//获取告警数据

    //平均电流
    Route::post('/admin/terminal/galvanic/month','Admin\TerminalController@galvanic_month');//获取告警数据
    Route::post('/admin/terminal/galvanic/day','Admin\TerminalController@galvanic_day');//获取告警数据
    //漏电
    Route::post('/admin/terminal/leakages/month','Admin\TerminalController@leakages_month');//获取告警数据
    Route::post('/admin/terminal/leakages/day','Admin\TerminalController@leakages_day');//获取告警数据
    //Route::get('/admin/terminal/leakage/{mac}/{projectCode}','Admin\TerminalController@leakages');//获取告警数据
    //温度值
    Route::post('/admin/terminal/temperature/month','Admin\TerminalController@temperature_month');//获取告警数据
    Route::post('/admin/terminal/temperature/day','Admin\TerminalController@temperature_day');//获取告警数据

    //用户管理
    Route::any('/admin/terminal/company/add','Admin\TerminalController@companyAdd');
    Route::get('/admin/terminal/user','Admin\TerminalController@user');
    Route::post('/admin/terminal/band','Admin\TerminalController@band');//公司绑定设备

    Route::get('/admin/terminal/ningbo','Admin\TerminalController@ningbo');//
    Route::get('/admin/terminal/yuhuan','Admin\TerminalController@yuhuan');//
    Route::get('/admin/terminal/wuxi','Admin\TerminalController@wuxi');//

});