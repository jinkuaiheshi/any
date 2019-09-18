<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>智慧式用电安全监管与电能管理平台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 引入 Bootstrap -->
    <link href="{{asset('resources/assets/lot/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://a.amap.com/jsapi_demos/static/demo-center/css/demo-center.css" />
    <!-- HTML5 Shiv 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
    <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/lot/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/lot/css/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('resources/assets/lot/css/main.css')}}" />
    <link rel="stylesheet" href="{{asset('resources/assets/lot/css/projectList.css')}}" />
    <link rel="stylesheet" href="{{asset('resources/assets/lot/css/projectHome.css')}}" />



    <script src="{{asset('resources/assets/lot/js/jquery-3.4.1.min.js')}}" ></script>
    <!-- 包括所有已编译的插件 -->
    <script src="{{asset('resources/assets/lot/js/bootstrap.min.js')}}"></script>
    <!--引入echart-->
    <script src="{{asset('resources/assets/lot/js/echarts.js')}}"></script>
    <!--日历-->
    <script src="{{asset('resources/assets/lot/laydate/laydate.js')}}"></script>
    <!--radio美化-->
    <script type="text/javascript" src="{{asset('resources/assets/lot/js/jquery.richUI.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/lot/js/jquery.browser.min.js')}}"></script>





    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/themify-icons/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/animate.css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/jscrollpane/jquery.jscrollpane.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/waves/waves.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/chartist/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/switchery/dist/switchery.min.css')}}">

    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/DataTables/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/DataTables/Responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/DataTables/Buttons/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/DataTables/Buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/sweetalert2/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/toastr/toastr.min.css')}}">

    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/morris/morris.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">



    <!-- Vendor JS -->
    {{--<script type="text/javascript" src="{{asset('resources/assets/admin/vendor/jquery/jquery-1.12.3.min.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{asset('resources/assets/admin/vendor/tether/js/tether.min.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/detectmobilebrowser/detectmobilebrowser.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/jscrollpane/jquery.mousewheel.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/jscrollpane/mwheelIntent.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/jscrollpane/jquery.jscrollpane.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/waves/waves.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/chartist/chartist.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/switchery/dist/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/Responsive/js/dataTables.responsive.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/Responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/Buttons/js/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/Buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/JSZip/jszip.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/pdfmake/build/pdfmake.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/pdfmake/build/vfs_fonts.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/Buttons/js/buttons.html5.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/Buttons/js/buttons.print.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/DataTables/Buttons/js/buttons.colVis.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/raphael/raphael.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/morris/morris.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/toastr/toastr.min.js')}}"></script>


    <script type="text/javascript" src="{{asset('resources/assets/admin/user/js/forms-pickers.js')}}"></script>

    <script src="http://cdn.highcharts.com.cn/highcharts/highcharts.js"></script>


</head>

<body>
<div class="home">
    <!--响应式导航-->
    <div class="navbar navbar-default topNav">
        <div class="navbar-header">
            <div class="navLogo">
                <div class="img"><img src="{{asset('resources/assets/smoke/images/logo.png')}}" alt="" /></div>
                <div class="titleLogo">智慧式用电安全监管与电能管理平台</div>
            </div>
        </div>
        <ul id="shownav" class="nav navbar-nav collapse navbar-collapse">

            {{--<li>--}}
            {{--<a href="#" class="mainFontColor">--}}
            {{--<div>报警</div>--}}
            {{--<div class="flexDiv infoNumber"></div>--}}
            {{--</a>--}}
            {{--</li>--}}


            <li>
                <a href="{{url('/admin/logout')}}" class="mainFontColor">退出</a>
            </li>
        </ul>
        <!--</div>-->
    </div>

@yield('content')