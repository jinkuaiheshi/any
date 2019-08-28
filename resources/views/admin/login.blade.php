<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Title -->
    <title>Neptune</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/themify-icons/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('resources/assets/admin/vendor/font-awesome/css/font-awesome.min.css')}}">

    <!-- Neptune CSS -->
    <link rel="stylesheet" href="{{asset('resources/assets/admin/css/core.css')}}">

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="img-cover login_bg">

<div class="container-fluid">
    <div class="sign-form">
        <div class="row">
            <div class="col-md-4 offset-md-2 p-x-3">
                <div class="box b-a-0">
                    <div class="p-a-2 text-xs-center">
                        <h5>欢迎</h5>
                    </div>
                    @if(Session::has('message'))
                    <div class="alert alert-danger-outline alert-dismissible fade in m-l-1 m-r-1" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {{Session::get('message')}}
                    </div>
                    @endif
                    <form class="form-material m-b-1" action="{{url('/admin/login') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="username" class="form-control"  placeholder="邮箱/手机号" required value="{{old('username')}}">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control"  placeholder="请输入登录密码" required>
                        </div>
                        <div class="p-x-2 form-group m-b-1">
                            <button type="submit" class="btn btn-purple btn-block text-uppercase">登录</button>
                        </div>
                        <div class="p-x-2 form-group m-b-1">
                            <a href="{{url('/admin/forget') }}" ><button type="button" class="btn bg-googleplus  btn-block text-uppercase">忘记密码</button></a>
                        </div>
                    </form>

                    <div class="p-a-2 text-xs-center text-muted">
                        浙江安云智联信息科技有限公司
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vendor JS -->
<script type="text/javascript" src="{{asset('resources/assets/admin/vendor/jquery/jquery-1.12.3.min.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/assets/admin/vendor/tether/js/tether.min.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/assets/admin/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
</body>
</html>