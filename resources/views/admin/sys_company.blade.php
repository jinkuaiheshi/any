@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">

            <div class="form-group" style="height: auto; overflow: hidden;">
                <a href="{{url('/admin/sys/company/add')}}" ><button type="button" class="  btn btn-primary w-min-sm m-b-1 waves-effect waves-light" style="float: right;display:inline-block" >添加企业</button></a>
            </div>
            <div class="yang-seach" >
                <form class="form-horizontal " method="get" enctype="multipart/form-data" action="{{url('/admin/sys/company')}}">
                    {{ csrf_field() }}

                    <div class="form-group" style="height: auto;overflow: hidden">
                        <label style="float: left; line-height: 2.5em;">所属省份:</label>
                        <div class="col-sm-2">
                            <select class="form-control m-b-1" name="province" id="province">
                                <option value="0">请选择</option>
                                @foreach( $provinces as $v)
                                    <option value="{{$v->code}}"
                                    @if($province == $v->code )
                                        selected
                                            @endif
                                    >{{$v->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <label style="float: left; line-height: 2.5em;">所属市:</label>
                        <div class="col-sm-2">
                            <select class="form-control m-b-1" name="city" id="city">
                                <option value="0">请选择</option>
                                @if(isset($citys))
                                    @if($citys != '')
                                        @foreach( $citys as $v)
                                            <option value="{{$v->code}}"
                                                    @if($city == $v->code )
                                                    selected
                                                    @endif
                                            >{{$v->name}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>

                        </div>
                        <label style="float: left; line-height: 2.5em;">所属区:</label>
                        <div class="col-sm-2">
                            <select class="form-control m-b-1" name="area" id="area">
                                <option value="0">请选择</option>
                                @if(isset($areas))
                                    @if($areas != '')
                                        @foreach( $areas as $v)
                                        <option value="{{$v->code}}"
                                                @if($area == $v->code )
                                                selected
                                                @endif
                                        >{{$v->name}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>
                        <label style="float: left; line-height: 2.5em;">所属街道:</label>
                        <div class="col-sm-2">
                            <select class="form-control m-b-1" name="street" id="street">
                                <option value="0">请选择</option>
                                @if(isset($streets))
                                    @if($streets != '')
                                        @foreach( $streets as $v)
                                            <option value="{{$v->code}}"
                                                    @if($street == $v->code )
                                                    selected
                                                    @endif
                                            >{{$v->name}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning w-min-sm" style="float: left
                                                ; margin-right: 20px; ">查询</button>
                    </div>
                        <div class="form-group">

                        </div>
                </form>
            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>企业编号</th>

                    <th>创建时间</th>
                    <th>企业名片</th>
                    <th>规划街道</th>
                    <th>操作</th>




                </tr>
                </thead>
                <tbody>
                @foreach($company as $v)
                    <tr>
                        <td>{{$v->id}}</td>
                        <td>{{$v->name}}</td>
                        <td>{{$v->code}}</td>

                        <td>{{$v->create_time}}</td>
                        <td><a href="jacascript::void(0)" ><button type="button" class="btn btn-purple w-min-xs  waves-effect waves-light look" data-toggle="modal" data-target="#mingpian" data-action="{{$v->id}}">查看企业名片</button></a></td>
                        <td>
                            @if(isset($v->street_code))
                                是
                                @else
                                否
                                @endif
                        </td>
                        <td>
                            <a href="{{url('/admin/sys/company/edit/').'/'.$v->id}}" ><button type="button" class="btn btn-info w-min-xs  waves-effect waves-light ">信息管理</button></a>
                            <a href="{{url('/admin/sys/company/setMonitor/').'/'.$v->id}}" ><button type="button" class="btn btn-danger w-min-xs  waves-effect waves-light ">监控点设置</button></a>
                            {{--<a href="{{url('/admin/sys/user/auth/del/').'/'.$v->id}}" ><button type="button" class="btn btn-danger w-min-xs  waves-effect waves-light company">删除</button></a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>



    </div>

    <div class="modal fade" id="mingpian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
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
                            <label for="created_time" class=" col-form-label label200" >归属区域：</label>
                            <div  style="float:left; width: 100px; ">
                                <input class="form-control" type="text"    readonly id="prov" style="text-align: center" >
                            </div>
                            <div  style="float:left; width: 100px;">
                                <input class="form-control" type="text"    readonly id="citycity" style="text-align: center"  >
                            </div>
                            <div  style="float:left; width: 100px;">
                                <input class="form-control" type="text"   readonly id="areaarea" style="text-align: center"  >
                            </div>
                            <div  style="float:left; width: 300px;">
                                <input class="form-control" type="text"   readonly id="streetstreet" style="text-align: center"  >
                            </div>
                        </div>

                        <div class="form-group h-a" style="text-align: center">
                            <label for="order" class=" col-form-label label200" >详细地址：</label>
                            <div  style="float:left; width: 600px;">
                                <input class="form-control" type="text"     id="add" readonly>
                            </div>
                        </div>
                        <div class="form-group h-a" style="text-align: center">
                            <label for="order" class=" col-form-label label200" >企业图片：</label>
                            <div  style="float:left; width: 400px;">
                                <img  id="pic" style="width: 100%;">
                            </div>
                        </div>



                </div>


            </div>

        </div>
    </div>


    <script>
        $(function () {
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

            $('#area').change(function() {

                $.post("{{ url('/admin/ajax/getStreet') }}/"+$('#area').val(),
                    {'_token': '{{ csrf_token()}}'
                    }, function(data) {
                        $('#street').html(data);
                    });
            });
        })
    </script>
    <script>
        //会为符合条件的现有标签和未来标签都绑定事件（将未来标签写道on方法里）

        $(function () {
            $("body").delegate('.table-striped tr', //会为符合条件的现有标签和未来标签都绑定事件
                'click', function () {
                    $.post("{{ url('/admin/ajax/getCompanyInfo') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.look').data('action'),
                        {'_token': '{{ csrf_token() }}'}, function(data) {
                            $("#cname").val(data.name);
                            $("#add").val(data.add);
                            $("#pic").attr("src",data.pic);
                            $("#prov").val(data.province);
                            $("#citycity").val(data.city);
                            $("#areaarea").val(data.area);
                            $("#streetstreet").val(data.street);


                        });
                });
        })

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
    <script>
        $(function () {
            var toast = $('#toast-container');
            setTimeout(function () {
                toast.fadeOut(1000);
            },3000);
        })
    </script>


@stop