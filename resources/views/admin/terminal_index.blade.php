@extends('admin.terminal_header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">
                <a href="jacascript::void(0)" ><button type="button" class="  btn btn-primary w-min-sm m-b-1 waves-effect waves-light" style="float: right;display:inline-block" data-toggle="modal" data-target="#add" >添加设备</button></a>
            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>ID</th>

                    <th>创建时间</th>
                    <th>ProductKey</th>
                    <th>DeviceSecret</th>
                    <th>DeviceName</th>
                    <th>操作</th>


                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->id}}</td>

                        <td>{{$v->TimeStamp}}</td>
                        <td>{{$v->ProductKey}}</td>
                        <td>{{$v->DeviceSecret}}</td>
                        <td>{{$v->DeviceName}}</td>
                        <td>
                            <a href="jacascript::void(0)" ><button type="button" class="btn btn-info w-min-xs  waves-effect waves-light terminal" data-toggle="modal" data-target="#terminal" data-action="{{$v->id}}">详细信息</button></a>
                            <a href="{{url('admin/terminal/power').'/'.$v->id}}" ><button type="button" class="btn btn-warning w-min-xs  waves-effect waves-light ">功率</button></a>
                            <a href="{{url('admin/terminal/leakage').'/'.$v->id}}" ><button type="button" class="btn btn-purple w-min-xs  waves-effect waves-light ">漏电</button></a>
                            <a href="{{url('admin/terminal/temp').'/'.$v->id}}" ><button type="button" class="btn btn-primary w-min-xs  waves-effect waves-light ">温度</button></a>
                            <a href="jacascript::void(0)" ><button type="button" class="btn btn-success w-min-xs  waves-effect waves-light status" data-toggle="modal" data-target="#status" data-action="{{$v->id}}" >开关状态</button></a>
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


    <div class="modal fade" id="terminal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >设备上方方式：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="lan" readonly id="lan" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >设备类型：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="Category" readonly id="Category" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >设备ID：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="ControllerID" readonly id="ControllerID" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >SSID：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="SSID" readonly id="SSID" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;margin-bottom: 60px;">
                        <label for="name" class=" col-form-label label200" >设备版本：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="Version" readonly id="Version" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" id="str">
                        <label for="name" class=" col-form-label label200" >设备版本：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="Version" readonly id="str" >

                        </div>
                    </div>

                </div>


            </div>

        </div>
    </div>
    <div class="modal fade" id="status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="form-group h-a" style="text-align: center;" id="vstatus">
                        <label for="name" class=" col-form-label label200" ></label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"   >

                        </div>
                    </div>

                </div>


            </div>

        </div>
    </div>
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/terminal/add')}}">
                        {{ csrf_field() }}
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >ProductKey：</label>
                        <div  style="float:left; width: 450px;">
                            <input class="form-control" type="text"  name="ProductKey"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >DeviceSecret：</label>
                        <div  style="float:left; width: 450px;">
                            <input class="form-control" type="text"  name="DeviceSecret"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >DeviceName：</label>
                        <div  style="float:left; width: 450px;">
                            <input class="form-control" type="text"  name="DeviceName"  >

                        </div>
                    </div>

                        <div class="form-group h-a" style="text-align: center">
                            <label for="name" class=" col-form-label label200" >设备归属：</label>

                            <div  style="float:left; width: 250px;">
                                <select class="form-control " name = 'type' required id="type">
                                    <option value="0">请选择</option>
                                    <option value="1">服务商</option>
                                    <option value="2">企业</option>
                                </select>
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
            $("body").delegate('.table-striped tr .terminal ', //会为符合条件的现有标签和未来标签都绑定事件
                'click', function () {
                    $.post("{{ url('/admin/ajax/getTerminalInfo') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.terminal').data('action'),
                        {'_token': '{{ csrf_token() }}'}, function(data) {
                            $("#lan").val(data.lan);
                            $("#Category").val(data.Category);
                            $("#ControllerID").val(data.ControllerID);
                            $("#SSID").val(data.SSID);
                            $("#Version").val(data.Version);
                            $('#str').html(data.str);
                            console.log(data);
                        });
                });
        })

    </script>
    <script>
        //会为符合条件的现有标签和未来标签都绑定事件（将未来标签写道on方法里）

        $(function () {
            $("body").delegate('.table-striped tr .status', //会为符合条件的现有标签和未来标签都绑定事件
                'click', function () {
                    $.post("{{ url('/admin/ajax/getTerminalStatus') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.status').data('action'),
                        {'_token': '{{ csrf_token() }}'}, function(data) {
                            $('#vstatus').html(data.str);
                            console.log(data)
                        });
                });
        })

    </script>


@stop