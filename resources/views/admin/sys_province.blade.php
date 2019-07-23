@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">

            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>ID</th>
                    <th>行政区域编码</th>
                    <th>名称</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($province as $v)
                <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->code}}</td>
                <td>{{$v->name}}</td>
                <td>
                    <a href="{{url('/admin/sys/city').'/'.$v->id}}" ><button type="button" class="btn btn-info w-min-xs  waves-effect waves-light city">城市管理</button></a>
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
    <script>
        $(function () {
            var toast = $('#toast-container');
            setTimeout(function () {
                toast.fadeOut(1000);
            },3000);
        })
    </script>


@stop