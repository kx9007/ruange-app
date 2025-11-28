<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>注册</title>
	<!-- 引入 FancyBox 的 CSS 文件 -->
	<link rel="icon" type="image/png" href="applogo.png">
    <link rel="stylesheet" href="src/fancybox/fancybox.css">
    <script src="src/jquery/jquery.js"></script>
    <script src="src/jquery/jquery-cookie.js"></script>
    
    <!-- 引入 FancyBox 的 JavaScript 文件 -->
    <script src="src/fancybox/fancybox.js"></script>
    
    <!-- 其他样式和脚本文件 -->
    <link rel="stylesheet" type="text/css" href="src/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="src/bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="src/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="src/layui/css/layui.css">
    <script src="src/html2canvas/html2canvas.js"></script>
    <script type="text/javascript" src="src/sweetalert/sweetalert.js"></script>
    <script src="src/layer/layer.js"></script>
    <script src="src/chart/chart.js"></script>
    <script src="src/layui/layui.js"></script>
    <link rel="stylesheet" type="text/css" href="src/materialize/css/materialize.css">
    <script type="text/javascript" src="src/materialize/js/materialize.js"></script>
</head>
<style>
    /* 调整轮播图图片样式 */
.layui-carousel img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>
<body>
    <div class="container-fluid" style="max-width:520px">

        <div class="col-xs-12">
            <div class="layui-carousel" id="test1">
                <div carousel-item>
                    <div><img src="https://file.alapi.cn/image/comic/153856-15048563369e4a.jpg"></div>
                    <div><img src="https://pic.rmb.bdstatic.com/bjh/2fb7d5c48a75f80803062cc09b9b678e.jpeg"></div>
                    <div><img src="https://yuanxiapi.cn/api/img/photo/165032985.jpg"></div>
                    <div><img src="https://img.xjh.me/img/53428466_p0.jpg"></div>
                    <div><img src="https://img.gumengya.com/api/qc/278.jpg"></div>
                    </div>
                </div>
<!-- 条目中可以是任意内容，如：<img src=""> -->
        </div>


        <div class="col-xs-12" style="margin-top:15px">

            <div class="layui-panel">
                <div style="padding: 32px;">

                    <span class="fa fa-user"></span><label>账号:</label>
                    <input type="text" name="" class="form-control" placeholder="请输入你的账号" id="zczh">
                    <br>
                    <span class="fa fa-user"></span><label>昵称:</label>
                    <input type="text" name="" class="form-control" placeholder="请输入你的昵称" id="zcnc">
                    <br>
                    <span class="fa fa-user"></span><label>QQ:</label>
                    <input type="text" name="" class="form-control" placeholder="请输入你的QQ" id="zcqq">
                    <span class="fa fa-eye-slash"></span><label>密码:</label>
                    <input type="password" name="" class="form-control" placeholder="请输入你的密码" id="zcmm">
                    <br>
                    <span class="fa fa-eye-slash"></span><label>重复密码:</label>
                    <input type="password" name="" class="form-control" placeholder="请再次输入你的密码" id="zcmma">
                    <div class="layui-btn layui-btn-fluid layui-btn-normal" onclick="zc()">注册</div><br><br>
                    <div class="layui-btn layui-btn-fluid layui-btn-danger">登录</div><br><br>
                    <div class="layui-btn layui-btn-warm">找回密码</div>
                    <div class="layui-btn">返回</div>
                </div>
                </div>

                

            </div>
        </div>

    </div>
</body>
</html>
<script>
layui.use('carousel', function(){
  var carousel = layui.carousel;
  //建造实例
  carousel.render({
    elem: '#test1'
    ,width: '100%' //设置容器宽度
    ,arrow: 'always' //始终显示箭头
    //,anim: 'updown' //切换动画方式
  });
});
</script>
<script type="text/javascript">
    function zc() {
        var data = {
            user: $('#zczh').val(),
            pass: $('#zcmm').val(),
            qq: $('#zcqq').val(),
            passa: $('#zcmma').val(),
            nc: $('#zcnc').val()
        };
        if(data.user=='' || data.pass=='' || data.passa=='' || data.qq=='' || data.nc==''){
            swal({
                title: '温馨提示',
                text: '注册失败: 参数不完整',
                icon: 'error', // 修改为 'error'，因为这是一个错误提示
                button: '确定'
            });
        }
        // 修改这里的条件判断
        if (data.pass !== data.passa) {
            swal({
                title: '温馨提示',
                text: '注册失败: 两次密码不一致',
                icon: 'error', // 修改为 'error'，因为这是一个错误提示
                button: '确定'
            });
        } else {
            $.post('./php/register.php', data, function(res) {
                if (res === '注册成功') { // 假设服务器返回的是一个 JSON 对象
                    $.cookie('user', data.user, { expires: 7 });
                    $.cookie('pass', data.pass, { expires: 7 });
                    swal({
                        title: '温馨提示',
                        text: '注册成功✧*。٩(ˊωˋ*)و✧*。',
                        icon: 'success',
                        button: '确定'
                    }).then((value) => {
                        if (value) {
                            window.location.href = './index.php'; // 页面跳转到index.php
                        }
                    });
                } else {
                    swal({
                        title: '温馨提示',
                        text: res, // 假设服务器返回的是一个 JSON 对象
                        icon: 'error',
                        button: '确定'
                    });
                }
            }); // 指定返回数据类型为 JSON
        }
    }
</script>
