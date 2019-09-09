<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>智慧式用电安全监管与电能管理平台</title>
    <!-- 引入 Bootstrap -->
    <link href="{{asset('resources/assets/lot/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- HTML5 Shiv 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
    <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('resources/assets/lot/css/main.css')}}" />
    <link rel="stylesheet" href="{{asset('resources/assets/lot/css/zTreeStyle/zTreeStyle.css')}}" />
    <link rel="stylesheet" href="{{asset('resources/assets/lot/css/map.css')}}" />
</head>

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
                        <div class="item-num"><b id="totalMonitor">{{$data}}</b>组</div>
                        <div class="item-title">总监控组</div>
                    </div>
                </div>
                <div style="max-height: 300px;overflow-y: auto">
                    <ul id="tree" class="ztree"></ul>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="{{asset('resources/assets/lot/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('resources/assets/lot/js/jquery.ztree.core.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/assets/lot/js/jquery.ztree.excheck.js')}}"></script>
<!--引入高德地图-->
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=67c3e4ff717ee0c352a0ce9ec49991a2"></script>
<script>
    //地图相关
    var winHeight = $(window).height();
    var height = winHeight;
    $('#mapContainer').height(height);
    var map = new AMap.Map('mapContainer', {
        resizeEnable: true,
        zoom: 10,
        center: [121.424339, 29.793543]
    });
    var marker;
    var data = {!! $map !!};
    var markerList = [];
    var positionMarker = [];
    var icon;
    for(var i = 0; i < data.length; i++) {
        // 默认是否显示
        if(data[i].show === false){
            continue;
        }
        markerList.push(drawMark(data[i]));
    }
    function drawMark(data){
        if(data.flag == 1) {
            icon = '{{asset('resources/assets/smoke/images/map1.png')}}'
        } else if(data.flag == 2) {
            icon = '{{asset('resources/assets/smoke/images/map1.png')}}'
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

        marker.on('click', function() {
            window.open("{{url('/admin/lot/login/')}}"+ '/' +data.fid);

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

    var zNodes = {!! $mapDate !!};
    $(document).ready(function() {
        var tree = $.fn.zTree.init($("#tree"), setting, zNodes);
    });

    function zTreeOnCheck(event, treeId, treeNode) {
        //如果不是选中状态，不显示对应的marker和label，如果是选中状态 则显示对应的marker和label
        setData(treeNode);
    }
    function setData(node){
        if(!node.children){
            for(var i = 0, length = data.length; i < length ; i++){
                if(data[i].content === node.name){
                    if(node.checked === true){
                        if(markerList[i].Qi.label.content !==  node.name){
                            markerList.splice(i, 0, drawMark(data[i]));
                        }
                        markerList[i].setMap(map);
                    } else{
                        if(markerList[i].Qi.label.content ===  node.name){
                            map.remove(markerList[i]);
                        }
                    }
                    break;
                }
            }
        }else {
            for(var i = 0, length = node.children.length; i < length;i++){
                setData(node.children[i]);
            }
        }
    }

    function onClick(e, treeId, treeNode) {
        if (treeNode.isParent) //如果不是叶子结点，结束
            return;

        window.open("{{url('/admin/lot/login/')}}"+treeNode.id);
    };
    //折叠不展示表格数据
    $('.collapse').click(function() {
        if($(this).hasClass("downImg")) {
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