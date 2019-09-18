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



                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->Company->name}}</td>

                        <td>{{$v->code}}</td>



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