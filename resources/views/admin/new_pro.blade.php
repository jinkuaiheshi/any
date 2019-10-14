@extends('admin.somke_header')
@section('content')

<body>
<div class="home">
    <!--响应式导航-->
    <div class="navbar navbar-default topNav">
        <div class="navbar-header">
            <div class="navLogo">
                <div class="img"><a href="{{url('/admin/index')}}"><img src="{{asset('resources/assets/smoke/images/logo.png')}}" alt="" /></a></div>
                <div class="titleLogo">智慧式用电安全监管与电能管理平台</div>
            </div>
        </div>
        <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/toastr/toastr.min.js')}}"></script>
        <ul id="shownav" class="nav navbar-nav collapse navbar-collapse">
            {{--<li>--}}
                {{--<div class="noiceIcon"></div>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="#" class="mainFontColor">--}}
                    {{--<div>报警</div>--}}
                    {{--<div class="flexDiv infoNumber"></div>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a class="dropdown" data-toggle="dropdown" href="">安云智联<span class="caret"></span></a>--}}
                {{--<ul class="dropdown-menu">--}}
                    {{--<li>--}}
                        {{--<a href="./index.html" class="mainFontColor">管理平台</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="./record.html" class="mainFontColor">操作日志</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="#" class="mainFontColor" data-toggle="modal" data-target="#myModal">修改密码</a>--}}
            {{--</li>--}}
            <li>
                <a href="{{url('/admin/logout')}}" class="mainFontColor">退出</a>
            </li>
        </ul>
        <!--</div>-->
    </div>
    <div class="bottomContent clearfix">
        <!--侧边栏-->
        <div class="slidContain">
            <ul>

                <li class="nav-item">
                    <a href="#"><i class="my-icon nav-icon icon_2"></i><span>智慧能源管理</span><i
                                class="my-icon nav-more"></i></a>
                    <ul>
                        <!-- <li>
                                <a href="./power.html"><span>电量</span></a>
                            </li>
                            <li>
                                <a href="./load.html"><span>负载</span></a>
                            </li>
                            <li>
                                <a href="./control.html"><span>综合管理</span></a>
                            </li> -->
                        <li>
                            <a href="{{url('admin/new/smoke/login').'/'.$company_id}}"><span>项目列表</span></a>
                        </li>
                        <li>
                            <a href="{{url('admin/new/smoke/week').'/'.$company_id}}"><span>设备周报</span></a>
                        </li>
                        <li>
                            <a href="{{url('admin/new/smoke/month').'/'.$company_id}}"><span>设备月报</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="rightContentBox">
            <div class="rightContent">
                <div class="listNav clearfix">
                    <ul>
                        <li class="fl">
                            <a href="{{url('admin/index')}}" class="active">首页</a>
                            <span class="grayColor">&nbsp;/&nbsp;</span>
                        </li>

                        <li class="fl">
                            <a href="{{url('admin/new/pro')}}" class="whiteColor">设备列表</a>
                        </li>
                    </ul>
                </div>
                <div class="list clearfix marginBtm15">

                    <div class="listProject clearfix">
                        <ul>
                            @foreach($smoke as $value)
                            <a href="{{url('admin/smoke/info/'.$value['cid'])}}">
                                <li class="fl">
                                    <div class="top clearfix">
                                        <div class="fl"><i class="backImg"></i>&nbsp;
                                            <div class="floor">{{$value['name']}}({{$value['IMEI']}})</div>
                                        </div>
                                        <div class="btnDetail fl"><i class="backImg1 fl"></i><span
                                                    class="fl">详情</span>
                                        </div>
                                    </div>
                                    <div class="center clearfix">
                                        <div class="img fl"><img src="@if($value['status']==7||$value['status']==11){{asset('resources/assets/smoke/images/smile.png')}}
@else{{asset('resources/assets/smoke/images/alerm.png')}}@endif

 " alt="" /></div>
                                        <div class="centerTitle
                                        @if($value['status']==1)
                                                redColor
@endif
                                        @if($value['status']==7)
                                                greenColor
@endif
                                        @if($value['status']==4)
                                                redColor
@endif
                                        @if($value['status']==5)
                                                redColor
@endif
                                        @if($value['status']==10)
                                                redColor
@endif
                                        @if($value['status']==11)
                                                greenColor
@endif
                                        @if($value['status']==14)
                                                redColor
@endif
                                        @if($value['status']==15)
                                                redColor
@endif
                                                 fl">
                                            @if($value['status']==2)
                                                设备静音
                                            @endif
                                            @if($value['status']==1)
                                                烟雾报警
                                            @endif
                                            @if($value['status']==7)
                                                正常
                                            @endif

                                            @if($value['status']==4)
                                                低压
                                            @endif
                                            @if($value['status']==5)
                                                传感器故障
                                            @endif
                                            @if($value['status']==10)
                                                拆卸报警
                                            @endif
                                            @if($value['status']==11)拆卸修复@endif
                                            @if($value['status']==14)
                                                    测试键在正常状态按下
                                            @endif
                                            @if($value['status']==15)
                                                    测试键在低压状态按下
                                            @endif</div>
                                    </div>
                                    <div class="time">{{$value['time']}}</div>
                                </li>
                            </a>
                            @endforeach



                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<script src="{{asset('resources/assets/smoke/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('resources/assets/smoke/js/bootstrap.min.js')}}"></script>

<script>
    $(function () {
        // nav收缩展开
        $('.nav-item>a').on('click', function () {
            if ($(this).next().css('display') == "none") {
                //展开未展开
                $('.nav-item').children('ul').slideUp(300);
                $(this).next('ul').slideDown(300);
                $(this).parent('li').addClass('nav-show').siblings('li').removeClass('nav-show');
            } else {
                //收缩已展开
                $(this).next('ul').slideUp(300);
                $('.nav-item.nav-show').removeClass('nav-show');
            }
        });
        // 右侧内容盒子的宽度
        var winHeight = $(window).height();
        $('.bottomContent').height(winHeight - 50);
        $('.rightBottom').height(winHeight - 128);
        $('.rightBottomBox').height(winHeight - 128);
    });
</script>
</body>

</html>
@stop