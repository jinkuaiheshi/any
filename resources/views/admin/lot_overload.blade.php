@extends('admin.lot_header_info')
@section('content')
        <!--右侧内容-->
        <div class="rightContents">

            <div class="rightBottom">
                <div class="rightBottomBox">
                    <div class="rightEchart clearfix">
                        <div class="rightChartBox">
                            <div id="lineEchart1" style="height:300px;"></div>
                        </div>
                        <div class="leftChartBox">
                            <div id="lineEchart2" style="height:300px;"></div>
                        </div>
                    </div>
                    <div class="rightTable">
                        <div class="tableBody">
                            <table class="table table-bordered " style="margin: 8px 0 0 0;table-layout:fixed">
                                <thead>
                                <tr>
                                    <th>地点</th>
                                    <th>线路</th>
                                    <th>报警类型</th>
                                    <th>报警时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $data as $v)
                                    <tr>
                                        <td>{{$value->Mac->mac}}</td>
                                        <td>{{$value->node}}</td>
                                        <td>{{$value->info}}</td>
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

        //echart
        var lineEchart1 = echarts.init(document.getElementById('lineEchart1'));
        var lineEchart2 = echarts.init(document.getElementById('lineEchart2'));
        var option = {
            title: {
                text: '24小时电流报警情况'
            },
            color: ["#87cf86"],
            tooltip: {
                trigger: 'item',
                formatter: "{b}时: {c}(安)"
            },
            legend: {
                data: ['报警'],
            },
            grid: {
                left: 30,
                right: 10,
                width: '90%',
                height: '72%'
            },
            xAxis: {
                data: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                axisLine: {
                    lineStyle: {
                        color: '#797979'
                    }
                },
                axisLabel: {
                    interval: 0,
                    textStyle: {
                        color: 'rgb(0,0,0)'
                    }
                }
            },
            yAxis: {
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
                name: '(安)',
                nameGap: 8
            },
            series: [{
                name: '报警',
                type: 'bar',
                barWidth: 15,
                data: {!! $baojing !!},
                label: {
                    normal: {
                        show: true,
                        position: 'top',
                        textStyle: {
                            color: '#666',
                            fontSize: '12',
                        }
                    }
                }
            }]
        };
        var option1 = {
            title: {
                text: '24小时电流预警'
            },
            legend: {
                data: ['预警'],
            },
            color: ["#ff0000"],
            tooltip: {
                trigger: 'item',
                formatter: "{b}时: {c}(千瓦时)"
            },
            grid: {
                left: 30,
                right: 10,
                width: '90%',
                height: '72%'
            },
            xAxis: {
                data: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                axisLine: {
                    lineStyle: {
                        color: '#797979'
                    }
                },
                axisLabel: {
                    interval: 0,
                    textStyle: {
                        color: 'rgb(0,0,0)'
                    }
                }
            },
            yAxis: {
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
                name: '(千瓦时)',
                nameGap: 8
            },
            series: [{
                name: '预警',
                type: 'bar',
                barWidth: 15,
                data: {!! $yujing !!},
                label: {
                    normal: {
                        show: true,
                        position: 'top',
                        textStyle: {
                            color: '#666',
                            fontSize: '12',
                        }
                    }
                }
            }]

        };
        lineEchart1.setOption(option);
        lineEchart2.setOption(option1);
        window.addEventListener("resize", () => {
            lineEchart1.resize();
            lineEchart2.setOption(option1);
        });
    });
</script>
</body>

</html>
@stop