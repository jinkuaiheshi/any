

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



    <script type="text/javascript" src="{{asset('resources/assets/admin/vendor/toastr/toastr.min.js')}}"></script>



<!-- anyadmin
123456 -->
</head>
<body class="large-sidebar fixed-sidebar fixed-header content-appear " >

    <script type="text/javascript" src="{{asset('resources/assets/admin/js/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/js/demo.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/admin/js/forms-pickers.js')}}"></script>
<div class="bg-keji">
<div class="menban" style="text-align: center;height:120px;line-height: 120px;font-size: 42px;font-weight: bold;color:#fff;position: relative;">智 慧 物 联 云 平 台</div>
    <div class="row" style="width: 1400px; margin: 0 auto; padding-top: 5%;">
        <div class="row">
	<div class="col-md-4 offset-md-2 yiji">
            <div class="modal static-modal custom-modal-1 modal_yy">
                <div class="modal-dialog">
                    {{--<a href="{{url('/admin/dashboard')}}">--}}
                    <form class="form-horizontal " method="post" enctype="multipart/form-data"  name="login" action="{{url('http://dhy.anyzeal.cn/index.php/Portal/Login/Index/login')}}" >
                        {{ csrf_field() }}
                            <input type="hidden" name="username" value="{{$info->username}}">
                            <input type="hidden" name="pwd" value="{{$info->password}}">
                            <input type="hidden" name="type" value="9">

                        <div class="modal-content" style="position: relative;">

                            

                            <div class="cm-img img-cover" style="background-image: url(img/photos-1/5.jpg);">
                                <div class="gradient gradient-danger"></div>
                                <div class="cm-content biaoqian">
                                    <div class="cm-title">智慧消防</div>
                                    <div class="cm-text">Smart electricity consumption</div>
                                </div>
                            </div>

                            <ul class="erji" >
                                <button type="submit" class="" style="float: left; width: 80px; height: 35px;    background: #fff;
    border-radius: 3px;
    text-align: center;
    margin: 3px 3px;
    color: #939393;
    font-size: 12px;border: none;">智慧终端</button>

                    <a href="{{url('/admin/lot')}}" target="_blank"><li>智慧末端</li></a>
                    <a href="#"><li>故障电弧</li></a>
                    <a href="{{url('/admin/new/smoke')}}" target="_blank"><li>无线烟感</li></a>
                    <a href="#"><li>燃气报警器</li></a>
                    <a href="#"><li>水压水位</li></a>
                    <a href="#"><li>信息传输装置</li></a>
                </ul>

                        </div>
                    </form>
                    {{--</a>--}}
                </div>
            </div>
        </div>
        <div class="col-md-4 yiji">
            <div class="modal static-modal custom-modal-1 modal_yy">
                <div class="modal-dialog">
                    <a href="#">
                        <div class="modal-content">
                            <div class="cm-img img-cover" style="background-image: url(img/photos-1/5.jpg);">
                                <div class="gradient gradient-success"></div>
                                <div class="cm-content biaoqian">
                                    <div class="cm-title">智慧能耗</div>
                                    <div class="cm-text">Intelligent terminal</div>
                                </div>
                            </div>

                            <ul class="erji">
                    <a href="http://sec.anyzeal.cn/tcmr/main/index.action" target="_blank"><li>智能电表</li></a>
                    <a href="javascript:void(0)"><li>智能水表</li></a>
                </ul>

                        </div>
                    </a>
                </div>
            </div>
        </div>
	</div>
	<div class="row">
        <div class="col-md-4 offset-md-2 yiji">
            <div class="modal static-modal custom-modal-1 modal_yy">
                <div class="modal-dialog">
                    <a href="#">
                    <div class="modal-content">
                        <div class="cm-img img-cover" style="background-image: url(img/photos-1/5.jpg);">
                            <div class="gradient gradient-info"></div>
                            <div class="cm-content biaoqian">
                                <div class="cm-title">智慧安防</div>
                                <div class="cm-text">Smart meter</div>
                            </div>
                        </div>

                        <ul class="erji">
                    <a href="#"><li>监控摄像头</li></a>
                    <a href="#"><li>门禁系统</li></a>
                    <a href="#"><li>可视对讲</li></a>
                </ul>

                    </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 yiji">
            <div class="modal static-modal custom-modal-1 modal_yy">
                <div class="modal-dialog">
                    <a href="#">
                    <div class="modal-content">
                        <div class="cm-img img-cover" style="background-image: url(img/photos-1/5.jpg);">
                            <div class="gradient gradient-purple"></div>
                            <div class="cm-content biaoqian">
                                <div class="cm-title">智慧充电</div>
                                <div class="cm-text">Smart Smoke Sense</div>
                            </div>
                        </div>

                        <ul class="erji">
                    <a href="#"><li>非机动车</li></a>
                    <a href="#"><li>汽车充电桩</li></a>
                </ul>

                    </div>
                    </a>
                </div>
            </div>
        </div>
	</div>
        <!-- <div class="col-md-3" style="margin-top: 30px;">
            <div class="modal static-modal custom-modal-1 modal_yy">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="cm-img img-cover" style="background-image: url(img/photos-1/5.jpg);">
                            <div class="gradient gradient-primary"></div>
                            <div class="cm-content">
                                <div class="cm-title">智慧用电</div>
                                <div class="cm-text">Smart electricity consumption</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <script type="text/javascript">

$('.yiji').click(function () {
    $('.biaoqian').stop().animate({
        top: '0px'
    }, 800);

    $('.erji').delay(500).hide(0);

    $(this).find('.erji').delay(500).show(0);

    $(this).find('.biaoqian').stop().animate({
        top: '-30px'
    }, 1000);
})

</script>
</div>

