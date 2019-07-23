@extends('admin.header')

@section('content')

    <link href="http://jiaxunweb.oss-cn-shenzhen.aliyuncs.com/Frame/m4_6/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="http://jiaxunweb.oss-cn-shenzhen.aliyuncs.com/Frame/m4_6/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

    <div class="site-content">


        <div class="box box-block bg-white">

            <p class="font-90 text-muted m-b-3"></p>

            <div class="row">
                <form class="form-horizontal " method="post" enctype="multipart/form-data" action="{{url('/admin/sys/company/up')}}">
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
                                    @if($company->provider_id == $v->id)
                                        selected
                                            @endif
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
                                    <input type="text" placeholder="" class="form-control" name="name" value="{{$company->name}}">
                                    <input type="hidden" placeholder="" class="form-control" name="id" value="{{$company->id}}">
                                </div>
                        </div>
                    </div>


                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-3" style="text-align: right">
                            <label for="order" class=" col-form-label " >所属省：</label>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control " name = 'province' required id="province" readonly disabled>

                                @foreach ($province as $v)
                                    <option value="{{$v->code}}" style="text-align: center;"
                                            @if($company->province_code == $v->code)
                                            selected
                                            @endif
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
                            <select class="form-control "    disabled>

                                @foreach ($city as $v)
                                    <option value="{{$v->code}}" style="text-align: center;"
                                            @if($company->city_code == $v->code)
                                            selected
                                            @endif
                                    >{{$v->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-3" style="text-align: right">
                            <label for="order" class=" col-form-label " >所属区：</label>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control " id="area" name="area">

                                @foreach ($area as $v)
                                    <option value="{{$v->code}}" style="text-align: center;"
                                            @if($company->area_code == $v->code)
                                            selected
                                            @endif
                                    >{{$v->name}}</option>
                                @endforeach

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
                                @foreach ($street as $v)
                                    <option value="{{$v->code}}" style="text-align: center;"
                                            @if($company->street_code === $v->code)
                                            selected
                                            @endif
                                    >{{$v->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-3" style="text-align: right">
                            <label for="order" class=" col-form-label " >输入关键字获取坐标：</label>
                        </div>
                        <div class="col-md-6">
                            <select type="text" id="keyword" class="form-control select2"></select>
                            <input type="hidden" name="lng" id="lng" value="{{$company->lng}}" placeholder="经度" maxlength="18">
                            <input type="hidden" name="lat" id="lat" value="{{$company->lat}}" placeholder="纬度" maxlength="18">
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
                                <input type="text" placeholder="" class="form-control" name="address" value="{{$company->address}}">
                            </div>
                        </div>
                    </div>


                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-3" style="text-align: right">
                            <label for="order" class=" col-form-label " >责任人：</label>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人" class="form-control" name="contact1" value="{{$company->contact1}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人联系电话" class="form-control" name="phone1" value="{{$company->phone1}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人邮箱" class="form-control" name="email1" value="{{$company->email1}}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="order" class=" col-form-label " >短信推送：</label>
                        </div>
                        <div class="col-md-1" style="height: auto; overflow: hidden; height: 35px; line-height: 35px;">
                          <button type="button" class="btn btn-info w-min-sm  waves-effect waves-light sub" data-tel="{{$company->phone1}}" data-contact="{{$company->contact1}}" >发送</button>
                        </div>

                    </div>

                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-3" style="text-align: right">
                            <label for="order" class=" col-form-label " >责任人：</label>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人" class="form-control" name="contact2" value="{{$company->contact2}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人联系电话" class="form-control" name="phone2" value="{{$company->phone2}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人邮箱" class="form-control" name="email2" value="{{$company->email2}}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="order" class=" col-form-label " >短信推送：</label>
                        </div>
                        <div class="col-md-1" style="height: auto; overflow: hidden; height: 35px; line-height: 35px;">
                            <button type="button" class="btn btn-info w-min-sm  waves-effect waves-light sub" data-tel="{{$company->phone2}}" data-contact="{{$company->contact2}}" >发送</button>
                        </div>
                    </div>




                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-3" style="text-align: right">
                            <label for="order" class=" col-form-label " >责任人：</label>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人" class="form-control" name="contact3" value="{{$company->contact3}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人联系电话" class="form-control" name="phone3" value="{{$company->phone3}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人邮箱" class="form-control" name="email3" value="{{$company->email3}}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="order" class=" col-form-label " >短信推送：</label>
                        </div>
                        <div class="col-md-1" style="height: auto; overflow: hidden; height: 35px; line-height: 35px;">
                            <button type="button" class="btn btn-info w-min-sm  waves-effect waves-light sub" data-tel="{{$company->phone3}}" data-contact="{{$company->contact3}}" >发送</button>
                        </div>
                    </div>




                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-3" style="text-align: right">
                            <label for="order" class=" col-form-label " >责任人：</label>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人" class="form-control" name="contact4" value="{{$company->contact4}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人联系电话" class="form-control" name="phone4" value="{{$company->phone4}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人邮箱" class="form-control" name="email4" value="{{$company->email4}}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="order" class=" col-form-label " >短信推送：</label>
                        </div>
                        <div class="col-md-1" style="height: auto; overflow: hidden; height: 35px; line-height: 35px;">
                            <button type="button" class="btn btn-info w-min-sm  waves-effect waves-light sub" data-tel="{{$company->phone4}}" data-contact="{{$company->contact4}}">发送</button>
                        </div>
                    </div>




                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-3" style="text-align: right">
                            <label for="order" class=" col-form-label " >责任人：</label>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人" class="form-control" name="contact5" value="{{$company->contact5}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人联系电话" class="form-control" name="phone5" value="{{$company->phone5}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div   class="form-group">
                                <input type="text" placeholder="责任人邮箱" class="form-control" name="email5" value="{{$company->email5}}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="order" class=" col-form-label " >短信推送：</label>
                        </div>
                        <div class="col-md-1" style="height: auto; overflow: hidden; height: 35px; line-height: 35px;">
                            <button type="button" class="btn btn-info w-min-sm  waves-effect waves-light sub" data-tel="{{$company->phone5}}" data-contact="{{$company->contact5}}" >发送</button>
                        </div>
                    </div>

                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-3" style="text-align: right">
                            <label for="order" class=" col-form-label " >告警推送策略：</label>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control " id="push_type" name="push_type">
                                    <option value="0">即时推送（系统检测到监控参数满足告警条件立即推送短信）</option>
                                    <option value="1" selected>智能推送（相同监控点相同类型的告警在24小时内只推送一条</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group h-a" style="text-align: center">
                        <div class="col-md-3" style="text-align: right">
                            <label for="order" class=" col-form-label " >上传企业图片</label>
                        </div>
                        <div class="col-md-6" >
                            <div style="position: relative;">
                                <img src="@if($company->picture)
                                        http://img.anyzeal.cn/{{$company->picture}}
                                    @elseif($company->pic)
                                {{url('storage/app/public/pic/').'/'.$company->pic}}
                                        @else
                                     http://img.anyzeal.cn/noPicture.png?imageMogr2/thumbnail/x200/interlace/1
@endif" alt="" id="avatar_img"
                                     />
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

                                <textarea class="form-control" name="remark">{{$company->remark}}</textarea>
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
    <script>
        $(function () {
            $('.sub').click(function () {

                if($(this).data('tel')== '' ||$(this).data('contact') ==''){
                    alert('请保存相应的手机号跟联系人')
                }else{
                    $.post("{{ url('/admin/sub/phone') }}",
                        {'_token': '{{ csrf_token()}}',
                            'tel':$(this).data('tel'),
                            'contact':$(this).data('contact'),
                            'cid':'{{$company->id}}'
                        }, function(data) {
                            console.log(data);
                            if(data =='OK')
                                alert('短信推送已经发送，注意查收')
                        });
                }
            })
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
            var lat = parseFloat('{{$company->lat}}');
            var lng = parseFloat('{{$company->lng}}');
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