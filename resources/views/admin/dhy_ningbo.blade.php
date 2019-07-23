@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">

            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>

                    <th>设备</th>
                    <th>名称</th>
                    <th>地址</th>
                    <th>sim</th>
                    <th>电话</th>
                    <th>电话</th>
                    <th>电话</th>
                    <th>电话</th>


                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v['code']}}</td>
                        <td>{{$v['name']}}</td>
                        <td>{{$v['address']}}</td>
                        <td>{{$v['iccid']}}</td>
                        <td>{{$v['tel1']}}</td>
                        <td>{{$v['tel2']}}</td>
                        <td>{{$v['tel3']}}</td>
                        <td>{{$v['tel4']}}</td>



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