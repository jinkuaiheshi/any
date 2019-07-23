@extends('admin.terminal_header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">

            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>线路名称</th>
                    <th></th>
                    <th>线路有效性</th>
                    <th>线路开关</th>
                    <th>远程控制</th>
                    <th>最后更新时间</th>
                    <th>通信</th>
                    <th>电量</th>
                    <th>过功门限值</th>
                    <th>过流门限值</th>
                    <th>类型</th>
                    <th>告警</th>
                    <th>线路规格</th>
                    <th>控制标记</th>

                    <th>操作</th>

                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->title}}</td>
                        <td>@if($v->gatherAddr == -1)
                                进线直连
                                @else
                                汇电线路
                            @endif

                        </td>
                        <td>@if($v->validity == true)
                                有效
                            @else
                                无效
                            @endif</td>
                        <td>@if($v->oc == true)
                                开
                            @else
                                关
                            @endif</td>
                        <td>@if($v->enableNetCtrl == true)
                                允许
                            @else
                                不允许
                            @endif</td>
                        <td>{{$v->updateTime}}</td>
                        <td>@if($v->online == true)
                                在线
                            @else
                                离线
                        @endif</td>
                        <td>{{$v->power}}</td>
                        <td>{{$v->mxgg}}</td>
                        <td>{{$v->mxgl}}</td>
                        <td>@if($v->lineType == 220)
                                单相
                            @elseif($v->lineType == 380)
                                三相
                            @endif</td>
                        <td>@if($v->alarm == 0 || $v->alarm == 128)
                                告警取消
                            @else
                                存在告警
                            @endif</td>
                        <td>{{$v->specification}}</td>


                        <td>@if($v->mainLine == 1)
                                总线
                            @else
                                非总线
                            @endif</td>





                        <td>
                            <a href="jacascript::void(0)" ><button type="button" class="btn @if($v->lineType == 220)
                                        btn-success
                                    @elseif($v->lineType == 380)
                                        btn-warning
                                    @endif w-min-xs  waves-effect waves-light shuju" data-toggle="modal" data-action="{{$v->addr}}" @if($v->lineType == 220)
                                        data-target= '#shuju220'
@elseif($v->lineType == 380)
                                        data-target= '#shuju380'
@endif
                                                                    >@if($v->lineType == 220)
                                        单相数据
                                    @elseif($v->lineType == 380)
                                        三相数据
                                    @endif</button></a>
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


    <div class="modal fade" id="shuju380" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >漏电流：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="gLd" readonly id="gLd" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >平均电流：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="gA" readonly id="gA" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >壳温度：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="gT" readonly id="gT" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >平均电压：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="gV" readonly id="gV" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;">
                        <label for="name" class=" col-form-label label200" >功率和值：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="gW" readonly id="gW" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >合相功率因素：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="gPF" readonly id="gPF" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >A相电流 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="aA" readonly id="aA" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >A相温度 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="aT" readonly id="aT" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >A相电压 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="aV" readonly id="aV" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >A相功率 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="aW" readonly id="aW" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >A 相功率因素 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="aPF" readonly id="aPF" >

                        </div>
                    </div>

                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >B相电流 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="bA" readonly id="bA" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >B相温度 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="bT" readonly id="bT" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >B相电压 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="bV" readonly id="bV" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >B相功率 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="bW" readonly id="bW" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >B 相功率因素 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="bPF" readonly id="bPF" >

                        </div>
                    </div>

                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >C相电流 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="cA" readonly id="cA" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >C相温度 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="cT" readonly id="cT" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >C相电压 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="cV" readonly id="cV" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >C相功率 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="cW" readonly id="cW" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >C 相功率因素 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="cPF" readonly id="cPF" >

                        </div>
                    </div>

                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >零线电流 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="nA" readonly id="nA" >

                        </div>
                    </div>

                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >零线温度 ：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="nT" readonly id="nT" >

                        </div>
                    </div>

                </div>


            </div>

        </div>
    </div>
    <div class="modal fade" id="shuju220" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >漏电流：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="aLd" readonly id="aLd" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >电流：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="dA" readonly id="dA" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >温度：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="dT" readonly id="dT" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >电压：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="dV" readonly id="dV" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;">
                        <label for="name" class=" col-form-label label200" >功率：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="dW" readonly id="dW" >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center;" >
                        <label for="name" class=" col-form-label label200" >功率因素：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="dPF" readonly id="dPF" >

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

                    $.post("{{ url('/admin/ajax/getTerminalShuju') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.shuju').data('action'),
                        {'_token': '{{ csrf_token() }}',
                            'mac': '{{$mac}}',
                            'projectCode': '{{$projectCode}}'
                           }
                        , function(data) {
                            console.log(data);
                            if(data['0'].lineType == 380){

                                $("#gLd").val(data['0'].gLd);
                                $("#gA").val(data['0'].gA);
                                $("#gT").val(data['0'].gT);
                                $("#gV").val(data['0'].gV);
                                $("#gW").val(data['0'].gW);
                                $('#gPF').val(data['0'].gPF);

                                $('#aA').val(data['0'].aA);
                                $('#aT').val(data['0'].aT);
                                $('#aV').val(data['0'].aV);
                                $('#aW').val(data['0'].aW);
                                $('#aPF').val(data['0'].aPF);

                                $('#bA').val(data['0'].bA);
                                $('#bT').val(data['0'].bT);
                                $('#bV').val(data['0'].bV);
                                $('#bW').val(data['0'].bW);
                                $('#bPF').val(data['0'].bPF);

                                $('#cA').val(data['0'].cA);
                                $('#cT').val(data['0'].cT);
                                $('#cV').val(data['0'].cV);
                                $('#cW').val(data['0'].cW);
                                $('#cPF').val(data['0'].cPF);

                                $('#nA').val(data['0'].nA);
                                $('#nT').val(data['0'].nT);
                            }else{
                                $('#aLd').val(data['0'].aLd);
                                $('#dA').val(data['0'].aA);
                                $('#dT').val(data['0'].aT);
                                $('#dV').val(data['0'].aV);
                                $('#dW').val(data['0'].aW);
                                $('#dPF').val(data['0'].aPF);
                            }




                        });
                });
        })

    </script>



@stop