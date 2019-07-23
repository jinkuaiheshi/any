@extends('admin.terminal_header')

@section('content')
    <div class="site-content">

        @foreach($data as $k=>$v)
            <div class="box box-block bg-white">
                <div class="form-group" style="height: auto; overflow: hidden;">

                </div>

                <table class="table table-striped table-bordered dataTable" id="tab" >
                    <thead>
                    <tr>
                        <th>{{$k}}
                            @if($type == 1)
                                月
                            @elseif($type == 2)
                                日
                            @elseif($type == 3)
                                日
                            @endif
                            电流统计(线路名)</th>

                        <th>电流值</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($v as $vv)
                        <tr>
                            <td>{{$vv->addr}}</td>
                            <td>{{$vv->currentValue}}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        @endforeach


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
        //会为符合条件的现有标签和未来标签都绑定事件（将未来标签写道on方法里）

        $(function () {
            $("body").delegate('.table-striped tr .shishi ', //会为符合条件的现有标签和未来标签都绑定事件
                'click', function () {
                    $.post("{{ url('/admin/ajax/getTerminalShishi') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.shishi').data('action'),
                        {'_token': '{{ csrf_token() }}'}, function(data) {
                            // $("#lan").val(data.lan);
                            // $("#Category").val(data.Category);
                            // $("#ControllerID").val(data.ControllerID);
                            // $("#SSID").val(data.SSID);
                            // $("#Version").val(data.Version);
                            // $('#str').html(data.str);
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