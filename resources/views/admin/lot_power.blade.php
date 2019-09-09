@extends('admin.lot_header')
@section('content')
        <!--右侧内容-->
        <div class="rightContent">
            <div class="rightContentTop clearfix">
                <div class="rightNav fl clearfix">
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
                            <a href="#">智慧能源管理</a>
                            <span class="grayColor">&nbsp;/&nbsp;</span>
                        </li>
                        <li>
                            <a href="#" class="whiteColor">电量</a>
                        </li>
                    </ul>
                </div>

                <div class="tabPower fr clearfix">
                    <ul>
                        <li class="fl mr15">
                            <a href="./power.html" class="tabPowerActive">每户的用电情况</a>
                        </li>
                        <li class="tabPowerOneLine"></li>
                        <li class="fl">
                            <a href="./power2.html">每户的用电情况</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="rightBottom">
                <div class="rightBottomBox">
                    <div class="rightEchartOne clearfix">
                        <div class="powerTitle">电量：当月消耗占比今年总量</div>
                        <div id="powerChart" style="height:300px;width:70%;float: left;"></div>
                        <div class="powerNumber">
                            <div class="currentPower">当月用电量：-- 度</div>
                            <div class="lastPower">上月用电量：-- 度</div>
                            <div class="comparePower">当月对比上月超出了-- 度</div>
                        </div>
                    </div>
                    <div class="rightTable margingTop10">


                        <div class="tableBody">
                            <table class="table table-bordered " style="margin: 8px 0 0 0;table-layout:fixed">
                                <thead>
                                <tr>
                                    <th>房号</th>
                                    <th>电量(度)</th>
                                    <th>联系人</th>
                                    <th>联系电话</th>
                                    <th>状态</th>
                                    <th>设备号</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1单元,01A94</td>
                                    <td>0</td>
                                    <td>联系人</td>
                                    <td>15966985082</td>
                                    <td>
                                        <span class="openContorl">启用</span>
                                        <span class="contorlLine">|</span>
                                        <span class="closeContorl">离线</span>
                                    </td>
                                    <td>98CC4D201A94</td>
                                    <td>
                                        <button class="tableBtn tableBtn1">线路明细</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1单元,01A94</td>
                                    <td>0</td>
                                    <td>联系人</td>
                                    <td>15966985082</td>
                                    <td>
                                        <span class="openContorl">启用</span>
                                        <span class="contorlLine">|</span>
                                        <span class="closeContorl">离线</span>
                                    </td>
                                    <td>98CC4D201A94</td>
                                    <td>
                                        <button class="tableBtn tableBtn1">线路明细</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1单元,01A94</td>
                                    <td>0</td>
                                    <td>联系人</td>
                                    <td>15966985082</td>
                                    <td>
                                        <span class="openContorl">启用</span>
                                        <span class="contorlLine">|</span>
                                        <span class="closeContorl">离线</span>
                                    </td>
                                    <td>98CC4D201A94</td>
                                    <td>
                                        <button class="tableBtn tableBtn1">线路明细</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1单元,01A94</td>
                                    <td>0</td>
                                    <td>联系人</td>
                                    <td>15966985082</td>
                                    <td>
                                        <span class="openContorl">启用</span>
                                        <span class="contorlLine">|</span>
                                        <span class="closeContorl">离线</span>
                                    </td>
                                    <td>98CC4D201A94</td>
                                    <td>
                                        <button class="tableBtn tableBtn1">线路明细</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1单元,01A94</td>
                                    <td>0</td>
                                    <td>联系人</td>
                                    <td>15966985082</td>
                                    <td>
                                        <span class="openContorl">启用</span>
                                        <span class="contorlLine">|</span>
                                        <span class="closeContorl">离线</span>
                                    </td>
                                    <td>98CC4D201A94</td>
                                    <td>
                                        <button class="tableBtn tableBtn1">线路明细</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1单元,01A94</td>
                                    <td>0</td>
                                    <td>联系人</td>
                                    <td>15966985082</td>
                                    <td>
                                        <span class="openContorl">启用</span>
                                        <span class="contorlLine">|</span>
                                        <span class="closeContorl">离线</span>
                                    </td>
                                    <td>98CC4D201A94</td>
                                    <td>
                                        <button class="tableBtn tableBtn1">线路明细</button>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody class="nodataTable">
                                <tr>
                                    <td colspan="4">暂无数据</td>
                                </tr>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('resources/assets/lot/js/jquery-3.4.1.min.js')}}"></script>
<!-- 包括所有已编译的插件 -->
<script src="{{asset('resources/assets/lot/js/bootstrap.min.js')}}"></script>
<!--引入echart-->
<script src="{{asset('resources/assets/lot/js/echarts.js')}}"></script>
<!--日历-->
<script src="{{asset('resources/assets/lot/laydate/laydate.js')}}"></script>
<!--radio美化-->
<script type="text/javascript" src="{{asset('resources/assets/lot/js/jquery.richUI.min.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/assets/lot/js/jquery.browser.min.js')}}"></script>
<script>
    $(function() {
        // nav收缩展开
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
        // 仪表盘
        var powerChart = echarts.init(document.getElementById("powerChart"));
        // 指定图表的配置项和数据
        var option = {
            color: ["#37A2DA", "#32C5E9", "#67E0E3"],
            series: [{
                type: 'gauge',
                detail: {
                    formatter: '{value}%'
                },
                axisLine: {
                    show: true,
                    lineStyle: {
                        width: 8,
                        shadowBlur: 0,
                        color: [
                            [0.3, '#67e0e3'],
                            [0.7, '#37a2da'],
                            [1, '#fd666d']
                        ]
                    }
                },
                data: [{
                    value: 50
                }]

            }]
        };
        // 使用刚指定的配置项和数据显示图表
        powerChart.setOption(option)
    });
</script>
</body>

</html>
    @stop