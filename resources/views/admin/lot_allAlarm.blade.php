@extends('admin.lot_header')
@section('content')
        <!--右侧内容-->
        <div class="rightContent">
            <div class="rightContentTop clearfix">
                <div class="rightNav clearfix">
                    <ul>
                        <li>
                            <a href="./index.html" class="active">首页</a>
                            <span class="grayColor">&nbsp;/&nbsp;</span>
                        </li>
                        <li>
                            <a href="#">北仑耶稣堂</a>
                            <span class="grayColor">&nbsp;/&nbsp;</span>
                        </li>
                        <li>
                            <a href="#">电气安全监管</a>
                            <span class="grayColor">&nbsp;/&nbsp;</span>
                        </li>
                        <li>
                            <a href="#" class="whiteColor">全部报警</a>
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
                                    <span class="select">用电报警柱状图</span>
                                    <span>用电预警柱状图</span>
                                </div>
                                <ul id="con">
                                    <li class="show tabContent">
                                        <div id="barEchart1" class="chart-block" style="height:280px;"></div>
                                    </li>
                                    <li class="tabContent">
                                        <div id="barEchart2" class="chart-block" style="height:280px;"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="leftChartBox">
                            <div id="wrap1">
                                <div id="tit1">
                                    <span class="select1">用电报警饼形图</span>
                                    <span>用电预警饼形图</span>
                                </div>
                                <ul id="con1">
                                    <li class="show1 tabContent1">
                                        <div id="pieEchart1" class="chart-block1" style="height:280px;"></div>
                                    </li>
                                    <li class="tabContent1">
                                        <div id="pieEchart2" class="chart-block1" style="height:280px;"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="rightTable">
                        <div class="tableBody">
                            <table class="table table-bordered  table-striped  dataTable " style="margin: 8px 0 0 0;table-layout:fixed" id="tab">
                                <thead>
                                <tr>
                                    <th>设备</th>
                                    <th>线路</th>
                                    <th>报警类型</th>
                                    <th>报警时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $v)
                                <tr>
                                    <td>{{$v->Mac->mac}}</td>
                                    <td>线路{{$v->addr}}</td>
                                    <td>{{$v->info}}</td>
                                    <td>{{$v->time}}</td>
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

        <script>
            $(function () {

                $('#tab').DataTable( {
                    dom: 'Bfrtip',
                    iDisplayLength: 25,
                    bStateSave:true,
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5'
                    ]

                } );

            })
        </script>

