@extends('admin.header')

@section('content')
    <div class="site-content">


        <div class="box box-block bg-white">
            <div class="form-group" style="height: auto; overflow: hidden;">

            </div>
            <table class="table table-striped table-bordered dataTable" id="tab" >
                <thead>
                <tr>

                    <th>名称</th>
                    <th>省</th>
                    <th>市</th>
                    <th>区</th>
                    <th>街道</th>
                    <th>地址</th>
                    <th>开始时间</th>
                    <th>套餐年限</th>
                    <th>短信通知</th>


                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->name}}</td>
                        <td>{{$v->Province->name}}</td>
                        <td>{{$v->City->name}}</td>
                        <td>{{$v->Area->name or ''}}</td>
                        <td>{{$v->Street->name or ''}}</td>
                        <td>{{$v->address or ''}}</td>
                        <td>{{ date("Y-m-d",strtotime($v->create_time))}}</td>

                        <td>{{$v->year}}年</td>
                        <td><button type="button" class="btn btn-purple w-min-xs duanxin  waves-effect waves-light " data-action="{{date("Y-m-d",strtotime("+3 year",strtotime($v->create_time)))}}" data-company="{{$v->id}}" >发送短信</button></td>
                        
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>



    </div>
    <script>
        $(function () {
            $('.duanxin').click(function () {


                    $.post("{{ url('/admin/sub/taocan') }}",
                        {'_token': '{{ csrf_token()}}',
                            'year':$(this).data('action'),
                            'cid':$(this).data('company')
                        }, function(data) {
                            console.log(data);
                            if(data =='OK')
                                alert('短信推送已经发送')
                        });

            })
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