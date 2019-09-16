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
                data: ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'],
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
                name: '温度',
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