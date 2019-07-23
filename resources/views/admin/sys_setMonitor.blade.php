@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">
                <button type="button" class="  btn btn-primary w-min-sm m-b-1 waves-effect waves-light" style="float: right;display:inline-block" data-toggle="modal" data-target="#fuwushang">添加监控组</button>
                <button type="button" class="  btn btn-primary w-min-sm m-b-1 m-r-1 waves-effect waves-light" style="float: right;display:inline-block" data-toggle="modal" data-target="#fuwushang">添加监控点</button>
            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>ID</th>

                    <th>监控点名称</th>
                    <th>设备名称</th>
                    <th>激活时间</th>
                    <th>服务年限</th>
                    <th>所属监控组</th>
                    <th>操作</th>


                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v['id']}}</td>
                        <td>{{$v['name']}}</td>
                        <td>{{$v['code']}}</td>
                        <td>{{$v['start_time']}}</td>
                        <td>{{$v['term']}}年</td>
                        <td><button type="button" class="btn btn-default w-min-xs  waves-effect waves-light look">{{$v['parentName']}}</button></td>
                        <td><a href="" ><button type="button" class="btn btn-info w-min-xs  waves-effect waves-light ">配置</button></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>



    </div>

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
        $(function () {
            $("body").delegate('.shanchu', //会为符合条件的现有标签和未来标签都绑定事件
                'click', function () {
                    return confirm("是否确认删除服务商");
                });
        })
    </script>


    <script>
        //会为符合条件的现有标签和未来标签都绑定事件（将未来标签写道on方法里）

        $(function () {
            $("body").delegate('.table-striped tr', //会为符合条件的现有标签和未来标签都绑定事件
                'click', function () {
                    $.post("{{ url('/admin/ajax/setProvider') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.daili').data('action'),
                        {'_token': '{{ csrf_token() }}'}, function(data) {
                            $("#pname").val(data.name);
                            $("#pid").val(data.id);
                        });
                });
        })

    </script>

@stop