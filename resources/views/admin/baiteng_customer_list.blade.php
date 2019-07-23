@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">

            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>公司名称</th>
                    <th>登录名称</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>设备数量</th>
                    <th style="color: #950B02">设备报警数量</th>
                    <th style="color: #00A000">设备正常数量</th>
                    <th>设备离线数量</th>
                    <th>设备详情</th>


                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->Name}}</td>
                        <td>{{$v->LoginName}}</td>
                        <td>{{$v->CreateDate}}</td>
                        <td>{{$v->ChangeDate}}</td>
                        <td>{{$v->DetectorNum}}</td>
                        <td>{{$v->AlarmNum}}</td>
                        <td>{{$v->NormalNum}}</td>
                        <td>{{$v->OfflineNum}}</td>
                        <td>  <a href="{{url('admin/baiteng/customer_info').'/'.$v->ID}}" ><button type="button" class="btn btn-info w-min-xs  waves-effect waves-light ">设备一览</button></a></td>


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
            bStateSave:false,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5'

            ]
        } );
    </script>

    {{--<script>--}}
        {{--$(function(){--}}
            {{--$('.table-striped tr').click(function(){--}}
                {{--$.post("{{ url('/admin/ajax/getUserType') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.edit').data('action'),--}}
                    {{--{'_token': '{{ csrf_token() }}'}, function(data) {--}}


                        {{--$("#ename").val(data.name);--}}
                        {{--$("#created_time").val(data.created_time);--}}
                        {{--$("#order").val(data.orderBy);--}}
                        {{--$("#eid").val(data.id);--}}
                    {{--});--}}
            {{--})--}}
        {{--})--}}
    {{--</script>--}}
@stop