@extends('admin.header')

@section('content')
    <div class="site-content">
        <div class="content-area p-y-1">
            <div class="container-fluid">


                    <div id="mapContainer"></div>


            </div>
        </div>
    </div>
    @if(Session::has('message'))
        <div id="toast-container" class="toast-top-right" aria-live="polite" role="alert"><div class="toast
@if(Session::get('type')=='danger')
                    toast-error
@elseif(Session::get('type')=='success')
                    toast-success
@endif " style="display: block;"><div class="toast-message">{{Session::get('message')}}</div></div></div>
    @endif

    <script>
        $('#tab').DataTable( {
            dom: 'Bfrtip',
            iDisplayLength: 15,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5'

            ]
        } );
    </script>
    <script>
        $(function () {
            var toast = $('#toast-container');
            setTimeout(function () {
                toast.fadeOut(1000);
            },3000);
        })
    </script>
    <script src="http://static.anyzeal.cn/Ydaq/common/js/jquery.ztree.core.js" type="text/javascript"></script>
    <script src="http://static.anyzeal.cn/Ydaq/common/js/jquery.ztree.excheck.js" type="text/javascript"></script>
    <script type="text/javascript">
        var map = null, markers = {};
        var tree = null;
        var delay = 0;
        var music = document.getElementById("bgMusic");
        var isFirst = true;
        $(function () {
            loadMapScript();
            // initWebsocket();
            // bindEvent();
            // /* 5分钟刷新下数据 */
            // setInterval(function () {
            //     loadRtData();
            //     loadRtAlarm();
            //     /* 每天刷新下页面 */
            //     var nowTime = new Date();
            //     var hour = nowTime.getHours();
            //     var min = nowTime.getMinutes();
            //     if(hour == 0 && min <= 5){
            //         location = location;
            //     }
            // },300000);
        });
        </script>
    <script>
        //异步加载地图库函数文件
        function loadMapScript() {
            $('#mapContainer').css("height",($(window).height() - 83) + 'px');
            //创建script标签
            var script = document.createElement("script");
            //设置标签的type属性
            script.type = "text/javascript";
            //设置标签的链接地址
            script.src = "http://map.qq.com/api/js?v=2.exp&key=KM6BZ-AKTRX-SGN4D-72YUQ-Q7K6T-Z2FIO&callback=initMap";
            //添加标签到dom
            document.body.appendChild(script);
            //initMap();
        }
        function initMap() {
            //定义工厂模式函数
            var myOptions = {
                zoom: 10,               //设置地图缩放级别
                disableDefaultUI: true    //禁止所有控件
            }
            //获取dom元素添加地图信息
            map = new qq.maps.Map(document.getElementById("mapContainer"), myOptions);
            map.setCenter(new qq.maps.LatLng(29.894130,121.521640));

        }
        function initTree() {

            // var setting = {
            //     async:{
            //         url : 'http://dhy.anyzeal.cn/index.php/Admin/Index/Index/getCityTrees',
            //         type:'POST',
            //         dataType:'json',
            //         enable:true,
            //     },
            //     check: {
            //         enable: true
            //     },
            //     data: {
            //         simpleData: {
            //             enable: true
            //         }
            //     },
            //     callback: {
            //         onClick:onClick,
            //         onCheck: zTreeOnCheck,
            //         onAsyncSuccess: zTreeOnAsyncSuccess
            //     }
            // };

           // tree = $.fn.zTree.init($("#tree"), setting);
        }
        function initTree() {
            var setting = {
                async:{
                    url : 'getCityTrees',
                    type:'POST',
                    dataType:'json',
                    enable:true,
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
                    onClick:onClick,
                    onCheck: zTreeOnCheck,
                    onAsyncSuccess: zTreeOnAsyncSuccess
                }
            };
            tree = $.fn.zTree.init($("#tree"), setting);
        }
        function zTreeOnAsyncSuccess() {
            var nodes = tree.getCheckedNodes(true);
            var first = true;

            $.each(nodes,function (i,o) {
                if(o.lat && o.lng){
                    addMarker(o.id,o.name,o.lat,o.lng);
                    if(first){
                        move2point(o.lat,o.lng);
                        first = false;
                    }
                }
            });
            loadRtData();
            loadRtAlarm();
        }
        function onClick(e, treeId, treeNode) {
            if (treeNode.isParent) //如果不是叶子结点，结束
                return;
            window.open("{:U('Admin/Client/Company/loginAsCustomer')}/id/"+treeNode.id);
            //alert(treeNode.id); //获取当前结点上的相关属性数据，执行相关逻辑
        };
        function zTreeOnCheck(event, treeId, treeNode) {
            //隐藏覆盖物

            $.each(markers,function (k,v) {
                v.marker.setVisible(false);
                v.label.setMap(map);
                v.label.setVisible(false);
            });


            var nodes = tree.getCheckedNodes(true);
            var first = true;
            $.each(nodes,function (i,o) {
                if(markers[o.id]){
                    markers[o.id].label.setMap(map);
                    markers[o.id].label.setVisible(true);
                    markers[o.id].marker.setVisible(true);

                    if(first){
                        move2point(o.lat,o.lng);
                        first = false;
                    }
                }
            });
        }
        function move2point(lat,lng) {
            var point = new qq.maps.LatLng(lat, lng);
            map.panTo(point);
        }
    </script>

@stop