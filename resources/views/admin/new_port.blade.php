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
                                <a href="{{url('admin/new/login').'/'.$company_id}}" class="whiteColor">设备列表</a>
                            </li>
                        </ul>
                    </div>
                    <div class="list clearfix marginBtm15">

                        <div class="listProject clearfix">
                            <div class="row">

                                <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/new/smoke/week/port')}}">
                                    {{ csrf_field() }}
                                <input type="hidden" name="company_id" value="{{$company_id}}"/>
                                    <div class="form-group h-a" style="text-align: center">
                                        <div class="col-md-4" style="text-align: right">
                                            <label for="order" class=" col-form-label " >选择周报日期：</label>
                                        </div>
                                        <div class="col-sm-1">
                                            <div   class="form-group">
                                                <select class="form-control " name = 'year' required id="year" >
                                                    <option value="2019"  selected >2019</option>
                                                    <option value="2018" >2018</option>
                                                    <option value="2018" >2017</option>
                                                    <option value="2018" >2016</option>
                                                    <option value="2018" >2015</option>


                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div   class="form-group">
                                                <select class="form-control " name = 'month' required id="month" >
                                                    <option value="01" @if(date('m') < 1) disabled @endif >一月</option>
                                                    <option value="02" @if(date('m') < 2) disabled @endif >二月</option>
                                                    <option value="03" @if(date('m') < 3) disabled @endif>三月</option>
                                                    <option value="04" @if(date('m') < 4) disabled @endif>四月</option>
                                                    <option value="05" @if(date('m') < 5) disabled @endif >五月</option>
                                                    <option value="06" @if(date('m') < 6) disabled @endif >六月</option>
                                                    <option value="07" @if(date('m') < 7) disabled @endif  >七月</option>
                                                    <option value="08"  @if(date('m') < 8) disabled @endif>八月</option>
                                                    <option value="09" @if(date('m') < 9) disabled @endif>九月</option>
                                                    <option value="10" @if(date('m') < 10) disabled @endif >十月</option>
                                                    <option value="11"  @if(date('m') < 11) disabled @endif >十一月</option>
                                                    <option value="12" @if(date('m') < 12) disabled @endif >十二月</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <select class="form-control m-b-1" name="week" id="week">
                                                <option value="0">请选择</option>

                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <button type="submit" class="btn btn-primary">查询报表</button>
                                        </div>

                                    </div>
                                </form>
                                <script type="text/javascript">
                                    $('.mydatepicker').datepicker({
                                        format: "yyyy-mm",
                                        minView:'month',
                                        language: 'zh-CN',
                                    });

                                </script>


                            </div>
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

        });
    </script>
    <script>
        $('#month').change(function() {

            $.post("{{ url('/admin/ajax/getWeek') }}",
                {'_token': '{{ csrf_token()}}',
                    'year':$('#year').val(),
                    'month':$('#month').val(),
                }, function(data) {
                    //alert(data);
                    $('#week').html(data);
                });
        });
    </script>
    </body>

    </html>
@stop