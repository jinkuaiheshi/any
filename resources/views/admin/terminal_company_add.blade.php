@extends('admin.terminal_header')

@section('content')

    <link href="http://jiaxunweb.oss-cn-shenzhen.aliyuncs.com/Frame/m4_6/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="http://jiaxunweb.oss-cn-shenzhen.aliyuncs.com/Frame/m4_6/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

    <div class="site-content">


        <div class="box box-block bg-white">

            <p class="font-90 text-muted m-b-3"></p>

            <div class="row">
                <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/terminal/company/add')}}">
                    {{ csrf_field() }}

                    <div class="col-md-12">
                        <div class="form-group h-a" style="text-align: center">
                            <div class="col-md-3" style="text-align: right">
                                <label for="order" class=" col-form-label " >服务商名称：</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control " name = 'provider' required id="provider">

                                    @foreach ($provider as $v)
                                        <option value="{{$v->id}}" style="text-align: center;"
                                        >{{$v->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="form-group h-a" style="text-align: center">
                            <div class="col-md-3" style="text-align: right">
                                <label for="order" class=" col-form-label " >企业名称：</label>
                            </div>
                            <div class="col-md-6">
                                <div   class="form-group">
                                    <input type="text" placeholder="" class="form-control" name="name" required >
                                </div>
                            </div>
                        </div>
                        <div class="form-group h-a" style="text-align: center">
                            <div class="col-md-3" style="text-align: right">
                                <label for="order" class=" col-form-label " >用户名：</label>
                            </div>
                            <div class="col-md-6">
                                <div   class="form-group">
                                    <input type="text" placeholder="" class="form-control" name="username" required >
                                </div>
                            </div>
                        </div>

                        <div class="form-group h-a" style="text-align: center">
                            <div class="col-md-3" style="text-align: right">
                                <label for="order" class=" col-form-label " >所属省：</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control " name = 'province' required id="province" >
                                    <option value="0">请选择</option>
                                    @foreach ($province as $v)
                                        <option value="{{$v->code}}" style="text-align: center;"
                                        >{{$v->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group h-a" style="text-align: center">
                            <div class="col-md-3" style="text-align: right">
                                <label for="order" class=" col-form-label " >所属市：</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control "  name="city" id="city">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group h-a" style="text-align: center">
                            <div class="col-md-3" style="text-align: right">
                                <label for="order" class=" col-form-label " >所属区：</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control " id="area" name="area">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group h-a" style="text-align: center">
                            <div class="col-md-3" style="text-align: right">
                                <label for="order" class=" col-form-label " >所属街道：</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control " name="street" id="street">
                                    <option value="0"> 请选择</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group h-a" style="text-align: center">
                            <div class="col-md-3" style="text-align: right">
                                <label for="order" class=" col-form-label " >输入关键字获取坐标：</label>
                            </div>
                            <div class="col-md-6">
                                <select type="text" id="keyword" class="form-control select2"></select>
                                <input type="hidden" name="lng" id="lng" value="" placeholder="经度" maxlength="18">
                                <input type="hidden" name="lat" id="lat" value="" placeholder="纬度" maxlength="18">
                                <div id="container" style="width: 100%;height: 400px"></div>
                            </div>
                        </div>

                        <script src="http://cdn.staticfile.org/plupload/2.1.1/plupload.full.min.js" type="text/javascript"></script>
                        <script src="http://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js" type="text/javascript"></script>
                        <script src="http://jiaxunweb.oss-cn-shenzhen.aliyuncs.com/Frame/m4_6/plugins/select2/js/select2.min.js" type="text/javascript"></script>
                        <script src="http://jiaxunweb.oss-cn-shenzhen.aliyuncs.com/Frame/m4_6/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
                        <script src="http://jiaxunweb.oss-cn-shenzhen.aliyuncs.com/Frame/m4_6/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
                        <script src="http://jiaxunweb.oss-cn-shenzhen.aliyuncs.com/Frame/m4_6/scripts/jquery.form.js"></script>
                        <script src="http://map.qq.com/api/js?v=2.exp&key=KM6BZ-AKTRX-SGN4D-72YUQ-Q7K6T-Z2FIO"></script>



                        <div class="form-group h-a" style="text-align: center">
                            <div class="col-md-3" style="text-align: right">
                                <label for="order" class=" col-form-label " >详细地址：</label>
                            </div>
                            <div class="col-md-6">
                                <div   class="form-group">
                                    <input type="text" placeholder="" class="form-control" name="address" value="">
                                </div>
                            </div>
                        </div>
















                        <div class="form-group h-a" style="text-align: center">
                            <div class="col-md-3" style="text-align: right">
                                <label for="order" class=" col-form-label " >上传企业图片</label>
                            </div>
                            {{--<div class="col-md-6" style="width: 300px;">--}}
                            {{--<div   class="form-group">--}}
                            {{--<input type="file" class="form-control" name="picture" value="" >--}}
                            {{--</div>--}}
                            {{--</div>--}}


                            <div class="col-md-6" >
                                <div style="position: relative;width: 200px; height: 200px; background:url('http://img.anyzeal.cn/noPicture.png?imageMogr2/thumbnail/x200/interlace/1'); ">

                                    <img src="" alt="" id="avatar_img"
                                         style="width: 200px;height: 200px;left:0;top: 0;"/>


                                    <input type="file" id="avatar_file" name="avatar_file"
                                           accept="image/jpg,image/png,image/gif"
                                           style="width: 100%;height:100%;opacity: 0;position: absolute;left:0;top: 0;"/>
                                </div>
                                <input value="" id="pic" name="pic" type="hidden">
                            </div>


                        </div>

                        <div class="form-group h-a" style="text-align: center">
                            <div class="col-md-3" style="text-align: right">
                                <label for="order" class=" col-form-label " >备注信息：</label>
                            </div>
                            <div class="col-md-6">
                                <div   class="form-group">

                                    <textarea class="form-control" name="remark"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="javascript:history.back(-1);">取消</button>
                            <button type="submit" class="btn btn-primary">提交</button>
                        </div>

                    </div>
                </form>
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
        $("#avatar_file").change(function () {
            // 获取上传文件对象
            var file = $(this)[0].files[0];
            // 读取文件URL
            var reader = new FileReader();
            reader.readAsDataURL(file);
            // 阅读文件完成后触发的事件
            reader.onload = function () {
                // 读取的URL结果：this.result
                $("#avatar_img").attr("src", this.result);
                $("#pic").val(this.result);
            }
        });
    </script>
    <style>
        .select2-container{
            width: 100%;
        }
    </style>
    <script>
        $(function () {
            $('#area').change(function() {
                console.log($('#area').val());
                $.post("{{ url('/admin/ajax/getStreet') }}/"+$('#area').val(),
                    {'_token': '{{ csrf_token()}}'
                    }, function(data) {
                        $('#street').html(data);
                    });
            });

        })
    </script>

    <script>
        $(function () {

            var toast = $('#toast-container');
            setTimeout(function () {
                toast.fadeOut(1000);
            },3000);
        })
    </script>
    <script>
        var msgInfo = null;
        $(document).ready(function() {
            initSkeyword();
        });
        var map = null,markers = [];
        /**
         * 地图搜索下拉框
         */
        function initSkeyword() {
            var lat = parseFloat('');
            var lng = parseFloat('');
            var center = new qq.maps.LatLng(30.243530,120.182830);
            if(lat && lat){
                center = new qq.maps.LatLng(lat,lng);
            }
            map = new qq.maps.Map(document.getElementById("container"),{
                center:center,
                scrollwheel: false,
                zoom:13
            });
            createMarker(center);
            var selectKeyword = $("#keyword").select2({
                width: "off",
                placeholder: '请输入关键字查询',
                language: "zh-CN",//汉化
                ajax: {
                    url: 'http://apis.map.qq.com/ws/place/v1/suggestion/?key=Z2WBZ-JOTWP-C5LDN-VM44L-QOPDE-MXFI4&output=jsonp',
                    dataType:'jsonp',
                    jsonp:'callback',
                    delay: 250,
                    data: function(params) {
                        return {
                            keyword: params.term, // search term
                        };
                    },
                    processResults: function(data, page) {
                        var results = [];
                        if(data.status == 0){
                            $.each(data.data, function (i, v) {
                                results.push(v);
                            })
                        }
                        return {
                            results: results
                        };
                    },
                    cache: true
                },
                formatNoResults: function () {
                    return "没有匹配的结果";
                },
                formatAjaxError: function () {
                    return "ajax加载错误";
                },
                escapeMarkup: function(markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo(repo) {
                if (repo.loading) return repo.text;
                return "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__meta' style='margin-left: 0'>" +
                    "<div class='select2-result-repository__title'>" + repo.title + "</div>"+
                    "<div class='select2-result-repository__description'>" + repo.address + "</div>"+
                    "</div></div>";
            }

            function formatRepoSelection(repo) {
                if(repo.location){
                    var location = repo.location;
                    $('#lat').val(location.lat);
                    $('#lng').val(location.lng);
                    $('#address').val(repo.address);
                }
                return repo.title || repo.address || repo.text;
            }

            /**
             * 选中后更新地图
             */
            $("#keyword").on("change",function (e){
                var lat = parseFloat($('#lat').val());
                var lng = parseFloat($('#lng').val());
                var center = new qq.maps.LatLng(lat, lng);
                map.panTo(center);
                map.zoomTo(15);
                createMarker(center);
            })
        }

        /**
         * 创建marker
         * @param center
         */
        function createMarker(center) {
            //清除覆盖物
            $.each(markers,function (k,v) {
                v.setMap(null);
            });
            markers = [];
            //创建marker
            var newMarker = new qq.maps.Marker({
                draggable:true,
                position: center,
                map: map
            });
            //设置Marker停止拖动事件
            qq.maps.event.addListener(newMarker, 'dragend', function() {
                var location = newMarker.getPosition();
                $('#lat').val(location.lat);
                $('#lng').val(location.lng);
            });
            markers.push(newMarker);
        }
    </script>


@stop