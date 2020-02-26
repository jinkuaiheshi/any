@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="yang-seach" >
                <form class="form-horizontal " method="get" enctype="multipart/form-data" action="{{url('/admin/operation/alarmlist')}}">
                    {{ csrf_field() }}
                    <div class="form-group" style="height: auto;overflow: hidden">

                        <label style="float: left; line-height: 2.5em;">设备状态:</label>
                        <div class="col-sm-2">
                            <select class="form-control m-b-1" name="status">
                                <option value="9"  @if($status == 9)
                                selected
                                        @endif

                                >全部</option>
                                <option value="2"  @if($status == 2)
                                selected
                                        @endif >离线</option>
                                <option value="3"  @if($status == 3)
                                selected
                                        @endif >过载</option>
                                <option value="4"  @if($status == 4)
                                selected
                                        @endif >超温</option>
                                <option value="5"  @if($status == 5)
                                selected
                                        @endif >漏电</option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label style="float: left; line-height: 2.5em;">所属省份:</label>
                        <div class="col-sm-2">
                            <select class="form-control m-b-1" name="province" id="province">
                                <option value="0">请选择</option>
                                @foreach( $province as $v)

                                <option value="{{$v->code}}"
                                    @if($prov)
                                        @if($v->code == $prov)
                                                            selected
                                        @endif

                                        @endif
                                    >{{$v->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-sm-2">
                            <select class="form-control m-b-1" name="city" id="city">
                                <option value="0">请选择</option>
                                @if($city)
                                    @foreach( $citys as $v)
                                        <option value="{{$v->code}}"  @if($v->code == $city)
                                        selected
                                                @endif
                                        >{{$v->name}}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                        <div class="col-sm-2">
                            <select class="form-control m-b-1" name="area" id="area">
                                <option value="0">请选择</option>
                                @if($area)
                                    @foreach( $areas as $v)
                                        <option value="{{$v->code}}"  @if($v->code == $area)
                                        selected
                                                @endif
                                        >{{$v->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <button type="submit" class="btn btn-warning" style="float: left
                                                ; margin-right: 20px; width: 100px;">查询</button>


                    </div>
                </form>
            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>企业</th>
                    <th>设备名称</th>
                    <th>地址</th>
                    <th></th>
                    <th></th>
                    <th>网关编号</th>
                    <th>SimCard</th>
                    <th>设备状态</th>
                    <th>离线时间/报警开始结束时间</th>

                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                <tr>
                    <td>{{$v['company_name']}}</td>
                    <td>{{$v['org_name']}}</td>
                    <td>{{$v['address']}}</td>
                    <td>{{$v['phone1']}}</td>
                    <td>{{$v['phone2']}}</td>


                    <td>{{$v['code']}}</td>
                    <td>{{$v['SimCard']}}</td>
                    <td>
                        @if( isset($v['alarm_type'])&&$v['alarm_type']=='Il1')
                            漏电
                            @elseif($v['alarm_type']=='t1' || $v['alarm_type']=='t2'|| $v['alarm_type']=='t3'||$v['alarm_type']=='t4' )
                            超温
                            @elseif($v['alarm_type']=='Ia'||$v['alarm_type']=='Ib'||$v['alarm_type']=='Ic')
                            过载
                            @elseif($v['alarm_type']=='offline')
                            离线
                        @endif

                    </td>
                    <td>{{$v['last_update_time']}}</td>

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
        $('#province').change(function() {

            $.post("{{ url('/admin/ajax/getCity') }}/"+$('#province').val(),
                {'_token': '{{ csrf_token()}}'
                }, function(data) {
                    $('#city').html(data);
                });
        });
        $('#city').change(function() {

            $.post("{{ url('/admin/ajax/getArea') }}/"+$('#city').val(),
                {'_token': '{{ csrf_token()}}'
                }, function(data) {
                    $('#area').html(data);
                });
        });
    </script>
        <script>
            $(function () {

                $('#tab').DataTable( {
                    dom: 'Bfrtip',
                    iDisplayLength: 25,
                    bStateSave:true,
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5'
                    ]

                } );

            })
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