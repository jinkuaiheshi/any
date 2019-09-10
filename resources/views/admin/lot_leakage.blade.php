@extends('admin.lot_header_info')
@section('content')
        <!--右侧内容-->
        <div class="rightContents">

            <div class="rightBottom">
                <div class="rightBottomBox">
                    <div class="rightEchartOne">
                        <div id="leakageEchart" style="height:280px;"></div>
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
                                @foreach($loudian_baojing as $value)
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
    $(function() {
        
        // 24小时漏电流柱状图
        var leakageEchart = echarts.init(document.getElementById('leakageEchart'));
        var option = {
            title: {
                text: '24小时漏电情况'
            },
            color: ["#87cf86"],
            tooltip: {
                trigger: 'item',
                formatter: "漏电流值:</br>{c} "
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
                //                    name:this.yAxisName,
                nameGap: 8
            },
            series: [{
                name: '24小时漏电情况',
                type: 'bar',
                barWidth: 20,
                data: {!! $loudian !!},
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
        leakageEchart.setOption(option);
        window.addEventListener("resize", () => {
            leakageEchart.setOption(option);
        });

    });
</script>
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