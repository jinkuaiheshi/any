<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>智慧用电安全监管服务平台</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="{{asset('resources/assets/lot/css/bigData.css')}}" />
    <style>
        .dataLayout {
            position: relative;

        }

        #pieChart {
            height: 218px;
            width: 100%;
        }

        #barChart {
            height: 204px;
            width: 100%;
        }

        #lineChart {
            height: 198px;
            width: 100%;
        }
    </style>
</head>

<body style="width: 100%;height: auto; /*overflow: hidden;*/">
<div class="dataLayout">
    <div class="dataTextLogo">
        <a href="{{url('admin/map')}}" style="color: #fff;text-decoration: none;" >智慧用电安全监管服务平台</a>
    </div>
    <div class="day">
        <span class="date" id="date"></span>
        <span class="time" id="time"></span>
    </div>
    <div class="currentUser">
        当前登录用户：<span class="currentUserSpan">@if($userinfo->type == 1)
                超级管理员
            @elseif($userinfo->type == 2)
                服务商
            @else
                企业
            @endif
        </span>
    </div>
    @if($userinfo->type == 1)
        <div class="dataTotal">
            <!--总接入企业和 总监控点-->
            <div class="demo-detail">
                <span class="value" id="totalCompany"> {{$sum}} <small>家</small></span>
                <span class="name"> 总接入企业 </span>
            </div>
            <hr class="row-hr" />
            <div class="demo-detail">
                <span class="value" id="totalMonitor"> {{$mac}} <small>组</small></span>
                <span class="name"> 总监控组 </span>
            </div>
        </div>
@endif
<!--地图-->
    <div class="dataMap">
        <div id="mapChart"></div>
    </div>
    <!--实时告警列表-->
    <div class="alarmList">
        <div class="box-title">实时告警列表
            {{--<a class="stopBtn" id="stopSound" href="javascript:;">关闭报警声音</a>--}}
        </div>
        <table class="table1" border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr style="background-color: #2456c7;">
                <th>排序</th>
                <th>告警企业名称</th>
                <th>所在城市</th>
                <th>报警类型</th>
                <th>最新告警时间</th>
            </tr>
            </thead>
            <tbody id=" alarmList ">
            @foreach( $newAlarm as $k=>$value)
                <tr class="color-red ">
                    <td><span class="badge " style="background-color: @if($k==0)
                                #F43530
                        @elseif($k==1)
                                #ff8457
                        @elseif($k==2)
                                #ecb11c
                        @elseif($k==3)
                                #2458cd
                        @elseif($k==4)
                                #2458cd
                        @endif; ">{{$k+1}}</span></td>
                    <td>{{$value['company']}}</td>
                    <td>{{$value['city']}}</td>
                    <td>{{$value['info']}}</td>
                    <td>{{$value['time']}}</td>
                </tr>
            @endforeach



            </tbody>
        </table>
    </div>

    <div class="alarmType " style="top:100px; height: 328px;">
        <div class="box-title ">告警分类</div>
        <div class="no-data " >暂无数据</div>
        <div id="pieChart" style="height: 294px;"></div>
    </div>
    <div class="breakWg ">
        <div class="box-title ">网关状态</div>
        <div class="no-data ">暂无数据</div>
        <div id="barChart"></div>
    </div>
    {{--<div class="accessNum ">--}}
        {{--<div class="box-title ">用户接入</div>--}}
        {{--<div class="no-data ">暂无数据</div>--}}
        {{--<div id="lineChart"></div>--}}
    {{--</div>--}}
</div>

