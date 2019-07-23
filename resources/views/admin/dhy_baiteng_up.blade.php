@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">

            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>

                    <th>CRCID</th>
                    <th>SimCard</th>
                    <th>监控点组</th>
                    <th>监控点名称</th>
                    <th>公司名称</th>
                    <th>设备状态</th>




                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{'Y'.$v->CRCID}}</td>
                        <td>{{$v->SimCard}}</td>
                        <td>{{$v->GroupName}}</td>
                        <td>{{$v->Name}}</td>
                        <td>{{$v->CustomerName}}</td>
                        <td>{{$v->OnlineText}}</td>




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