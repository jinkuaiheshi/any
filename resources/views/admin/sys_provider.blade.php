@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">
                <button type="button" class="  btn btn-primary w-min-sm m-b-1 waves-effect waves-light" style="float: right;display:inline-block" data-toggle="modal" data-target="#fuwushang">添加服务商</button>
            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>ID</th>
                    <th>服务商名称</th>
                    <th>代理级别</th>
                    <th>客服电话</th>
                    <th>联系人</th>

                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->id}}</td>
                        <td>{{$v->name}}</td>
                        <td>
                            @if($v->type >= 1)
                                <button type="button" class="btn btn-info w-min-xs  waves-effect waves-light " >{{$v->UserType->name}}</button>
                        @else
                                <button type="button" class="btn btn-default w-min-xs  waves-effect waves-light " >未设置</button>
                                @endif

                        </td>
                        <td>{{$v->service_no}}</td>
                        <td>{{$v->contact_name}}{{$v->contact_phone}}</td>

                        <td>
                            @if($v->is_superior == 1)
                                <a href="{{url('/admin/sys/provider/subordinate/').'/'.$v->id}}"><button type="button" class="btn btn-outline-info w-min-xs  waves-effect waves-light">下级代理</button></a>
                            @endif

                                @if($v->type)

                                    <a href="jacascript::void(0)"  disabled><button type="button" class="btn btn-warning w-min-xs  waves-effect waves-light daili" data-toggle="modal" data-target="#dailishezhi" data-action="{{$v->id}}" disabled>代理设置</button></a>
                                @else
                                    <a href="jacascript::void(0)" ><button type="button" class="btn btn-warning w-min-xs  waves-effect waves-light daili" data-toggle="modal" data-target="#dailishezhi" data-action="{{$v->id}}" >代理设置</button></a>

                                @endif

                            <a href="{{url('/admin/sys/provider/del/').'/'.$v->id}}" ><button type="button" class="btn btn-danger w-min-xs  waves-effect waves-light shanchu">删除</button></a>


                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>



    </div>

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


    <div class="modal fade" id="dailishezhi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 800px;">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/sys/provider/superior/up')}}">
                        {{ csrf_field() }}
                        <div class="form-group h-a" style="text-align: center">
                            <label for="order" class=" col-form-label label200" >服务商名称：</label>
                            <div  style="float:left; width: 250px;">
                                <input class="form-control" type="text"     id="pname"  readonly>
                                <input class="form-control" type="hidden"     id="pid" name="pid" readonly>
                            </div>
                        </div>

                        <div class="form-group h-a" style="text-align: center">
                            <label for="name" class=" col-form-label label200" >代理等级：</label>

                            <div  style="float:left; width: 250px;">
                                <select class="form-control " name = 'type' required id="type">
                                    <option value="0">请选择</option>
                                    @foreach ($userType as $v)
                                        <option value="{{$v->id}}" style="text-align: center;">{{$v->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group h-a" style="text-align: center;display: none;" id="sheng">
                            <label for="name" class=" col-form-label label200" >代理省：</label>
                            <div  style="float:left; width: 250px;">

                                <select class="form-control " name = 'province' required id="province">
                                    <option value="0">请选择</option>
                                    @foreach ($province as $v)
                                        <option value="{{$v->code}}" style="text-align: center;">{{$v->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group h-a" style="text-align: center;display: none;" id="shi">
                            <label for="name" class=" col-form-label label200" >代理市：</label>
                            <div  style="float:left; width: 250px;">

                                <select class="form-control " name = 'city' required id="city">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group h-a" style="text-align: center;display: none;" id="qu">
                            <label for="name" class=" col-form-label label200" >代理区：</label>
                            <div  style="float:left; width: 250px;">

                                <select class="form-control " name = 'area' required id="area">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group h-a" style="text-align: center;" >
                            <label for="name" class=" col-form-label label200" >上级代理：</label>
                            <div  style="float:left; width: 250px;">

                                <select class="form-control " name = 'is_superior' required id="is_superior">
                                    <option value="0">请选择</option>
                                    <option value="1">是</option>
                                    <option value="2">否</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group h-a" style="text-align: center; display: none" id="Bsuperior">
                            <label for="name" class=" col-form-label label200" >代理名称：</label>
                            <div  style="float:left; width: 250px;">
                                <select class="form-control " name = 'superior'  id="superior">
                                    @foreach($data as $v)
                                        <option value="{{$v->id}}">{{$v->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-primary">提交</button>
                        </div>
                    </form>
                </div>


            </div>

        </div>
    </div>

    <div class="modal fade" id="fuwushang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/sys/provider')}}">
                        {{ csrf_field() }}
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >服务商名称：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="fname"  id="fname" required >

                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="name" class=" col-form-label label200" >客服电话：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"  name="service_no"   required>

                        </div>
                    </div>

                    <div class="form-group h-a" style="text-align: center">
                        <label for="created_time" class=" col-form-label label200" >省：</label>
                        <div  style="float:left; width: 250px;">

                            <select class="form-control " name = 'fprovince' required id="fprovince">
                                <option value="0">请选择</option>
                                @foreach ($province as $v)
                                    <option value="{{$v->code}}" style="text-align: center;">{{$v->name}}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                    <div class="form-group h-a" style="text-align: center; height: auto;overflow: hidden;">
                        <label for="name" class=" col-form-label label200" >市：</label>
                        <div  style="float:left; width: 250px;">

                            <select class="form-control " name = 'fcity' required id="fcity">
                                <option value="0">请选择</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center; height: auto;overflow: hidden;" >
                        <label for="name" class=" col-form-label label200" >区：</label>
                        <div  style="float:left; width: 250px;">

                            <select class="form-control " name = 'farea' required id="farea">
                                <option value="0">请选择</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="order" class=" col-form-label label200" >详细地址：</label>
                        <div  style="float:left; width: 600px;">
                            <input class="form-control" type="text"     name="address" required >
                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="order" class=" col-form-label label200" >联系人：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"     name="contact_name"  >
                        </div>
                    </div>
                    <div class="form-group h-a" style="text-align: center">
                        <label for="order" class=" col-form-label label200" >联系电话：</label>
                        <div  style="float:left; width: 250px;">
                            <input class="form-control" type="text"     name="contact_phone"  >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>


                    </form>
                </div>


            </div>

        </div>
    </div>

    <script>
        $(function () {
            $("body").delegate('.shanchu', //会为符合条件的现有标签和未来标签都绑定事件
                'click', function () {
                    return confirm("是否确认删除服务商");
                });
        })
    </script>


    <script>
        //会为符合条件的现有标签和未来标签都绑定事件（将未来标签写道on方法里）

        $(function () {
            $("body").delegate('.table-striped tr', //会为符合条件的现有标签和未来标签都绑定事件
                'click', function () {
                    $.post("{{ url('/admin/ajax/setProvider') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.daili').data('action'),
                        {'_token': '{{ csrf_token() }}'}, function(data) {
                            $("#pname").val(data.name);
                            $("#pid").val(data.id);
                        });
                });
        })

    </script>
    <script>
        $(function(){
            $('#type').change(function() {

                if($('#type').val() == 4){
                    $('#sheng').show();
                    $('#shi').hide();
                    $('#qu').hide();
                }else
                    if($('#type').val() == 5){
                    $('#sheng').show();
                    $('#shi').show();
                    $('#qu').hide();
                }else
                    if($('#type').val() == 6){
                    $('#sheng').show();
                    $('#shi').show();
                    $('#qu').show();
                }else
                    if($('#type').val() == 3 ||$('#type').val() == 0 ||$('#type').val() >= 6){
                        $('#sheng').hide();
                        $('#shi').hide();
                        $('#qu').hide();
                    }

            });
            $('#province').change(function(){
                $.post("{{ url('/admin/ajax/getCity') }}/"+$('#province').val(),
                    {'_token': '{{ csrf_token()}}'
                    }, function(data) {
                        $('#city').html(data);
                    });
            })
            $('#fprovince').change(function(){
                $.post("{{ url('/admin/ajax/getCity') }}/"+$('#fprovince').val(),
                    {'_token': '{{ csrf_token()}}'
                    }, function(data) {
                        $('#fcity').html(data);
                    });
            })
            $('#city').change(function() {

                $.post("{{ url('/admin/ajax/getArea') }}/"+$('#city').val(),
                    {'_token': '{{ csrf_token()}}'
                    }, function(data) {
                        $('#area').html(data);
                    });
            });
            $('#fcity').change(function() {

                $.post("{{ url('/admin/ajax/getArea') }}/"+$('#fcity').val(),
                    {'_token': '{{ csrf_token()}}'
                    }, function(data) {
                        $('#farea').html(data);
                    });
            });
            $('#is_superior').change(function() {
                if($('#is_superior').val() == 1){
                    $('#Bsuperior').show();
                }else{
                    $('#Bsuperior').hide();
                }
            })
        })

    </script>
@stop