<script src="{{asset('resources/assets/lot/js/jquery-3.4.1.min.js')}} "></script>{
<script src="{{asset('resources/assets/lot/js/echarts.js')}} "></script>
<script src="{{asset('resources/assets/lot/js/china.js')}}"></script>
<script>
    window.onload = function() {
        //获取盒子的宽高
        //  $('body').width($(window).width());
        $('body').height($(window).height());

        if(document.body.clientWidth < 1400) {
            var ratioX = document.body.offsetWidth / window.innerWidth;
            var ratioY = 0.66;
            var leftMap = 240;
            $('.dataLayout').css("transform", "scale(" + ratioX + "," + ratioY + ")");
        } else if(1401 < document.body.clientWidth < 1500) {
            var ratioX = window.innerWidth / document.body.offsetWidth;
            var ratioY = window.innerHeight / document.body.offsetHeight;
            var leftMap = 420;
            //$('.dataLayout').css("transform", "scale(" + ratioX + "," + ratioY + ")");
        }
        $('.dataLayout').css('height',$(window).height());

        /*****************************************时间***********************************************/
        /**
         * 时分秒数加0判断
         */
        function zero(num) {
            return num >= 10 ? num : "0" + num;
        }
        /**
         * 当前时间和日期
         */
        function clock() {
            var oDate = new Date();
            var oYear = oDate.getFullYear();
            var oMonth = oDate.getMonth() + 1;
            var oDay = oDate.getDate();
            var oHours = oDate.getHours();
            var oMinute = oDate.getMinutes();
            var oSecond = oDate.getSeconds();
            //  var oSeconds=oDate.getSeconds();
            $('#time').html(zero(oHours) + " : " + zero(oMinute) + " : " + zero(oSecond));
            $('#date').html(oYear + "年" + zero(oMonth) + "月" + zero(oDay) + "日");
        }
        setInterval(function() {
            clock();
        }, 1000);
        /*****************************************地图***********************************************/
        var mapBoxEchart = echarts.init(document.getElementById('mapChart'));
        //地图上的点
        var data = [{
            name: "北京",
            value: 199
        },
            {
                name: "天津",
                value: 42
            },
            {
                name: "河北",
                value: 102
            },
            {
                name: "山西",
                value: 81
            },
            {
                name: "内蒙古",
                value: 47
            },
            {
                name: "辽宁",
                value: 67
            },
            {
                name: "吉林",
                value: 82
            },
            {
                name: "黑龙江",
                value: 123
            },
            {
                name: "上海",
                value: 24
            },
            {
                name: "江苏",
                value: 92
            },
            {
                name: "浙江",
                value: 114
            },
            {
                name: "安徽",
                value: 109
            },
            {
                name: "福建",
                value: 116
            },
            {
                name: "江西",
                value: 91
            },
            {
                name: "山东",
                value: 119
            },
            {
                name: "河南",
                value: 137
            },
            {
                name: "湖北",
                value: 116
            },
            {
                name: "湖南",
                value: 114
            },
            {
                name: "重庆",
                value: 91
            },
            {
                name: "四川",
                value: 125
            },
            {
                name: "贵州",
                value: 62
            },
            {
                name: "云南",
                value: 83
            },
            {
                name: "西藏",
                value: 9
            },
            {
                name: "陕西",
                value: 80
            },
            {
                name: "甘肃",
                value: 56
            },
            {
                name: "青海",
                value: 10
            },
            {
                name: "宁夏",
                value: 18
            },
            {
                name: "新疆",
                value: 180
            },
            {
                name: "广东",
                value: 123
            },
            {
                name: "广西",
                value: 59
            },
            {
                name: "海南",
                value: 14
            },
        ];
        // 散点数据
        var sanData = [];
        // 散点坐标
        var geoCoordMap = {
            '宁波': [121.613715, 29.857638],
            '南京': [118.738044, 31.944317],
            '测试环境': [116.512268, 31.74378]
        };
        var convertData = function(data) { // 处理数据函数
            var res = [];
            for(var i = 0; i < data.length; i++) {
                var geoCoord = geoCoordMap[data[i].name];
                if(geoCoord) {
                    res.push({
                        name: data[i].name,
                        value: geoCoord.concat(data[i].value)
                    });
                }
            }
            return res;
        };
        // 指定相关的配置项和数据
        var mapBoxOption = {
            // visualMap: {
            //     min: 0,
            //     max: 20,
            //     show: true,
            //     text: ['接入用户多', '接入用户少'],
            //     textGap: 20,
            //     textStyle: {
            //         color: '#fff',
            //         fontSize: 14
            //     },
            //     seriesIndex: [0],
            //     inRange: {
            //         color: ['#f8dfa0', '#f2b600']
            //     },
            //     calculable: true,
            //     left: 20
            // },
            tooltip: {
                trigger: 'item',
                backgroundColor: 'rgba(1,113,195,0.9)',
                formatter: function(params) {
                    var index = params.seriesIndex;
                    if(index == 0) {
                        var value = params.value;
                        if(value) {
                            return params.name + '<br/>' + params.seriesName + ' : ' + value + '家';
                        } else {
                            return '暂未接入企业';
                        }
                    } else {
                        return params.name + '<br/>' + params.seriesName + ' : ' + params.value[2] + '家';
                    }
                }
            },
            geo: {
                map: 'china',
                roam: true, // 是否开启鼠标缩放和平移漫游。默认不开启。如果只想要开启缩放或者平移，可以设置成 'scale' 或者 'move'。设置成 true 为都开启
                aspectScale: 0.75,
                zoom: 1.20,
                left: leftMap,
                label: {
                    normal: {
                        show: true,
                        textStyle: {
                            color: '#D1D9F2'
                        }
                    },
                    emphasis: { // 对应的鼠标悬浮效果
                        show: false,
                        textStyle: {
                            color: "#F6F8FA"
                        }
                    }
                },
                itemStyle: {
                    normal: {
                        areaColor: '#4F6DCD',
                        borderColor: '#6D91D2'
                    },
                    emphasis: {
                        borderColor: '#F2F4F8',
                        areaColor: "#244B89",
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            },
            series: [{ //地图配置
                name: '接入企业',
                type: 'map',
                roam: true,
                coordinateSystem: 'geo',
                geoIndex: 0,
                aspectScale: 0.85,
                zoom: 1.2,
                label: {
                    normal: {
                        formatter: '{b}',
                        position: 'right',
                        show: false
                    },
                    emphasis: {
                        show: true
                    }
                },
                itemStyle: {
                    normal: {
                        color: '#D1D9F2'
                    }
                }
            }, {
                name: '当前告警企业',
                type: 'effectScatter',
                coordinateSystem: 'geo',
                data: convertData(sanData),
                symbolSize: 30,
                symbolOffset: [0, 10],
                showEffectOn: 'render',
                rippleEffect: {
                    brushType: 'stroke'
                },
                hoverAnimation: true,
                large: true,
                label: {
                    normal: {
                        show: true,
                        formatter: function(item) {
                            if(item.value[2] != 0) {
                                return item.value[2];
                            } else {
                                return '';
                            }
                        },
                        textStyle: {
                            color: '#fff',
                            fontSize: 14
                        }
                    }
                },
                itemStyle: {
                    normal: {
                        shadowColor: 'red',
                        color: 'red',
                        shadowBlur: 2,
                    }
                },
                zlevel: 1
            }

            ]
        };
        // 使用制定的配置项和数据显示图表
        mapBoxEchart.setOption(mapBoxOption);
        mapBoxEchart.on('click', function(params) {
            //					console.log(params);
            if(params.seriesIndex) {
                window.location.href = "./index.html";
            } else {}
        });
        /**************************************************Echart图表相关*******************************************************/
        var pieChart = echarts.init(document.getElementById('pieChart'));
        var pieOption = {
            tooltip: {
                trigger: 'item',
                formatter: "{b}: {c} ({d}%)",
                backgroundColor: 'rgba(1,113,195,0.9)'
            },
            legend: {
                show: false,
                data: {!! $title !!}  ,
                y: 'bottom',
                bottom: 20,
                padding: 15,
                itemGap: 30,
                textStyle: {
                    color: '#fff',
                    fontSize: 14
                }
            },
            color: ['#15628c', '#ffa82c', '#fe574f'],
            series: [{
                name: '',
                type: 'pie',
                radius: ['40%', '60%'],
                center: ['50%', '42%'],
                avoidLabelOverlap: false,
                itemStyle: {
                    normal: {
                        label: {
                            show: true,
                            formatter: '{b} : {c} 次',
                            textStyle: {
                                color: '#fff',
                                fontSize: 14,
                            }
                        },
                        labelLine: {
                            smooth: true,
                            show: true
                        }
                    }
                },
                data: {!! $fenbus !!}


            }]
        };
        pieChart.setOption(pieOption);
        //柱状
        var barChart = echarts.init(document.getElementById('barChart'));
        var barOption = {
            color: ['#43cef0'],
            grid: {
                left: '3%',
                right: '10%',
                bottom: '1%',
                top: '6%',
                containLabel: true
            },
            yAxis: [{
                type: 'category',
                data: ['预警', '告警'],
                axisTick: {
                    alignWithLabel: true
                },
                axisLine: {
                    lineStyle: {
                        color: '#4f6dcd', //线的颜色
                    }
                },
                axisLabel: {
                    textStyle: {
                        color: '#fff', //坐标值得具体的颜色
                        fontSize: 14
                    }
                }
            }],
            xAxis: [{
                type: 'value',
                splitLine: {
                    show: false
                }, //去除网格线
                axisLine: {
                    show: false
                },
                axisLabel: {
                    show: false
                }
            }],
            series: [{
                name: '故障网关总数和分类',
                type: 'bar',
                barWidth: '60%',
                data: {!! $alarmType !!} ,
                label: {
                    normal: {
                        show: true,
                        position: 'right',
                        formatter: '{c} 个',
                        textStyle: {
                            color: '#fff',
                            fontSize: 16,
                            fontWeight: 600
                        }
                    }
                },
                barWidth: 30
            }]
        };
        barChart.setOption(barOption);
        //
        var lineChart = echarts.init(document.getElementById('lineChart'));
        var lineOption = {
            tooltip: {
                trigger: 'axis',
                backgroundColor: 'rgba(1,113,195,0.9)'
            },
            legend: {
                data: ['接入企业数', '接入网关数'],
                textStyle: {
                    color: '#fff',
                    fontSize: 14
                },
                padding: 12
            },
            grid: {
                left: '3%',
                right: '5%',
                bottom: '6%',
                top: '20%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                axisLabel: {
                    textStyle: {
                        color: '#fff', //坐标值得具体的颜色
                        fontSize: 14
                    }
                },
                axisLine: {
                    lineStyle: {
                        color: '#4f6dcd', //线的颜色
                    }
                },
                // 控制网格线是否显示
                splitLine: {
                    show: true,
                    lineStyle: {
                        color: '#4f6dcd',
                        width: 0.5
                    }
                },
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    formatter: '{value}',
                    textStyle: {
                        color: '#fff', //坐标值得具体的颜色
                        fontSize: 14
                    }
                },
                axisLine: {
                    lineStyle: {
                        color: '#4f6dcd', //线的颜色
                    }
                },
                splitLine: {
                    show: true,
                    lineStyle: {
                        color: '#4f6dcd',
                        width: 0.5
                    }
                },
            },
            color: ['#4f6dcd', '#f69f19'],
            series: [{
                name: '接入企业数',
                type: 'bar',
                barMaxWidth: 30,
                data: [12, 21, 23, 31, 14, 25, 24.18, 29, 10, 15, 16, 18]
            }
            ]
        };
        lineChart.setOption(lineOption);
        window.addEventListener("resize", function() {
            mapBoxEchart.resize();
            barChart.resize();
            pieChart.resize();
            lineChart.resize();
        });
    }
</script>
</body>

</html>