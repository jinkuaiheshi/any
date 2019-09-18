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
        <ul id="shownav" class="nav navbar-nav collapse navbar-collapse">

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
                    </ul>
                </li>
            </ul>
        </div>
        <!--右侧内容-->
        <div class="rightContent1">
            <div class="rightContentTop clearfix">
                <div class="rightNav clearfix">
                    <ul>
                        <li>
                            <a href="{{url('admin/index')}}" class="active">首页</a>
                            <span class="grayColor">&nbsp;/&nbsp;</span>
                        </li>

                        <li>
                            <a href="jacascript::void(0)" class="whiteColor">设备详情</a>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="rightBottom">
                <div class="rightBottomBox">
                    <div class="rightEchart clearfix">
                        <div class="rightChartBox">
                            <!--tab切换echart-->
                            <div id="wrap">
                                <div id="tit">
                                    <span class="select">设备状态折线图</span>
                                </div>
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
                        <div class="leftChartBox">
                            <div id="wrap1">
                                <div id="tit1">
                                    <span class="select1">烟雾浓度折线图</span>
                                </div>
                                <ul id="con1">
                                    <li class="show1 tabContent1">
                                        <div id="barEchart2" class="chart-block1" style="height:280px;"></div>
                                    </li>
                                    <!-- <li class="tabContent1">
                                        <div id="pieEchart2" class="chart-block1" style="height:280px;"></div>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="rightTable">
                        <div class="tableBody">
                            <table class="table table-bordered " style="margin: 8px 0 0 0;table-layout:fixed">
                                <thead>
                                <tr>
                                    <th>公司名称</th>
                                    <th>设备号</th>
                                    <th>报警类型</th>
                                    <th>报警时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($log as $value)
                                <tr>
                                    <td>{{$value->Company->name}}</td>
                                    <td>{{$value->Smoke->IMEI}}</td>
                                    <td>@if($value->status == 1)烟雾报警@elseif($value->status == 10)拆卸报警@elseif($value->status == 4)低压@elseif($value->status == 5)传感器故障@elseif($value->status == 14)测试键在正常状态按下@elseif($value->status == 15)测试键在低压状态按下
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
    <!--修改密码的弹窗-->

</div>

<script src="{{asset('resources/assets/smoke/js/jquery-3.4.1.min.js')}}"></script>
<!-- 包括所有已编译的插件 -->

<script src="{{asset('resources/assets/smoke/js/bootstrap.min.js')}}"></script>
<!--引入echart-->

<script src="{{asset('resources/assets/smoke/js/echarts.js')}}"></script>
<!--日历-->

<script src="{{asset('resources/assets/smoke/laydate/laydate.js')}}"></script>
<!--radio美化-->

<script src="{{asset('resources/assets/smoke/js/jquery.richUI.min.js')}}"></script>

<script src="{{asset('resources/assets/smoke/js/jquery.browser.min.js')}}"></script>
<script>
    $(function () {
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
        //*****************************修改密码************************

        // 导出功能



        //echart Tab切换
        // 左侧tab
        // $('#tit span').click(function () {
        // 	var i = $(this).index(); //下标第一种写法
        // 	$(this).addClass('select').siblings().removeClass('select');
        // 	$('#con li').eq(i).addClass('show').siblings().removeClass('show');
        // });
        // 右侧tab
        // $('#tit1 span').click(function () {
        // 	var index = $(this).index(); //下标第一种写法
        // 	$(this).addClass('select1').siblings().removeClass('select1');
        // 	$('#con1 li').eq(index).addClass('show1').siblings().removeClass('show1');
        // });
        // 用电报警柱状图
        //echart
        $('.chart-block').css('width', $('.tabContent').width());
        $('.chart-block1').css('width', $('.tabContent1').width());
        var barEchart1 = echarts.init($('#barEchart1').get(0));
        var barEchart2 = echarts.init($('#barEchart2').get(0));
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
                axisLine: {
                    lineStyle: {
                        color: '#797979'
                    }
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
        var option1 = {
            title: {
                text: ''
            },
            color: ["#0000ff"],
            tooltip: {
                trigger: 'axis',
                formatter: "{b}: {c}"
            },
            grid: {
                left: 30,
                right: 10,
                width: '86%',
                height: '70%'
            },
            xAxis: {
                name: '单位',
                data: {!! $time2 !!},
                axisLine: {
                    lineStyle: {
                        color: '#797979'
                    }
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
                nameGap: 8
            },
            series: [{
                name: '报警预警数量',
                type: 'line',
                lineStyle: {
                    color: '#0000ff'
                },
                data: {!! $nongdu !!}
            }]

        };

        barEchart1.setOption(option);
        barEchart2.setOption(option1);
        // pieEchart1.setOption(option3);
        // pieEchart2.setOption(option4);
        window.addEventListener("resize", () => {
            barEchart1.resize();
            barEchart2.resize();
            // pieEchart1.setOption(option3);
            // pieEchart2.setOption(option4);
        });
        //用电预警柱状图
        //用电报警圆环
        //用电预警圆环
        //表格分页

    });
</script>
</body>

</html>
@stop