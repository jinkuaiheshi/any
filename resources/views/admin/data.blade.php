@extends('admin.header')

@section('content')
    <div class="site-content">
        <!-- Content -->
        <div class="content-area p-y-1" >
            <div class="container-fluid">

                <ol class="breadcrumb no-bg m-t-1 m-b-1" >
                    <li class="breadcrumb-item"><a href="{{url('/admin/index')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/data')}}">Data</a></li>
                    <li class="breadcrumb-item active">data</li>
                </ol>

            </div>

        </div>

        <div class="box box-block bg-white">

            <table class="table table-striped table-bordered dataTable" id="user_tab">
                <thead>
                <tr>
                    <th>发生时间</th>
                    <th>操作人</th>
                    <th>操作对象（结果）</th>
                    <th>操作方法</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>{{$v->created_time}}</td>
                        <td>{{$v->do_admin}}</td>
                        <td>{{$v->user}}</td>
                        <td>{{$v->title}}</td>
                        <td>{{$v->controller}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <script>
            $(function () {

                $('#user_tab').DataTable( {
                    "ordering": false,
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5'
                    ]
                } );

            })
        </script>

@stop