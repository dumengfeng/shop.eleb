@extends('default')
@section('content')
    <form action="{{ route('user.store') }}" class="form-horizontal" role="search" method="post">
        <div class="col-xs-6 ">
            <div class="row"><h1>添加商家信息</h1></div>
            <div class="form-group">
                <label for="">店铺名称:</label>
                <input type="text" name="shop_name" class="" placeholder="">
            </div>
            <div class="form-group">
                <label for="">店铺分类:</label>
                <select name="shop_category_id">
                    @foreach($shopcategories as $shopcategory)
                        <option value="{{ $shopcategory->id }}">{{ $shopcategory->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">店铺图片:</label>
                <!--dom结构部分-->
                <input type="text" name="shop_img" id="img_url">
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <div id="fileList" class="uploader-list"></div>
                    <div id="filePicker">选择图片</div>
                </div>
                <img id="img"/>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">是否是品牌</label>
                <label>是<input type="radio" checked name="brand" value="1"></label>
                <label>否<input type="radio" name="brand" value="0"></label>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">是否准时送达</label>
                <label>是<input type="radio" checked name="on_time" value="1"></label>
                <label>否<input type="radio" name="on_time" value="0"></label>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">是否蜂鸟配送</label>
                <label>是<input type="radio" checked name="fengniao" value="1"></label>
                <label>否<input type="radio" name="fengniao" value="0"></label>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">是否保标记</label>
                <label>是<input type="radio" checked name="bao" value="1"></label>
                <label>否<input type="radio" name="bao" value="0"></label>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">是否票标记</label>
                <label>是<input type="radio" checked name="piao" value="1"></label>
                <label>否<input type="radio" name="piao" value="0"></label>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">是否准标记</label>
                <label>是<input type="radio" checked name="zhun" value="1"></label>
                <label>否<input type="radio" name="zhun" value="0"></label>
            </div>
            <div class="form-group">
                <label for="">起送金额:</label>
                <input type="text" name="start_send" class="" placeholder="">
            </div>
            <div class="form-group">
                <label for="">配送费:</label>
                <input type="text" name="send_cost" class="" placeholder="">
            </div>
            <div class="form-group">
                <label for="">店公告:</label>
                <textarea class="" rows="3" name="notice"></textarea>
            </div>
            <div class="form-group">
                <label for="">优惠信息:</label>
                <textarea class="" rows="3" name="discount"></textarea>
            </div>
        </div>
        <div class="col-xs-6 ">
            <div class="row"><h1>添加账号信息</h1></div>
            <div class="form-group">
                <label for="">账号名称:</label>
                <input type="text" name="name" class="" placeholder="">
            </div>
            <div class="form-group">
                <label for="">账号邮箱:</label>
                <input type="text" name="email" class="" placeholder="">
            </div>
            <div class="form-group">
                <label for="">账号密码:</label>
                <input type="password" name="password" class="" placeholder="">
            </div>
            <div class="form-group">
                <label for="">确认密码:</label>
                <input type="password" name="repassword" class="" placeholder="">
            </div>
        </div>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-default">注册</button>
    </form>
@stop
@section('js')
    <script>
        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
//            swf: BASE_URL + '/js/Uploader.swf',

            // 文件接收服务端。
            server: '{{ route('upload') }}',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',



            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            formData: {
                _token: '{{ csrf_token()}}'
            }
        });
        uploader.on( 'uploadSuccess', function( file,response ) {//uploadSuccess当文件上传成功时触发,response代表响应内容
            $("#img").attr('src',response.fileName);
            $("#img_url").val(response.fileName)
        });
    </script>
@stop