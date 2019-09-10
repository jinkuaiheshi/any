@extends('admin.lot_header_info')
@section('content')
        <!--右侧内容-->
        <div class="rightContents">

            <div class="rightBottom">
                <div class="rightBottomBox">
                    <div class="rightEchartOne">
                        <div id="leakageW" style="height:280px;"></div>
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
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.nav-item>a').on('click', function() {
            if($(this).next().css('display') == "none") {
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
        // 24小时漏电报警情况柱状图
        var leakageW = echarts.init(document.getElementById('leakageW'));
        var option = {
            title: {
                text: '24小时漏电报警情况'
            },
            legend: {
                data: ['漏电预警数量', '漏电报警数量'],
            },
            color: ['#289df5','#ff5050'],
            tooltip: {
                trigger: 'axis',
                show:true,
                formatter:'{a}:{c}条</br>{a1}:{c1}条',
                axisPointer: {
                    lineStyle: {
                        color: '#ccc'
                    }
                }
            },
            grid: {
                left: 30,
                right: 15,
                width: '97%',
                height: '70%'
            },
            xAxis: {
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
                },
                nameTextStyle: {
                    padding: [24, 0, 0, 0],
                    color: '#00c5d7'
                },
                nameGap: 0,
                data: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
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
                name: '(条)'
            },
            series: [{
                name: '漏电预警数量',
                type: 'line',
                smooth: true,
                symbol: 'circle', // 拐点类型
                symbolSize: 0, // 拐点圆的大小
                itemStyle: {
                    normal: {
                        color: '#289df5', // 折线条的颜色
                        borderColor: '#289df5', // 拐点边框颜色
                        areaStyle: {
                            type: 'default',
                            opacity: 0.1
                        }
                    }
                },
                data: {!! $yujing !!}
            }, {
                name: '漏电报警数量',
                type: 'line',
                smooth: true,
                symbol: 'circle',
                symbolSize: 0,
                itemStyle: {
                    normal: {
                        color: '#ff5050',
                        borderColor: '#ff5050',
                        areaStyle: {
                            type: 'default',
                            opacity: 0.1
                        }
                    }
                },
                data: {!! $baojing !!}
            }]
        };
        leakageW.setOption(option);
        window.addEventListener("resize", () => {
            leakageW.setOption(option);
        });

    });
</script>
</body>

</html>
    @stop