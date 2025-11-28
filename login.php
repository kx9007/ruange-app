<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>登录</title>
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
                    <input type="text" name="" class="form-control" placeholder="请输入你的账号" id="dlzh">
                    <br>
                    <span class="fa fa-eye-slash"></span><label>密码:</label>
                    <input type="password" name="" class="form-control" placeholder="请输入你的密码" id="dlmm">
                    <br>
                    <div class="layui-btn layui-btn-fluid layui-btn-normal" onclick="login()">登录</div><br><br>
                    <div class="layui-btn layui-btn-fluid layui-btn-danger">注册</div><br><br>
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
    function login() {
        var data = {
            user:$('#dlzh').val(),
            pass:$('#dlmm').val()
        };
        $.post('./php/login.php',data,function(res){
            if(res == '登录成功'){
                $.cookie('user',data.user,{ expires: 7 });
                $.cookie('pass',data.pass,{ expires: 7 });
                swal({
                    title: '温馨提示',
                    text: '登录成功✧*。٩(ˊωˋ*)و✧*。',
                    icon: 'success',
                    button: '确定'
                }).then((value) => {
                    if (value) {
                    window.location.href = './index.php'; // 页面跳转到perso.php
                }
            });
            }else{
                swal({
                    title: '温馨提示',
                    text: res,
                    icon: 'error',
                    button: '确定'
                });
            }
        })
    }
    function autologin(){
    var user = $.cookie('user');
    var pass = $.cookie('pass');
    var dl = {
      user:user,
      pass:pass
    }
    $.post('./php/login.php',dl,function(res){
      if(res == '登录成功'){
        layer.msg('欢迎你的登录');
        window.location.href='./index.php';
      }else{
        layer.msg('尚未登录');
        window.location.href='./login.php';
      }
    });
  }
</script>