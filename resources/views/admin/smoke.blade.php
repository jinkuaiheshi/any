@extends('admin.smoke_header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">
                <a href="jacascript::void(0)" ><button type="button" class="  btn btn-primary w-min-sm m-b-1 waves-effect waves-light" style="float: right;display:inline-block" data-toggle="modal" data-target="#smoke" data-action="smoke">添加烟感设备</button></a>
            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>设备ID</th>
                    <th>设备名称</th>
                    <th>IMEI</th>
                    <th>产品ID</th>
                    <th>操作人</th>

                    <th>操作</th>


                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->id}}</td>
                        <td>{{$v->name}}</td>
                        <td>{{$v->IMEI}}</td>
                        <td>{{$v->cid}}</td>
                        <td>{{$v->User->fullname}}</td>
                        <td><a href="{{url('admin/smoke/dianliang/'.$v->cid)}}" ><button type="button" class="btn btn-purple w-min-xs  waves-effect waves-light"   >电量查询</button></a>
                            <a href="{{url('admin/smoke/yanwu/'.$v->cid)}}" ><button type="button" class="btn btn-warning w-min-xs  waves-effect waves-light "  >设备状态</button></a>
                            <a href="{{url('admin/smoke/nongdu/'.$v->cid)}}" ><button type="button" class="btn btn-warning w-min-xs  waves-effect waves-light "  >烟雾浓度</button></a>
                            <a href="{{url('admin/smoke/mute/'.$v->cid)}}" ><button type="button" class="btn btn-danger w-min-xs  waves-effect waves-light "  >设备消音</button></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>



    </div>

    <div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" id="dianliang" >
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >电量：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  readonly value="{{Session::get('dianliang')['value'].'%'}}"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >更新时间：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  readonly value="{{Session::get('dianliang')['time']}}"  >

                        </div>
                    </div>

                </div>


            </div>

        </div>
    </div>
    <div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" id="yanwu" >
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  style="text-align: left;" readonly value="

@if(Session::get('yanwu')['value'] == 7)正常@elseif(Session::get('yanwu')['value'] == 1)烟雾报警@elseif(Session::get('yanwu')['value'] == 2)设备静音@elseif(Session::get('yanwu')['value'] == 4)低压@elseif(Session::get('yanwu')['value'] == 5)传感器故障@elseif(Session::get('yanwu')['value'] == 8)指示模块已接收平台下发单次静音指令@elseif(Session::get('yanwu')['value'] == 9)指示模块已接收平台下发连续静音指令@elseif(Session::get('yanwu')['value'] == 10)拆卸报警@elseif(Session::get('yanwu')['value'] == 11)拆卸恢复@elseif(Session::get('yanwu')['value'] == 14)测试键在正常状态按下@elseif(Session::get('yanwu')['value'] == 15)测试键在低压状态按下@endif
                            " >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >更新时间：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  readonly value="{{Session::get('yanwu')['time']}}"  >

                        </div>
                    </div>
                    <div class="box box-block bg-white">
                        <div class="row">
                            <div class="col-md-12">

                                <div id="yanwuLog" class="chart-container"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态解释 1：</label>
                        <div  style="float:left; width: 500px;">
                            <input class="form-control" type="text"  readonly value="烟雾报警"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态解释 2：</label>
                        <div  style="float:left; width: 500px;">
                            <input class="form-control" type="text"  readonly value="设备静音"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态解释 4：</label>
                        <div  style="float:left; width: 500px;">
                            <input class="form-control" type="text"  readonly value="低压"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态解释 5：</label>
                        <div  style="float:left; width: 500px;">
                            <input class="form-control" type="text"  readonly value="传感器故障"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态解释 7：</label>
                        <div  style="float:left; width: 500px;">
                            <input class="form-control" type="text"  readonly value="正常"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态解释 8：</label>
                        <div  style="float:left; width: 500px;">
                            <input class="form-control" type="text"  readonly value="指示模块已接收平台下发单次静音指令"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态解释 9：</label>
                        <div  style="float:left; width: 500px;">
                            <input class="form-control" type="text"  readonly value="指示模块已接收平台下发连续静音指令"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态解释 10：</label>
                        <div  style="float:left; width: 500px;">
                            <input class="form-control" type="text"  readonly value="拆卸报警"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态解释 11：</label>
                        <div  style="float:left; width: 500px;">
                            <input class="form-control" type="text"  readonly value="拆卸恢复"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态解释 14：</label>
                        <div  style="float:left; width: 500px;">
                            <input class="form-control" type="text"  readonly value="测试键在正常状态按下"  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >状态解释 15：</label>
                        <div  style="float:left; width: 500px;">
                            <input class="form-control" type="text"  readonly value="测试键在低压状态按下"  >

                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
    <div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" id="nongdu" >
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >烟雾：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  readonly value="{{Session::get('nongdu')['value']}}" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >更新时间：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  readonly value="{{Session::get('nongdu')['time']}}"  >

                        </div>
                    </div>
                    <div class="box box-block bg-white">
                        <div class="row">
                            <div class="col-md-12">

                                <div id="nongduLog" class="chart-container"></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
    <div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" id="smoke" >
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/smoke/add')}}">
                        {{ csrf_field() }}
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >烟感名称：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text" name="name"  value="" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >设备唯一码：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="IMEI" value=""  >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >设备唯一ID：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="cid" value=""  >

                        </div>
                    </div>


                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
                </form>
            </div>

        </div>
    </div>
    @if(Session::has('dianliang'))
    <script>
        $(function(){
            $('#dianliang').modal();
        })
    </script>
    @endif
    @if(Session::has('nongdu'))
        <script>
            $(function(){
                $('#nongdu').modal();

            })
        </script>
        <script>

            var chart = Highcharts.chart('nongduLog', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: '设备三个月烟雾浓度'
                },
                xAxis: {
                    categories: {!! Session::get('time') !!},
                    labels:{ enabled: false}
                },

                plotOptions: {
                    line: {
                        dataLabels: {
                            // 开启数据标签
                            enabled: true
                        },
                        // 关闭鼠标跟踪，对应的提示框、点击事件会失效
                        enableMouseTracking: true
                    }
                },
                series: [{
                    name: '设备烟雾浓度值',
                    data: {!! Session::get('value') !!}
                }]
            });



        </script>
    @endif
    @if(Session::has('yanwu'))
        <script>
            $(function(){
                $('#yanwu').modal();

            })
        </script>
        <script>

            var chart = Highcharts.chart('yanwuLog', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: '设备三个月状态'
                },
                xAxis: {
                    categories: {!! Session::get('time') !!},
                    labels:{ enabled: false}
                },

                plotOptions: {
                    line: {
                        dataLabels: {
                            // 开启数据标签
                            enabled: true
                        },
                        // 关闭鼠标跟踪，对应的提示框、点击事件会失效
                        enableMouseTracking: true
                    }
                },
                series: [{
                    name: '设备状态值',
                    data: {!! Session::get('value') !!}
                }]
            });



        </script>
    @endif


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