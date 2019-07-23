@extends('admin.header')

@section('content')
    <div class="site-content">
        <div class="content-area p-y-1">
            <div class="container-fluid">
                <div class="box box-block bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-b-1">设备运行健康评分</h5>
                            <div class="box box-block bg-white">
                                <div class="form-group" style="height: auto; overflow: hidden;">

                                </div>
                                <table class="table table-striped table-bordered dataTable" id="tab" >

                                    <thead>
                                    <tr>
                                        <th>漏电回路评分</th>
                                        <th>电流回路A评分</th>
                                        <th>电流回路B评分</th>
                                        <th>电流回路C评分</th>
                                        <th>温度回路A信息</th>
                                        <th>温度回路B信息</th>
                                        <th>温度回路C信息</th>
                                        <th>温度回路D信息</th>
                                        <th>报警次数</th>
                                        <th>在线率</th>
                                        <th>处理速度</th>


                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td>{{$health['Level0']}}</td>
                                        <td>{{$health['Level1']}}</td>
                                        <td>{{$health['Level2']}}</td>
                                        <td>{{$health['Level3']}}</td>
                                        <td>{{$health['Level4']}}</td>
                                        <td>{{$health['Level5']}}</td>
                                        <td>{{$health['Level6']}}</td>
                                        <td>{{$health['Level7']}}</td>
                                        <td>{{$health['alarm']}}</td>
                                        <td>{{$health['online'].'%'}}</td>
                                        <td>{{$health['handled']}}</td>



                                    </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-area p-y-1">
            <div class="container-fluid">


                <div class="box box-block bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-b-1">漏电回路信息</h5>
                            <div id="line" class="chart-container"></div>
                        </div>
                    </div>
                </div>
                <div class="box box-block bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-b-1">电流回路信息</h5>
                            <div id="dianliu" class="chart-container"></div>
                        </div>
                    </div>
                </div>
                <div class="box box-block bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-b-1">温度回路信息</h5>
                            <div id="wendu" class="chart-container"></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script>

        var chart = Highcharts.chart('line', {
            chart: {
                type: 'line'
            },
            title: {
                text: '漏电回路信息'
            },

            xAxis: {
                categories: {!! $health['mAtime'] !!},
                    labels:{ enabled: false}
            },
            yAxis: {
                title: {
                    text: '毫安 (mA)'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        // 开启数据标签
                        enabled: false
                    },
                    // 关闭鼠标跟踪，对应的提示框、点击事件会失效
                    enableMouseTracking: true
                }
            },
            series: [{
                name: '漏电回路信息',
                data: {!! $health['mAdata'] !!}
            }]
        });



    </script>

    <script>

        var chart = Highcharts.chart('dianliu', {
            chart: {
                type: 'line'
            },
            title: {
                text: '电流回路信息'
            },

            xAxis: {
                categories:{!! $health['Atime'] !!},
                labels:{ enabled: false}
            },
            yAxis: {
                title: {
                    text: '安 (A)'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        // 开启数据标签
                        enabled: false
                    },
                    // 关闭鼠标跟踪，对应的提示框、点击事件会失效
                    enableMouseTracking: true
                }
            },
            series: [{
                name: '电流回路A信息',
                data: {!! $health['AdataA'] !!}
            },{
                name: '电流回路B信息',
                data: {!! $health['AdataB'] !!}
            },{
                name: '电流回路C信息',
                data: {!! $health['AdataC'] !!}
            }]
        });



    </script>

    <script>

        var chart = Highcharts.chart('wendu', {
            chart: {
                type: 'line'
            },
            title: {
                text: '温度回路信息'
            },

            xAxis: {
                categories:{!! $health['oCtime'] !!},
                labels:{ enabled: false}
            },
            yAxis: {
                title: {
                    text: '摄氏度 (°C)'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        // 开启数据标签
                        enabled: false
                    },
                    // 关闭鼠标跟踪，对应的提示框、点击事件会失效
                    enableMouseTracking: true
                }
            },
            series: [{
                name: '温度回路A信息',
                data: {!! $health['oCdataA'] !!}
            },{
                name: '温度回路B信息',
                data: {!! $health['oCdataB'] !!}
            },{
                name: '温度回路C信息',
                data: {!! $health['oCdataC'] !!}
            },{
                name: '温度回路D信息',
                data: {!! $health['oCdataD'] !!}
            }]
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