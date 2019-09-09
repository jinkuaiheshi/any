@extends('admin.lot_header')
@section('content')

        <div class="rightContentBox">
            <div class="rightContent">
                <div class="listNav clearfix">
                    <ul>
                        <li class="fl">
                            <a href="{{url('/admin/lot')}}" class="active">首页</a>
                            <span class="grayColor">&nbsp;/&nbsp;</span>
                        </li>

                        <li class="fl">
                            <a href="#" class="whiteColor">设备列表</a>
                        </li>
                    </ul>
                </div>
                <div class="list clearfix marginBtm15">

                    <div class="listProject clearfix">
                        <ul>
                            @foreach($pro as $value)
                                <a href="{{url('/admin/lot/power').'/'.$value['mac']}}">
                                    <li class="fl">
                                        <div class="top clearfix">
                                            <div class="fl"><i class="backImg"></i>&nbsp;
                                                <div class="floor">{{$value['address']}}</div>
                                            </div>
                                            <div class="btnDetail fl"><i class="backImg1 fl"></i><span class="fl">详情</span></div>
                                        </div>
                                        <div class="center clearfix">
                                            <div class="img fl"><img src=" @if($value['online'] == 0){{asset('resources/assets/lot/images/alerm.png')}}
                                                @elseif($value['online'] == 1){{asset('resources/assets/lot/images/smile.png')}}
                                                @endif"  /></div>

                                            <div class="centerTitle @if($value['online'] == 0)redColor
        @elseif($value['online'] == 1)greenColor
        @endif fl">@if($value['online'] == 0)离线@elseif($value['online'] == 1)在线@else未曾上线@endif
                                            </div>
                                        </div>
                                        <div class="time">{{$value['time']}}</div>
                                    </li>
                                </a>
@endforeach

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<script src=""{{asset('resources/assets/lot/js/jquery-3.4.1.min.js')}}></script>
<!-- 包括所有已编译的插件 -->
<script src=""{{asset('resources/assets/lot/js/bootstrap.min.js')}}></script>
<script>
    $(function() {
        // nav收缩展开
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
        // 右侧内容盒子的宽度
        var winHeight = $(window).height();
        $('.bottomContent').height(winHeight - 50);
        $('.rightBottom').height(winHeight - 128);
        $('.rightBottomBox').height(winHeight - 128);
    });
</script>
</body>

</html>
@stop