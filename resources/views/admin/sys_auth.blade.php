@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">
                <button type="button" class="  btn btn-primary w-min-sm m-b-1 waves-effect waves-light" style="float: right;display:inline-block" data-toggle="modal" data-target="#exampleModal">添加用户组</button>
            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>
                    <th>ID</th>
                    <th>用户组名称</th>
                    <th>创建时间</th>
                    <th>排序</th>
                    <th>操作</th>

                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->name}}</td>
                <td>{{$v->created_time}}</td>
                <td>{{$v->orderBy}}</td>
                <td>
                    <a href="{{url('/admin/sys/user/auth/del/').'/'.$v->id}}" ><button type="button" class="btn btn-danger w-min-xs  waves-effect waves-light yonghu">删除</button></a>
                    <a href="jacascript::void(0)" ><button type="button" class="btn btn-success w-min-xs  waves-effect waves-light edit" data-toggle="modal" data-target="#edit" data-action="{{$v->id}}">编辑</button></a>
                </td>


                </tr>
                @endforeach
                </tbody>
            </table>

        </div>



    </div>

    <script>
        $(function(){
            $(".yonghu").click(function(){
                return confirm("是否确认删除用户组");
            });
        });
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 800px;">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/sys/user/auth/add')}}">
                        {{ csrf_field() }}
                        <div class="form-group h-a" style="text-align: center">
                            <label for="name" class=" col-form-label label200" >用户组名称：</label>
                            <div  style="float:left; width: 250px;">
                                <input class="form-control" type="text"  placeholder="请输入用户组名称" name="name" required onKeyUp="if(this.value.length>16) this.value=this.value.substr(0,16)" >
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


    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 800px;">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/sys/user/auth/up')}}">
                        {{ csrf_field() }}
                        <div class="form-group h-a" style="text-align: center">
                            <label for="name" class=" col-form-label label200" >用户组名称：</label>
                            <div  style="float:left; width: 250px;">
                                <input class="form-control" type="text"  placeholder="请输入用户组名称" name="name" required id="ename" >
                                <input class="form-control" type="hidden"   name="id" required id="eid" >
                            </div>
                        </div>

                        <div class="form-group h-a" style="text-align: center">
                            <label for="created_time" class=" col-form-label label200" >创建时间：</label>
                            <div  style="float:left; width: 250px;">
                                <input class="form-control" type="text"  placeholder="请输入创建时间" name="created_time" readonly id="created_time" >
                            </div>
                        </div>

                        <div class="form-group h-a" style="text-align: center">
                            <label for="order" class=" col-form-label label200" >排序：</label>
                            <div  style="float:left; width: 250px;">
                                <input class="form-control" type="text"  placeholder="请输入排序值" name="order" required id="order" >
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
        $(function(){
            $('.table-striped tr').click(function(){
                $.post("{{ url('/admin/ajax/getUserType') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.edit').data('action'),
                    {'_token': '{{ csrf_token() }}'}, function(data) {


                        $("#ename").val(data.name);
                        $("#created_time").val(data.created_time);
                        $("#order").val(data.orderBy);
                        $("#eid").val(data.id);
                    });
            })
        })
    </script>
@stop