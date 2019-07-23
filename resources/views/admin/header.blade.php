<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Title -->
    <title>安云智联全系产品管理系统</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/bootstrap/css/bootstrap.min.css')}}">
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

    <!-- Neptune CSS -->
    <link rel="stylesheet" href="{{asset('resources/assets/admin/css/core.css')}}">
    <link href="{{asset('resources/assets/admin/user/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
    <!-- Vendor JS -->
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/jquery/jquery-1.12.3.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/tether/js/tether.min.js')}}"></script>
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
<body class="large-sidebar fixed-sidebar fixed-header content-appear">
<div class="wrapper">
    <!-- Preloader -->
    <div class="preloader"></div>
    <!-- Sidebar -->
    <div class="site-sidebar-overlay"></div>
    <div class="site-sidebar">
        <a class="logo" href="{{url('admin/index')}}">
            <span class="l-text" >
                <img src="{{asset('resources/assets/admin/img/logo.png')}}" style="width: 60px;"/>安云智联
            </span>
            {{--<span class="l-icon"></span>--}}
        </a>
        <div class="custom-scroll custom-scroll-light">
            <ul class="sidebar-menu">



                    <li class="with-sub"> <a href="{{url('/admin/dashboard')}}" class="waves-effect  waves-light">
                            <span class="s-icon"><i class="ti-info"></i></span>
                            <span class="s-text">系统主页</span>
                        </a></li>

                <li class="with-sub"> <a href="{{url('/admin/usage')}}" class="waves-effect  waves-light">
                        <span class="s-icon"><i class="fa fa-bar-chart-o"></i></span>
                        <span class="s-text">套餐使用情况</span>
                    </a></li>
                <li class="with-sub"> <a href="{{url('/admin/operation/alarmlist')}}" class="waves-effect  waves-light">
                        <span class="s-icon"><i class="fa fa-feed"></i></span>
                        <span class="s-text">报警详情</span>
                    </a></li>
                @if($info->type == 1)
                    <li class="with-sub"> <a href="{{url('/admin/baiteng/up')}}" class="waves-effect  waves-light">
                        <span class="s-icon"><i class="fa fa-location-arrow"></i></span>
                        <span class="s-text">佰腾数据同步</span>
                    </a></li>
                @endif
                <li class="with-sub"> <a href="{{url('/admin/jingbao')}}" class="waves-effect  waves-light">
                        <span class="s-icon"><i class="fa  fa-fire"></i></span>
                        <span class="s-text">警报处理统计</span>
                    </a></li>
                {{--<li class="with-sub">--}}
                    {{--<a href="#" class="waves-effect  waves-light">--}}
                        {{--<span class="s-caret"><i class="fa fa-angle-down"></i></span>--}}
                        {{--<span class="s-icon"><i class="ti-dashboard"></i></span>--}}
                        {{--<span class="s-text">运营中心</span>--}}
                    {{--</a>--}}
                    {{--<ul>--}}

                        {{--<li><a href="{{url('/admin/operation/alarmlist')}}">报警详情</a></li>--}}
                        {{--<li><a href="{{url('/admin/yyyy')}}">临时用----输出公司</a></li>--}}

                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li class="with-sub">--}}
                    {{--<a href="#" class="waves-effect  waves-light">--}}
                        {{--<span class="s-caret"><i class="fa fa-angle-down"></i></span>--}}
                        {{--<span class="s-icon"><i class="ti-dashboard"></i></span>--}}
                        {{--<span class="s-text">佰腾平台</span>--}}
                    {{--</a>--}}
                    {{--<ul>--}}

                        {{--<li><a href="{{url('/admin/baiteng/index')}}">项目管理</a></li>--}}
                        {{--<li><a href="{{url('/admin/baiteng/monitor')}}">设备管理</a></li>--}}


                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li class="with-sub">--}}
                    {{--<a href="#" class="waves-effect  waves-light">--}}
                        {{--<span class="s-caret"><i class="fa fa-angle-down"></i></span>--}}
                        {{--<span class="s-icon"><i class="ti-dashboard"></i></span>--}}
                        {{--<span class="s-text">系统设置</span>--}}
                    {{--</a>--}}
                    {{--<ul>--}}

                        {{--<li><a href="{{url('/admin/sys/company')}}">企业管理</a></li>--}}
                        {{--<li><a href="{{url('/admin/sys/provider')}}">服务商管理</a></li>--}}
                        {{--<li><a href="{{url('/admin/sys/user/auth')}}">用户级别管理</a></li>--}}
                        {{--<li><a href="{{url('/admin/sys/province')}}">全国地区管理</a></li>--}}


                    {{--</ul>--}}
                {{--</li>--}}
                <li class="with-sub">
                    <a href="#" class="waves-effect  waves-light">
                        <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                        <span class="s-icon"><i class="ti-dashboard"></i></span>
                        <span class="s-text">设备列表</span>
                    </a>
                    <ul>

                        <li><a href="{{url('/admin/monitor/bt')}}">佰腾</a></li>
                        <li><a href="{{url('/admin/monitor/v1')}}">电气火灾探测器（旧版）</a></li>
                        <li><a href="{{url('/admin/monitor/v2')}}">电气火灾探测器（标准版）</a></li>
                        <li><a href="{{url('/admin/monitor/v3')}}">电气火灾探测器（电量版）</a></li>


                    </ul>
                </li>






                {{--<li class="with-sub">--}}
                    {{--<a href="#" class="waves-effect  waves-light">--}}
                        {{--<span class="s-caret"><i class="fa fa-angle-down"></i></span>--}}
                        {{--<span class="s-icon"><i class="ti-star"></i></span>--}}
                        {{--<span class="s-text">Icons</span>--}}
                    {{--</a>--}}
                    {{--<ul>--}}
                        {{--<li><a href="icons-fontawesome.html">Font Awesome</a></li>--}}
                        {{--<li><a href="icons-material.html">Material Design</a></li>--}}
                        {{--<li><a href="icons-themify.html">Themify Icons</a></li>--}}
                        {{--<li><a href="icons-weather.html">Weather Icons</a></li>--}}
                        {{--<li><a href="icons-ionicons.html">Ionicons</a></li>--}}
                        {{--<li><a href="icons-typicons.html">Typicons</a></li>--}}
                        {{--<li><a href="icons-pe7.html">Pe7 Icons</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{----}}



            </ul>
        </div>
    </div>




    <!-- Header -->
    <div class="site-header">
        <nav class="navbar navbar-light">
            <ul class="nav navbar-nav">
                <li class="nav-item m-r-1 hidden-lg-up">
                    <a class="nav-link collapse-button" href="#">
                        <i class="ti-menu"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-xs-right">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="ti-check"></i>
                        <span class="tag tag-success top">3</span>
                    </a>
                    <div class="dropdown-tasks dropdown-menu dropdown-menu-right animated slideInUp">
                        <div class="t-item">
                            <div class="m-b-0-5">
                                <a class="text-black" href="#">First Task</a>
                                <span class="pull-xs-right text-muted">75%</span>
                            </div>
                            <progress class="progress progress-danger progress-sm" value="75" max="100">100%</progress>
                            <span class="avatar box-32">
										<img src="img/avatars/2.jpg" alt="">
									</span>
                            <a class="text-black" href="#">John Doe</a>, <span class="text-muted">5 min ago</span>
                        </div>
                        <div class="t-item">
                            <div class="m-b-0-5">
                                <a class="text-black" href="#">Second Task</a>
                                <span class="pull-xs-right text-muted">40%</span>
                            </div>
                            <progress class="progress progress-purple progress-sm" value="40" max="100">100%</progress>
                            <span class="avatar box-32">
										<img src="img/avatars/3.jpg" alt="">
									</span>
                            <a class="text-black" href="#">John Doe</a>, <span class="text-muted">15:07</span>
                        </div>
                        <div class="t-item">
                            <div class="m-b-0-5">
                                <a class="text-black" href="#">Third Task</a>
                                <span class="pull-xs-right text-muted">100%</span>
                            </div>
                            <progress class="progress progress-warning progress-sm" value="100" max="100">100%</progress>
                            <span class="avatar box-32">
										<img src="img/avatars/4.jpg" alt="">
									</span>
                            <a class="text-black" href="#">John Doe</a>, <span class="text-muted">yesterday</span>
                        </div>
                        <div class="t-item">
                            <div class="m-b-0-5">
                                <a class="text-black" href="#">Fourth Task</a>
                                <span class="pull-xs-right text-muted">60%</span>
                            </div>
                            <progress class="progress progress-success progress-sm" value="60" max="100">100%</progress>
                            <span class="avatar box-32">
										<img src="img/avatars/5.jpg" alt="">
									</span>
                            <a class="text-black" href="#">John Doe</a>, <span class="text-muted">3 days ago</span>
                        </div>
                        <a class="t-item text-black text-xs-center" href="#">
                            <strong>View all tasks</strong>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="ti-bell"></i>
                        <span class="tag tag-danger top">12</span>
                    </a>
                    <div class="dropdown-messages dropdown-tasks dropdown-menu dropdown-menu-right animated slideInUp">
                        <div class="m-item">
                            <div class="mi-icon bg-info"><i class="ti-comment"></i></div>
                            <div class="mi-text"><a class="text-black" href="#">John Doe</a> <span class="text-muted">commented post</span> <a class="text-black" href="#">Lorem ipsum dolor</a></div>
                            <div class="mi-time">5 min ago</div>
                        </div>
                        <div class="m-item">
                            <div class="mi-icon bg-danger"><i class="ti-heart"></i></div>
                            <div class="mi-text"><a class="text-black" href="#">John Doe</a> <span class="text-muted">liked post</span> <a class="text-black" href="#">Lorem ipsum dolor</a></div>
                            <div class="mi-time">15:07</div>
                        </div>
                        <div class="m-item">
                            <div class="mi-icon bg-purple"><i class="ti-user"></i></div>
                            <div class="mi-text"><a class="text-black" href="#">John Doe</a> <span class="text-muted">followed</span> <a class="text-black" href="#">Kate Doe</a></div>
                            <div class="mi-time">yesterday</div>
                        </div>
                        <div class="m-item">
                            <div class="mi-icon bg-danger"><i class="ti-heart"></i></div>
                            <div class="mi-text"><a class="text-black" href="#">John Doe</a> <span class="text-muted">liked post</span> <a class="text-black" href="#">Lorem ipsum dolor</a></div>
                            <div class="mi-time">3 days ago</div>
                        </div>
                        <a class="t-item text-black text-xs-center" href="#">
                            <strong>View all notifications</strong>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" data-toggle="dropdown" aria-expanded="false">
                        <div class="avatar box-32">
                            <img src="img/avatars/1.jpg" alt="">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <a class="dropdown-item" href="#">
                            <i class="ti-email m-r-0-5"></i> Inbox
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="ti-user m-r-0-5"></i> Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="ti-settings m-r-0-5"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="ti-help m-r-0-5"></i> Help</a>
                        <a class="dropdown-item" href="{{url('/admin/logout')}}"><i class="ti-power-off m-r-0-5"></i>退出系统</a>
                    </div>
                </li>
                <li class="nav-item hidden-md-up">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapse-1">
                        <i class="ti-more"></i>
                    </a>
                </li>

            </ul>

        </nav>
    </div>
@yield('content')

    <script type="text/javascript" src="{{asset('resources/assets/admin/js/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/js/demo.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/js/forms-pickers.js')}}"></script>
</div>
</body>
</html>