</div>


        <script>
            $(function () {
                var toast = $('#toast-container');
                setTimeout(function () {
                    toast.fadeOut(1000);
                },3000);
            })
        </script>
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
        //*****************************修改密码************************
        function validateForm() {
            var oldPwd = $('#oldPassWorld').val();
            var newPwd = $('#newPassWorld').val()
            if(oldPwd == null || oldPwd == "" || oldPwd == undefined) {
                $('#oldError').show()
                $('#oldError').html('请输入旧密码')
            } else {
                $('#oldError').hide()
            }

            if(newPwd == null || newPwd == "" || newPwd == undefined) {
                $('#newError').show()
                $('#newError').html('请输入新密码')
            } else {
                $('#newError').hide()
            }
        }

        function cancle() {
            $('#oldError').hide()
            $('#newError').hide()
            $('#oldPassWorld').val('')
            $('#newPassWorld').val('')
        }
        $('.close').click(function() {
            $('#oldError').hide()
            $('#newError').hide()
            $('#oldPassWorld').val('')
            $('#newPassWorld').val('')
        })
        // 导出功能
        $('#export').click(function() {

        })
        //单选框美化
        $("input[name='date']").richradio({
            selected: "day"
        });
        //点击日则显示日的日历，点击月则显示月的日历
        $("input[name='date']").click(function() {
            if($(this).attr("value") == 'month') {
                $('#inputMonth').show();
                $('#inputDay').hide();
                laydate.render({
                    elem: '#inputMonth',
                    type: 'month',
                    range: false
                });
            }
            if($(this).attr("value") == 'day') {
                $('#inputMonth').hide();
                $('#inputDay').show();
                laydate.render({
                    elem: '#inputDay',
                    range: false
                });
            }
        })
        //默认显示当天日期
        var now = new Date();
        var time = now.getFullYear() + "-" + ((now.getMonth() + 1) < 10 ? "0" : "") + (now.getMonth() + 1) + "-" + (now.getDate() < 10 ? "0" : "") + now.getDate();
        $('#inputDay').val(time);
        //echart Tab切换
        //左侧tab
        $('#tit span').click(function() {
            var i = $(this).index(); //下标第一种写法
            $(this).addClass('select').siblings().removeClass('select');
            $('#con li').eq(i).addClass('show').siblings().removeClass('show');
        });
        //右侧tab
        $('#tit1 span').click(function() {
            var index = $(this).index(); //下标第一种写法
            $(this).addClass('select1').siblings().removeClass('select1');
            $('#con1 li').eq(index).addClass('show1').siblings().removeClass('show1');
        });
        // 用电报警柱状图
        //echart
        $('.chart-block').css('width', $('.tabContent').width());
        $('.chart-block1').css('width', $('.tabContent1').width());
        var barEchart1 = echarts.init($('#barEchart1').get(0));
        var barEchart2 = echarts.init($('#barEchart2').get(0));
        var pieEchart1 = echarts.init($('#pieEchart1').get(0));
        var pieEchart2 = echarts.init($('#pieEchart2').get(0));
        var option = {
            title: {
                text: ''
            },
            color: ["#ff0000"],
            tooltip: {
                trigger: 'item',
                formatter: "{b}: {c} "
            },
            grid: {
                left: 30,
                right: 10,
                width: '90%',
                height: '70%'
            },
            xAxis: {
                data: {!! $baojingname !!},
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
                //                    name:this.yAxisName,
                nameGap: 8
            },
            series: [{
                name: '报警预警数量',
                type: 'bar',
                barWidth: 15,
                data: {!! $baojingnum !!}
            }]
        };
        var option1 = {
            title: {
                text: ''
            },
            color: ["#FFD52E"],
            tooltip: {
                trigger: 'item',
                formatter: "{b}: {c}"
            },
            grid: {
                left: 30,
                right: 10,
                width: '90%',
                height: '70%'
            },
            xAxis: {
                data: {!! $yujingname !!},
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
                nameGap: 8
            },
            series: [{
                name: '报警预警数量',
                type: 'bar',
                barWidth: 15,
                data: {!! $yujingnum !!}
            }]

        };
        var option3 = {
            title: {
                text: ''
            },
            legend: {
                icon: 'stack',
                data: {!! $baojingname !!},
                top: 50,
                right: 50,
                orient: 'vertical',
                itemGap: 8,
                itemWidth: 20,
                textStyle: {
                    color: '#666',
                    fontWeight: 'normal',
                    fontSize: 12
                }
            },
            color: ["#CB3F40", "#F26665", "#F2A5A6", "#B92EE3", "#C077CD", "#D19EDC", "#E79C28", "#F0C647", "#FEE7A2"],
            tooltip: {
                trigger: 'item',
                formatter: "{b}: {c} ({d}%)"
            },
            series: {
                type: 'pie',
                radius: ['76%', '48%'], // 控制大小
                center: ['35%', '54%'], // 控制距离盒子左边上面的距离
                label: {
                    normal: {
                        show: false
                    },
                    emphasis: {
                        show: false,
                        textStyle: {
                            fontSize: '14',
                            color: '#666'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data: {!! $baojing !!}

            }
        };
        var option4 = {
            title: {
                text: ''
            },
            legend: {
                icon: 'stack',
                data: {!! $yujingname !!},
                top: 50,
                right: 50,
                orient: 'vertical',
                itemGap: 8,
                itemWidth: 20,
                textStyle: {
                    color: '#666',
                    fontWeight: 'normal',
                    fontSize: 12
                }
            },
            color: ["#CB3F40", "#F26665", "#F2A5A6", "#B92EE3", "#C077CD", "#D19EDC", "#E79C28", "#F0C647", "#FEE7A2"],
            tooltip: {
                trigger: 'item',
                formatter: "{b}: {c} ({d}%)"
            },
            series: {
                type: 'pie',
                radius: ['76%', '48%'], // 控制大小
                center: ['35%', '54%'], // 控制距离盒子左边上面的距离
                label: {
                    normal: {
                        show: false
                    },
                    emphasis: {
                        show: false,
                        textStyle: {
                            fontSize: '14',
                            color: '#666'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data:
                {!! $yujing !!},
            }
        };
        barEchart1.setOption(option);
        barEchart2.setOption(option1);
        pieEchart1.setOption(option3);
        pieEchart2.setOption(option4);
        window.addEventListener("resize", () => {
            barEchart1.resize();
            barEchart2.resize();
            pieEchart1.setOption(option3);
            pieEchart2.setOption(option4);
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