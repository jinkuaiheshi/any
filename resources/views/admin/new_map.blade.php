@extends('admin.somke_header')
@section('content')

<body>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="map-box">
            <div id="mapContainer"></div>
            <div class="city-box">
                <div class="row">
                    <div class="col-md-6">
                        <div class="item-num"><b id="totalCompany">{{$company}}</b>家</div>
                        <div class="item-title">总接入企业</div>
                    </div>
                    <div class="col-md-6">
                        <div class="item-num"><b id="totalMonitor">{{$data}}</b>个</div>
                        <div class="item-title">总监控点</div>
                    </div>
                </div>
                <div style="max-height: 300px;overflow-y: auto">
                    <ul id="tree" class="ztree"></ul>
                </div>
            </div>
            {{--<div class="alarm-box">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-6">--}}
                        {{--<div class="item-num red"><b id="alarmCompany">0</b>家</div>--}}
                        {{--<div class="item-title">当前告警企业</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-6">--}}
                        {{--<div class="item-num red"><b id="alarmMonitor">0</b>个</div>--}}
                        {{--<div class="item-title">当前告警监控点</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="portlet light" style="margin-bottom: 0;padding-bottom: 0;">--}}
                    {{--<div class="portlet-title">--}}
                        {{--<div class="caption"><span style="font-size:16px;margin-right:10px;">实时告警列表</span>--}}
                            {{--<a class="btn btn-primary btn-xs" href="./bigData.html" target="_blank">切换大屏展示</a>--}}
                            {{--<a class="btn btn-warning btn-xs" id="stopSound" href="javascript:;">关闭报警声音</a>--}}
                        {{--</div>--}}
                        {{--<div class="tools" style="padding:0">--}}
                            {{--<a href="javascript:;" class="collapse downImg" title="展开/折叠"></a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="portlet-body" style="max-height: 300px;overflow: auto">--}}
                        {{--<table class="table order-column dataTable text-center margin-top-10">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th>告警企业</th>--}}
                                {{--<th>城市</th>--}}
                                {{--<th>隐患点</th>--}}
                                {{--<th>最新告警时间</th>--}}
                                {{--<th>详情</th>--}}
                                {{--<th>电话确认</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody id="alarmList">--}}
                            {{--<tr style="display: table-row;">--}}
                                {{--<td>--}}
                                    {{--<a target="_blank" href="/">南北零食</a>--}}
                                {{--</td>--}}
                                {{--<td>市辖区</td>--}}
                                {{--<td>1</td>--}}
                                {{--<td class="font-red">07-29 22:29</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="detail_532"--}}
                                       {{--class="btn blue-madison btn-sm viewBtn"><span class="fa"></span> 详情</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="check_532"--}}
                                       {{--class="btn blue-madison btn-sm checkBtn"><span class="fa"></span> 确认</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr style="display: table-row;">--}}
                                {{--<td>--}}
                                    {{--<a target="_blank" href="/">南北零食南北零食南北零食南北</a>--}}
                                {{--</td>--}}
                                {{--<td>市辖区</td>--}}
                                {{--<td>1</td>--}}
                                {{--<td class="font-red">07-29 22:29</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="detail_532"--}}
                                       {{--class="btn blue-madison btn-sm viewBtn"><span class="fa"></span> 详情</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="check_532"--}}
                                       {{--class="btn blue-madison btn-sm checkBtn"><span class="fa"></span> 确认</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr style="display: table-row;">--}}
                                {{--<td>--}}
                                    {{--<a target="_blank" href="/">南北零食</a>--}}
                                {{--</td>--}}
                                {{--<td>市辖区</td>--}}
                                {{--<td>1</td>--}}
                                {{--<td class="font-red">07-29 22:29</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="detail_532"--}}
                                       {{--class="btn blue-madison btn-sm viewBtn"><span class="fa"></span> 详情</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="check_532"--}}
                                       {{--class="btn blue-madison btn-sm checkBtn"><span class="fa"></span> 确认</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr style="display: table-row;">--}}
                                {{--<td>--}}
                                    {{--<a target="_blank" href="/">南北零食</a>--}}
                                {{--</td>--}}
                                {{--<td>市辖区</td>--}}
                                {{--<td>1</td>--}}
                                {{--<td class="font-red">07-29 22:29</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="detail_532"--}}
                                       {{--class="btn blue-madison btn-sm viewBtn"><span class="fa"></span> 详情</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="check_532"--}}
                                       {{--class="btn blue-madison btn-sm checkBtn"><span class="fa"></span> 确认</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr style="display: table-row;">--}}
                                {{--<td>--}}
                                    {{--<a target="_blank" href="/">南北零食</a>--}}
                                {{--</td>--}}
                                {{--<td>市辖区</td>--}}
                                {{--<td>1</td>--}}
                                {{--<td class="font-red">07-29 22:29</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="detail_532"--}}
                                       {{--class="btn blue-madison btn-sm viewBtn"><span class="fa"></span> 详情</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="check_532"--}}
                                       {{--class="btn blue-madison btn-sm checkBtn"><span class="fa"></span> 确认</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr style="display: table-row;">--}}
                                {{--<td>--}}
                                    {{--<a target="_blank" href="/">南北零食</a>--}}
                                {{--</td>--}}
                                {{--<td>市辖区</td>--}}
                                {{--<td>1</td>--}}
                                {{--<td class="font-red">07-29 22:29</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="detail_532"--}}
                                       {{--class="btn blue-madison btn-sm viewBtn"><span class="fa"></span> 详情</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="check_532"--}}
                                       {{--class="btn blue-madison btn-sm checkBtn"><span class="fa"></span> 确认</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr style="display: table-row;">--}}
                                {{--<td>--}}
                                    {{--<a target="_blank" href="/">南北零食</a>--}}
                                {{--</td>--}}
                                {{--<td>市辖区</td>--}}
                                {{--<td>1</td>--}}
                                {{--<td class="font-red">07-29 22:29</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="detail_532"--}}
                                       {{--class="btn blue-madison btn-sm viewBtn"><span class="fa"></span> 详情</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="check_532"--}}
                                       {{--class="btn blue-madison btn-sm checkBtn"><span class="fa"></span> 确认</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr style="display: table-row;">--}}
                                {{--<td>--}}
                                    {{--<a target="_blank" href="/">南北零食</a>--}}
                                {{--</td>--}}
                                {{--<td>市辖区</td>--}}
                                {{--<td>1</td>--}}
                                {{--<td class="font-red">07-29 22:29</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="detail_532"--}}
                                       {{--class="btn blue-madison btn-sm viewBtn"><span class="fa"></span> 详情</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="check_532"--}}
                                       {{--class="btn blue-madison btn-sm checkBtn"><span class="fa"></span> 确认</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr style="display: table-row;">--}}
                                {{--<td>--}}
                                    {{--<a target="_blank" href="/">南北零食</a>--}}
                                {{--</td>--}}
                                {{--<td>市辖区</td>--}}
                                {{--<td>1</td>--}}
                                {{--<td class="font-red">07-29 22:29</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="detail_532"--}}
                                       {{--class="btn blue-madison btn-sm viewBtn"><span class="fa"></span> 详情</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0);" id="check_532"--}}
                                       {{--class="btn blue-madison btn-sm checkBtn"><span class="fa"></span> 确认</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
</div>
<script src="{{asset('resources/assets/smoke/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('resources/assets/smoke/js/jquery.ztree.core.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/assets/smoke/js/jquery.ztree.excheck.js')}}"></script>
<!--引入高德地图-->
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=67c3e4ff717ee0c352a0ce9ec49991a2">
</script>
<script>
    //地图相关
    var winHeight = $(window).height();
    var height = winHeight;
    $('#mapContainer').height(height);
    var map = new AMap.Map('mapContainer', {
        resizeEnable: true,
        zoom: 10,
        center: [120.424339, 29.993543]
    });
    var marker;
    // var data = [{
    //     "fLong": 120.208495,
    //     'fLati': 30.274967,
    //     'flag': 1,
    //     'content': '杭州测试',
    //     'show': true
    // }, {
    //     "fLong": 121.144393,
    //     'fLati': 29.790786,
    //     'flag': 2,
    //     'content': '杭州老板电器有限公司',
    //     'show': true
    // }, {
    //     "fLong": 120.750258,
    //     'fLati': 29.876559,
    //     'flag': 1,
    //     'content': '华东医药',
    //     'show': true
    // }];
    var data = {!! $map !!};
    var markerList = [];
    var positionMarker = [];
    var icon;
    for (var i = 0; i < data.length; i++) {
        // 默认是否显示
        if (data[i].show === false) {
            continue;
        }
        markerList.push(drawMark(data[i]));
    }

    function drawMark(data) {
        if (data.flag == 1) {
            icon = '{{asset('resources/assets/smoke/images/map1.png')}}'
        } else if (data.flag == 2) {
            icon = '{{asset('resources/assets/smoke/images/map2.png')}}'
        }
        positionMarker = [data.fLong, data.fLati];
        marker = new AMap.Marker({
            position: positionMarker,
            icon: icon,
            zIndex: 101,
            map: map
        });
        marker.setLabel({
            offset: new AMap.Pixel(15, 15),
            content: data.content
        });
        marker.setMap(map);
        marker.on('click', function (e) {
            location.href = 'projectHome.html';
        })
        return marker;
    }
    //tree
    var setting = {
        view: {
            selectedMulti: false
        },
        check: {
            enable: true
        },
        data: {
            simpleData: {
                enable: true
            }
        },
        callback: {
            onClick: onClick,
            onCheck: zTreeOnCheck
        }
    };

    var zNodes = [{
        id: 1,
        pId: 0,
        name: "宁波",
        open: true,
        checked: true
    },
        {
            id: 111,
            pId: 11,
            name: "安云电海洋演示箱",
            open: true,
            checked: true,
            url: 'http://www.baidu.com'
            // children: [{
            // 	name: '烟感',
            // 	href: 'http://www.baidu.com'
            // }]
        }, {
            id: 11,
            pId: 1,
            name: "鄞州区",
            open: true,
            checked: true
        },
        {
            id: 112,
            pId: 11,
            name: "无锡江海街道办事处",
            open: true,
            checked: true,
            url: 'http://www.baidu.com'
        },
        {
            id: 2,
            pId: 0,
            name: "杭州",
            open: false,
            checked: true
        }, {
            id: 21,
            pId: 11,
            name: "平湖市当湖镇金沙碧浪沐浴休闲城",
            open: true,
            checked: true,
            url: 'http://www.baidu.com'
        }, {
            id: 211,
            pId: 11,
            name: "光明便利店",
            open: true,
            checked: true,
            url: 'http://www.baidu.com'
        }
    ];
    $(document).ready(function () {
        var tree = $.fn.zTree.init($("#tree"), setting, zNodes);
    });

    function zTreeOnCheck(event, treeId, treeNode) {
        //如果不是选中状态，不显示对应的marker和label，如果是选中状态 则显示对应的marker和label
        setData(treeNode);
    }

    function setData(node) {
        //				console.log(node);
        if (!node.children) {
            for (var i = 0, length = data.length; i < length; i++) {
                if (data[i].content === node.name) {
                    if (node.checked === true) {
                        if (markerList[i].Qi.label.content !== node.name) {
                            markerList.splice(i, 0, drawMark(data[i]));
                        }
                        markerList[i].setMap(map);
                    } else {
                        if (markerList[i].Qi.label.content === node.name) {
                            map.remove(markerList[i]);
                        }
                    }
                    break;
                }
            }
        } else {
            for (var i = 0, length = node.children.length; i < length; i++) {
                setData(node.children[i]);
            }
        }
    }

    function onClick(e, treeId, treeNode) {
        console.log(e);
        console.log(treeId);
        console.log(treeNode);
        if (treeNode.isParent) //如果不是叶子结点，结束
            return;
    };
    //折叠不展示表格数据
    $('.collapse').click(function () {
        if ($(this).hasClass("downImg")) {
            $(this).removeClass('downImg');
            $(this).addClass('upImg');
            $('.portlet-body').hide();
        } else {
            $(this).removeClass('upImg');
            $(this).addClass('downImg');
            $('.portlet-body').show();
        }

    })
</script>
</body>

</html>
@stop