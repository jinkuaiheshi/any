@extends('admin.terminal_header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">

            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>设备号</th>
                    <th>地址</th>
                    <th>状态</th>
                    <th>通讯模块类型</th>
                    <th>操作</th>

                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->mac}}</td>


                        <td>{{$v->build.$v->unit.$v->room}}</td>



                        <td>  @if ($v->online == 1)
                                在线
                            @elseif ($v->online == 0)
                                离线
                            @else
                                未曾连接
                            @endif
                        </td>
                        <td>{{$v->protocol}}</td>
                        <td>  <a href="{{url('admin/terminal/shishi').'/'.$v->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-purple w-min-xs  waves-effect waves-light "  >实时数据</button></a>
                            <a href="{{url('admin/terminal/alarm').'/'.$v->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-danger w-min-xs  waves-effect waves-light "  >告警数据</button></a>

                            <a href="{{url('admin/terminal/electric').'/'.$v->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-warning w-min-xs  waves-effect waves-light "  >电量统计</button></a>
                            <a href="{{url('admin/terminal/voltage').'/'.$v->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-primary w-min-xs  waves-effect waves-light "  >平均电压</button></a>
                            <a href="{{url('admin/terminal/galvanic').'/'.$v->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-primary w-min-xs  waves-effect waves-light "  >平均电流</button></a>
                            <a href="{{url('admin/terminal/leakage').'/'.$v->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-info w-min-xs  waves-effect waves-light "  >漏电值</button></a>
                            <a href="{{url('admin/terminal/temperature').'/'.$v->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-success w-min-xs  waves-effect waves-light "  >温度统计</button></a>
                        </td>






                    </tr>
                @endforeach
                </tbody>
            </table>

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
        $(function () {
            var toast = $('#toast-container');
            setTimeout(function () {
                toast.fadeOut(1000);
            },3000);
        })
    </script>



    <script>
        $('#tab').DataTable( {
            dom: 'Bfrtip',
            iDisplayLength: 15,
            bStateSave:true,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5'

            ]
        } );
    </script>
@stop