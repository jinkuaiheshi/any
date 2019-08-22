@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">

            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>

                    <th>id</th>
                    <th>时间</th>
                    <th>总报警次数</th>
                    <th>总报警单位数量</th>
                    <th>总过载报警次数</th>
                    <th>总超温报警次数</th>
                    <th>总漏电报警次数</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->id}}</td>
                        <td>{{$v->day}}</td>
                        <td>{{$v->alarm_count}}</td>
                        <td>{{$v->alarm_company}}</td>
                        <td>{{$v->alarm_Il}}</td>
                        <td>{{$v->alarm_t}}</td>
                        <td>{{$v->alarm_I}}</td>
                        <td><a href="jacascript::void(0)" ><button type="button" class="btn btn-info w-min-xs  waves-effect waves-light info" data-toggle="modal" data-target="#info" data-action="{{$v->id}}">详细数据</button></a></td>

                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>



    </div>

    <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document" style="max-width: 1200px;">
            <div class="modal-content">
                <div class="modal-body">
                            <table class="table table-striped table-bordered dataTable" id="baojing" >
                                <thead>
                                <tr>

                                    <th>编号</th>
                                    <th>报警类型</th>
                                    <th>报警值</th>
                                    <th>开始时间</th>
                                    <th>结束时间</th>
                                    <th>持续时间</th>
                                    <th>单位</th>
                                    <th>阀值</th>

                                </tr>
                                </thead>
                                <tbody id="fofo">
                                {{--@if($datas)--}}
                                {{--@foreach($datas as $v)--}}
                                    {{--<tr>--}}
                                        {{--<td>{{$v->code}}</td>--}}
                                        {{--<td>{{$v->code}}</td>--}}


                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                    {{--@endif--}}
                                </tbody>
                            </table>
            </div>

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

    <script>
        //会为符合条件的现有标签和未来标签都绑定事件（将未来标签写道on方法里）

        $(function () {
            $("body").delegate('.table-striped tr', //会为符合条件的现有标签和未来标签都绑定事件
                'click', function () {
                    $.post("{{ url('/admin/jingbao/info') }}/"+ $('.table-striped tr').eq($(this).index()+1).find('.info').data('action'),
                        {'_token': '{{ csrf_token() }}'}, function(data) {

                            $('#fofo').html(data);
                            $('#baojing').DataTable( {
                                dom: 'Bfrtip',
                                iDisplayLength: 15,
                                bStateSave:true,

                                buttons: [
                                    'copyHtml5',
                                    'excelHtml5',
                                    'csvHtml5'
                                ]
                            } );
                        });
                });
        })

    </script>

@stop