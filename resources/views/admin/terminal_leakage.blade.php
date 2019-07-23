@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">

            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>ID</th>

                    <th>创建时间</th>
                    {{--<th>ProductKey</th>--}}
                    {{--<th>DeviceSecret</th>--}}
                    <th>DeviceName</th>
                    <th>操作</th>


                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->id}}</td>

                        <td>{{$v->TimeStamp}}</td>
                        {{--<td>{{$v->ProductKey}}</td>--}}
                        {{--<td>{{$v->DeviceSecret}}</td>--}}
                        <td>{{$v->DeviceName}}</td>
                        <td>
                            <a href="jacascript::void(0)" ><button type="button" class="btn btn-purple  w-min-xs  waves-effect waves-light leakage" data-toggle="modal" data-target="#terminal" data-action="{{$v->id}}">漏电详细信息</button></a>

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




                    <div class="form-group h-a" style="text-align: center;" id="str">
                        <label for="name" class=" col-form-label label200" ></label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="Version" readonly id="str" >

                        </div>
                    </div>

                </div>


            </div>

        </div>
    </div>
    <script>
        //会为符合条件的现有标签和未来标签都绑定事件（将未来标签写道on方法里）

        $(function () {
            $("body").delegate('.table-striped tr', //会为符合条件的现有标签和未来标签都绑定事件
                'click', function () {
                    $.post("{{ url('/admin/ajax/getTerminalLeakage') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.leakage').data('action'),
                        {'_token': '{{ csrf_token() }}'}, function(data) {


                            $('#str').html(data.str);
                            console.log(data);
                        });
                });
        })

    </script>
@stop