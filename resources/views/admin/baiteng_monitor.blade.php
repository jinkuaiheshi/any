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
                    <th>CRCID</th>
                    <th>SimCard</th>
                    <th>设备类型</th>
                    <th>Name</th>
                    <th>设备所属公司</th>
                    <th>状态</th>
                    <th>设备详情</th>
                    <th>最后更新时间</th>
                    <th>报警日志</th>
                    <th>用电度数</th>

                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->ID}}</td>
                        <td>{{'Y'.$v->CRCID}}</td>
                        <td>{{$v->SimCard}}</td>
                        <td>{{$v->Protocol}}</td>
                        <td>{{$v->Name}}</td>
                        <td>{{$v->CustomerName}}</td>
                        <td>{{$v->OnlineText}}</td>
                        <td>{{$v->AlarmText}}</td>
                        <td>{{$v->UpdataDate}}</td>

                        <td>  <a href="{{url('admin/baiteng/alarm_info').'/'.$v->ID}}" ><button type="button" class="btn btn-info w-min-xs  waves-effect waves-light ">报警日志</button></a></td>
                        <td><a href="jacascript::void(0)" ><button type="button" class="btn btn-purple w-min-xs  waves-effect waves-light dian" data-toggle="modal" data-target="#dianliang" data-action="{{$v->ID}}">用电度数</button></a></td>
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


    <div class="modal fade" id="dianliang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >企业名称：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="name" readonly id="cname" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >企业名称：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="name" readonly id="cname" >

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
                    $.post("{{ url('/admin/ajax/getMonitorDianling') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.dian').data('action'),
                        {'_token': '{{ csrf_token() }}'}, function(data) {
                            $("#cname").val(data.name);

                        });
                });
        })

    </script>
@stop