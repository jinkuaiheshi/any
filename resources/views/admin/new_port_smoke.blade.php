@extends('admin.somke_header')
@section('content')
    <!-- DataTables CSS -->


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
                        <div class="rightEchart clearfix">
                            <div class="rightChartBox" style="width: 100%;">
                                <!--tab切换echart-->
                                <div id="wrap">

                                    <ul id="con">
                                        <li class="show tabContent">
                                            <div id="barEchart1" class="chart-block" style="height:280px;"></div>
                                        </li>
                                        <!-- <li class="tabContent">
                                            <div id="barEchart2" class="chart-block" style="height:280px;"></div>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>

                        </div>
                            <div class="rightTable">
                                <div class="tableBody">
                                    <table class="table table-bordered " style="margin: 8px 0 0 0;table-layout:fixed" id="tab">
                                        <thead>
                                        <tr>
                                            <th>公司名称</th>
                                            <th>设备号</th>
                                            <th>报警类型</th>
                                            <th>时间</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($log as $value)
                                            <tr>
                                                <td>{{$value->Company->name}}</td>
                                                <td>{{$value->Smoke->name}}({{$value->Smoke->IMEI}})</td>
                                                <td>@if($value->status == 1)烟雾报警@elseif($value->status == 10)拆卸报警@elseif($value->status == 4)低压@elseif($value->status == 5)传感器故障@elseif($value->status == 14)测试键在正常状态按下@elseif($value->status == 15)测试键在低压状态按下@elseif($value->status == 7)正常@elseif($value->status == 2)设备静音@elseif($value->status == 8)指示模块已接收平台下发单次静音指令@elseif($value->status == 9)指示模块已接收平台下发连续静音指令@elseif($value->status == 11)拆卸恢复
                                                    @endif
                                                </td>
                                                <td>{{$value->time}}</td>
                                            </tr>
                                        @endforeach




                                        </tbody>


                                    </table>

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
            // 右侧内容盒子的宽度
            var winHeight = $(window).height();
            $('.bottomContent').height(winHeight - 50);
            $('.rightBottom').height(winHeight - 128);
            $('.rightBottomBox').height(winHeight - 128);

            // 用电报警柱状图
            //echart
            $('.chart-block').css('width', $('.tabContent').width());

            var barEchart1 = echarts.init($('#barEchart1').get(0));

            // var pieEchart1 = echarts.init($('#pieEchart1').get(0));
            // var pieEchart2 = echarts.init($('#pieEchart2').get(0));
            var option = {
                title: {
                    text: ''
                },
                color: ["#ff0000"],
                tooltip: {
                    trigger: 'axis',
                    formatter: "{b}:{c}"
                },

                grid: {
                    left: 30,
                    right: 10,
                    width: '86%',
                    height: '70%'
                },
                xAxis: {
                    name: '单位',
                    data: {!! $time !!},
                    show:false,

                    axisLine: {
                        lineStyle: {
                            color: '#797979'
                        },

                    },

                    // axisTick: {
                    // 	alignWithLabel: true
                    // },
                    axisLabel: {
                        interval: 0,
                        textStyle: {
                            color: 'rgb(0,0,0)'
                        }
                    }
                },
                yAxis: {
                    name: '单位',
                    axisLine: {
                        lineStyle: {
                            color: '#797979'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: '#dcdcdc'
                        }
                    },
                    //                    name:this.yAxisName,
                    nameGap: 8
                },
                series: [{
                    name: '报警预警数量',
                    type: 'line',
                    data: {!! $zhuangtai !!}
                }]
            };


            barEchart1.setOption(option);

            // pieEchart1.setOption(option3);
            // pieEchart2.setOption(option4);
            window.addEventListener("resize", () => {
                barEchart1.resize();
                barEchart2.resize();
                // pieEchart1.setOption(option3);
                // pieEchart2.setOption(option4);
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
    <script>
        $(function () {


            $('#tab').DataTable();

        })
    </script>
    </body>

    </html>
@stop