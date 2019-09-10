@extends('admin.lot_header_info')
@section('content')
        <!--右侧内容-->
        <div class="rightContents">

            <div class="rightBottom">
                <div class="rightBottomBox">
                    <div class="rightEchartOne">
                        <div id="temperauture" style="height:280px;"></div>
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
                                @foreach($wendu_baojing as $value)
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




        // 24小时温度情况柱状图
        var temperauture = echarts.init(document.getElementById('temperauture'));
        var option = {
            title: {
                text: '24小时温度情况'
            },
            legend: {
                data: ['A相温度', 'B相温度', 'C相温度'],
            },
            color: ["#87cf86",'#FFD52E',"#ff0000"],
            tooltip: {
                trigger: 'item',
                formatter: "温度值:</br>{c} "
            },
            grid: {
                left: 30,
                right: 15,
                width: '97%',
                height: '70%'
            },
            xAxis: {
                data: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                axisLine: {
                    lineStyle: {
                        color: '#797979'
                    }
                },
                'axisLabel': {
                    'interval': 0,
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
                nameGap: 8
            },
            series: [{
                name: 'A相温度',
                type: 'bar',
                barWidth: 10,
                data: {!! $wendua !!},
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
            },{
                name: 'B相温度',
                type: 'bar',
                barWidth: 10,
                data: {!! $wendub !!},
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
            },{
                name: 'C相温度',
                type: 'bar',
                barWidth: 10,
                data: {!! $wenduc !!},
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
        temperauture.setOption(option);
        window.addEventListener("resize", () => {
            temperauture.setOption(option);
        });

    });
</script>
</body>

</html>
    @stop