@extends('admin.lot_header_info')
@section('content')
    <!--右侧内容-->
    <div class="rightContents">

        <div class="rightBottom">
            <div class="rightBottomBox">

                <div class="rightTable">
                    <div class="tableBody">
                        <table class="table table-bordered  table-striped  dataTable " style="margin: 8px 0 0 0;table-layout:fixed" id="tab">
                            <thead>
                            <tr>
                                <th>线路名称</th>
                                <th>漏电流(毫安)</th>
                                <th>温度(摄氏度)</th>
                                <th>电流(安)</th>
                                <th>电压(伏)</th>
                                <th>功率(瓦)</th>
                                <th>状态</th>
                                <th>操作</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                                <tr>
                                    <td>{{$v->title}}</td>
                                    <td>@if($v->lineType == 220){{$v->aLd}}@else{{$v->gLd}}@endif</td>
                                    <td>@if($v->lineType == 220){{$v->aT}}@else A:{{$v->aT}} B:{{$v->bT}} C:{{$v->cT}}@endif</td>
                                    <td>{{$v->aA}}</td>
                                    <td>{{$v->aV}}</td>
                                    <td>{{$v->aW}}</td>
                                    <td>@if($v->oc==1)开@else关@endif</td>
                                    <td><a href="{{url('/admin/lot/open').'/'.$mac.'/'.$v->addr}}" ><button type="button" class="btn btn-success w-min-xs  waves-effect waves-light " @if($v->oc==1) disabled @endif  >合闸</button></a>
                                        <a href="{{url('/admin/lot/close').'/'.$mac.'/'.$v->addr}}" ><button type="button" class="btn btn-danger w-min-xs  waves-effect waves-light "  @if($v->oc!=1) disabled @endif>分闸</button></a></td>

                                </tr>
                            @endforeach
                            </tbody>


                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>



    </div>


    <script>
        $(function () {
            var toast = $('#toast-container');
            setTimeout(function () {
                toast.fadeOut(1000);
            },3000);
        })
    </script>
    <script>
        $(function() {
            $('.nav-item>a').on('click', function() {
                if($(this).next().css('display') == "none") {
                    //展开未展开
                    $('.nav-item').children('ul').slideUp(300);
                    $(this).next('ul').slideDown(300);
                    $(this).parent('li').addClass('nav-show').siblings('li').removeClass('nav-show');
                } else {
                    //收缩已展开
                    $(this).next('ul').slideUp(300);
                    $('.nav-item.nav-show').removeClass('nav-show');
                }
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
        <script>
            function myrefresh(){
                window.location.reload();
            }
            setTimeout('myrefresh()',5000); //指定1秒刷新一次
        </script>
        @endif
    </body>

    </html>
@stop