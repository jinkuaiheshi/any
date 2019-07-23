@extends('admin.terminal_header')

@section('content')

    <div class="site-content">


        <div class="box box-block bg-white">

            <p class="font-90 text-muted m-b-3"></p>

            <div class="row">

                <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/terminal/leakages/month')}}">
                    {{ csrf_field() }}
                    <input type="hidden" placeholder="" class="form-control" name="y_mac" value="{{$mac}}" >
                    <input type="hidden" placeholder="" class="form-control" name="y_projectCode" value="{{$projectCode}}" >
                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-4" style="text-align: right">
                            <label for="order" class=" col-form-label " >月统计漏电值：</label>
                        </div>
                        <div class="col-md-3">
                            <div   class="form-group">
                                <input type="text" placeholder="" class="form-control mydatepicker" name="month" required >
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary">进行统计</button>
                        </div>

                    </div>
                </form>
                <script type="text/javascript">
                    $('.mydatepicker').datepicker({
                        format: "yyyy-mm",
                        minView:'month',
                        language: 'zh-CN',
                    });

                </script>
                <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/terminal/leakages/day')}}">
                    {{ csrf_field() }}
                    <input type="hidden" placeholder="" class="form-control" name="y_mac" value="{{$mac}}" >
                    <input type="hidden" placeholder="" class="form-control" name="y_projectCode" value="{{$projectCode}}" >
                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-4" style="text-align: right">
                            <label for="order" class=" col-form-label " >日统计漏电值：</label>
                        </div>
                        <div class="col-md-3">
                            <div   class="form-group">
                                <input type="text" placeholder="" class="form-control datepickerday" name="day" required >
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary">进行统计</button>
                        </div>
                    </div>
                </form>
                <script type="text/javascript">
                    $('.datepickerday').datepicker({
                        format: "yyyy-mm-dd",
                        minView:'month',
                        language: 'zh-CN',
                    });

                </script>

            </div>
            </form>
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


    <style>
        .select2-container{
            width: 100%;
        }
    </style>


    <script>
        $(function () {

            var toast = $('#toast-container');
            setTimeout(function () {
                toast.fadeOut(1000);
            },3000);
        })
    </script>


@stop