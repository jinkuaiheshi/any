@extends('admin.terminal_header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">
                <a href="{{url('/admin/terminal/company/add')}}" ><button type="button" class="  btn btn-primary w-min-sm m-b-1 waves-effect waves-light" style="float: right;display:inline-block" >添加企业</button></a>
            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>ID</th>

                    <th>名称</th>
                    <th>操作</th>

                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->id}}</td>

                        <td>{{$v->fullname}}</td>
                        <td>
                            @if($v->is_terminal_band == 0)

                            <a href="jacascript::void(0)" ><button type="button" class="btn btn-info w-min-xs  waves-effect waves-light status" data-toggle="modal" data-target="#Band" data-action="{{$v->id}}">绑定设备</button></a>
                            @else
                                <a href="{{url('admin/terminal/shishi').'/'.$v->Mac->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-purple w-min-xs  waves-effect waves-light "  >实时数据</button></a>
                                <a href="{{url('admin/terminal/alarm').'/'.$v->Mac->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-danger w-min-xs  waves-effect waves-light "  >告警数据</button></a>

                                <a href="{{url('admin/terminal/electric').'/'.$v->Mac->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-warning w-min-xs  waves-effect waves-light "  >电量统计</button></a>
                                <a href="{{url('admin/terminal/voltage').'/'.$v->Mac->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-primary w-min-xs  waves-effect waves-light "  >平均电压</button></a>
                                <a href="{{url('admin/terminal/galvanic').'/'.$v->Mac->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-primary w-min-xs  waves-effect waves-light "  >平均电流</button></a>
                                <a href="{{url('admin/terminal/leakage').'/'.$v->Mac->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-info w-min-xs  waves-effect waves-light "  >漏电值</button></a>
                                <a href="{{url('admin/terminal/temperature').'/'.$v->Mac->mac.'/'.$projectCode}}" ><button type="button" class="btn btn-success w-min-xs  waves-effect waves-light "  >温度统计</button></a>
                            @endif
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


    <div class="modal fade" id="Band" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/terminal/band')}}">
                        {{ csrf_field() }}
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >设备通讯模块号（mac）：</label>
                        <div  style="float:left; width: 500px;">
                            <select class="form-control " name = 'mac' required id="mac" >

                                @foreach( $mac as $value)
                                <option value="{{$value->id}}"

                                        @if(isset($value->User->fullname))
                                        disabled
                                        @endif
                                >{{$value->mac}}

                                    @if(isset($value->User->fullname))
                                    ({{$value->User->fullname}})
                                    @endif

                                </option>
                                    @endforeach
                            </select>
                            <input type="hidden"  class="form-control" value="" id="companyId" name="companyId" >
                        </div>
                    </div>

                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary">提交</button>
                        </div>
                    </form>
                </div>


            </div>

        </div>
    </div>


    <script>
        //会为符合条件的现有标签和未来标签都绑定事件（将未来标签写道on方法里）

        $(function () {
            $("body").delegate('.table-striped tr', //会为符合条件的现有标签和未来标签都绑定事件
                'click', function () {

                    $('#companyId').val($('.table-striped tr').eq($(this).index()+1).find('.status').data('action'));
                });
        })

    </script>



@stop