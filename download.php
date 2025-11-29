<?php
// download.php - 应用下载界面

require_once 'config.php'; // 引入配置文件
$isAdmin = false; // 管理员标识

// 检查POST参数中的管理员密码
if (isset($_GET['admin']) && $_GET['admin'] === $config['pass']) {
    $isAdmin = true;
}

// 动态目录变量
$baseDir = $isAdmin ? "shapp" : "app";

$id = $_GET['id'];
$lx = $_GET['lx'];

// 根据lx值设置分类名称
$categoryName = "未知分类";
switch ($lx) {
    case '1':
        $categoryName = "影视音乐";
        break;
    case '2':
        $categoryName = "实用工具";
        break;
    case '3':
        $categoryName = "小说资源";
        break;
    case '4':
        $categoryName = "开源代码";
        break;
}

$name = file_get_contents("$baseDir/$lx/$id/name");
$bb = file_get_contents("$baseDir/$lx/$id/bb");
$apk = file_get_contents("$baseDir/$lx/$id/apk");
$img = file_get_contents("$baseDir/$lx/$id/image");
$time = file_get_contents("$baseDir/$lx/$id/time");
$js = file_get_contents("$baseDir/$lx/$id/js");
$icon = file_get_contents("$baseDir/$lx/$id/icon");
$bjt = file_get_contents("$baseDir/$lx/$id/bjt");
$download = file_get_contents("$baseDir/$lx/$id/download");
//@$download = count(file("$baseDir/$lx/$id/download"));
// 将 JSON 字符串转换为数组
$image = json_decode($img, true);


?>
<script>
// 图片加载失败重试函数
function setupImageRetry() {
    // 存储需要重试的图片及当前重试次数
    const retryImages = new Map();
    // 最大重试次数
    const maxRetries = 100;
    // 重试间隔时间(毫秒)
    const retryInterval = 1000;

    // 重试函数
    function retryLoadImage(img, url) {
        // 获取当前重试次数，默认0
        let retries = retryImages.get(img) || 0;
        
        // 超过最大重试次数则停止
        if (retries >= maxRetries) {
            retryImages.delete(img);
            // 可以在这里添加加载失败的提示样式
            img.style.opacity = "0.5";
            return;
        }

        // 重试次数+1并存储
        retries++;
        retryImages.set(img, retries);

        // 延迟重试
        setTimeout(() => {
            // 重新设置图片源触发加载
            img.src = "";
            img.src = url;
        }, retryInterval);
    }

    // 监听图片加载失败事件
    function handleImageError(e) {
        const img = e.target;
        const originalSrc = img.src;
        // 注册重试
        retryLoadImage(img, originalSrc);
    }

    // 监听图片加载成功事件（成功后移除重试记录）
    function handleImageLoad(e) {
        const img = e.target;
        retryImages.delete(img);
    }

    // 初始化页面上所有图片
    function initImages() {
        const allImages = document.querySelectorAll('img');
        
        allImages.forEach(img => {
            // 为每个图片添加事件监听
            img.addEventListener('error', handleImageError);
            img.addEventListener('load', handleImageLoad);

            // 检查已经加载失败的图片（页面加载时可能已失败）
            if (img.complete && !img.naturalWidth) {
                // 触发一次错误处理
                handleImageError({ target: img });
            }
        });
    }

    // 页面加载完成后初始化
    if (document.readyState === 'complete') {
        initImages();
    } else {
        window.addEventListener('load', initImages);
    }
}

// 执行初始化
setupImageRetry();
</script>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>软阁——<?php echo $name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script src="src/jquery/jquery.js"></script>
      <link rel="stylesheet" href="src/layui/css/layui.css">
      <script src="src/layui/layui.js"></script>
      <link rel="stylesheet" href="src/fancybox/fancybox.css">
      <script src="src/fancybox/fancybox.js"></script>
      <link rel="icon" type="image/png" href="applogo.png">
    <style>
        * {
            font-family: '微软雅黑';
            box-sizing: border-box;
            outline: none;
            margin: 0;
            padding: 0;
            border: 0;
            text-decoration: none;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            color: #3c3c3c;
        }

        html,
        body {
            height: 100vh;
            margin: 0 auto;
            max-width: 520px;
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            max-width: 520px;
            height: 56px;
            z-index: 1
        }

        u {
            color: white;
            font-size: 18px;
            position: fixed;
            top: 60px;
            margin-left: 116px;
            z-index: 2;
            display: block;
            height: 56px;
            line-height: 56px;
        }

        header img {
            width: 56px;
            height: 56px;
            padding: 16px
        }

        header img:active {
            background: rgba(255, 255, 255, 0.4);
        }

        main {
            z-index: -1;
            position: fixed;
            top: 0;
            padding-top: 56px;
            height: 172px;
            background: url('<?php echo $bjt; ?>');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            width: 100%;
            max-width: 520px;
            border-radius: 10px 10px 0 0;
        }

        main img {
            width: 68px;
            height: 68px;
            margin: 24px;
            float: left
        }

        main b {
            margin-top: 56px;
            display: block;
            color: #fff;
            font-size: 12px;
        }

        main p {
            color: #fff;
            font-size: 12px;
            margin-top: 4px;
        }

        ul {
            padding-top: 172px
        }

        ul a {
            margin-top: -28px;
            margin-right: 24px;
            background: #16b777;
            width: 56px;
            height: 56px;
            float: right;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.4);
            border-radius: 56px;
        }

        ul a img {
            width: 56px;
            height: 56px;
            padding: 16px;
        }

        aside {
            display: block;
            background: #fff;
            min-height: 100vh;
            border-left: solid 3px #1e9fff;
            border-right: solid 3px #1e9fff;
            border-bottom: solid 3px #1e9fff;
            border-radius:  0 0 10px 10px;
        }

        aside li {
            list-style: none;
            padding: 24px 16px;
            color: #1e9fff;
            font-size: 14px;
            background: #fff;
            border-bottom: solid 1px #eee
        }

        aside li b {
            color: #d0d0d0;
            font-size: 10px;
            margin-left: 8px
        }

        aside ol {
            padding: 16px;
            font-size: 14px;
            color: #797979;
            background: #edf7ee;
            min-height: 100px;
        }

        aside p {
            padding: 16px;
        }

        aside p cite {
            white-space: nowrap;
            overflow-x: auto;
            display: block;
        }

        aside p img {
            height: 450px;
            background: #eee;
            margin-right: 4px;
            width: 250px;
            object-fit: contain;
        }

        aside div {
            padding: 16px;
            font-size: 14px;
            color: #797979;
            min-height: 196px
        }
        
        .admin-badge {
            position: fixed;
            top: 90px;
            left: 20px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 14px;
            z-index: 100;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            font-weight: bold;
            white-space: nowrap;
            backdrop-filter: blur(2px);
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        .admin-category {
            position: fixed;
            top: 125px;
            left: 20px;
            background: rgba(0, 0, 255, 0.8);
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            z-index: 100;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            font-weight: bold;
            white-space: nowrap;
            backdrop-filter: blur(2px);
            border: 1px solid rgba(255,255,255,0.3);
        }
    </style>
</head>

<body onload="down()">
    <?php if ($isAdmin): ?>
        <div class="admin-badge">管理员模式</div>
        <div class="admin-category">分类：<?php echo $categoryName; ?></div>
    <?php endif; ?>
    
    <input type="hidden" id="isAdmin" value="<?php echo $isAdmin ? '1' : '0'; ?>">
    <input type="hidden" id="appCategory" value="<?php echo $categoryName; ?>">
    
    <header><img src="./src/image/back.png" onclick="window.history.back()"></header>
    <u><?php echo $name; ?></u>
    <main><img src="<?php echo $icon; ?>"><b><?php echo "V.".$bb; ?><br><?php echo "下载量:".$download; ?></b>
    </main>
    <ul><a href="<?php echo $apk; ?>" onclick='down()'><img src="./src/image/down.png"></a></ul>
    <aside>
        <li>应用介绍<b>发布于<?php echo $time; ?></b></li>
        <ol><?php echo $js; ?></ol>
        <p><cite>
            <?php
            for ($i = 0; $i < @count($image); $i++) {
                echo "<a href='".$image[$i]."' data-fancybox='gallery'><img src='" . $image[$i] . "'  style='cursor:pointer;'></a>";
            }
            ?>
        </cite></p>

        <li onclick='window.location.href="http://app.kxlove.top"'>应用来源于软阁，侵权联系邮箱kuxia9007@qq.com删除</li>
    </aside>
</body>
<script>
$(document).ready(function() {
    $('[data-fancybox="gallery"]').fancybox({
        buttons: [
            'slideShow',
            'fullScreen',
            'zoom',
            'thumbs',
            'close'
        ],
        protect: false,
        infobar:true
    });
    
    if ($('#isAdmin').val() === '1') {
        $('aside').addClass('admin-mode');
        $('body').prepend('<div class="admin-badge">管理员模式</div>');
        $('body').prepend('<div class="admin-category">分类：' + $('#appCategory').val() + '</div>');
    }
});

    var header = document.getElementsByTagName("header")[0];
    var mian = document.getElementsByTagName("main")[0];
    var u = document.getElementsByTagName("u")[0];
    var a = document.getElementsByTagName("a")[0];
    window.onscroll = function() {
        if (window.scrollY < 116) {
            mian.style.top = "-" + window.scrollY / 2 + "px";
            u.style.top = 60 - window.scrollY / 1.9 + "px";
            u.style.marginLeft = 116 - window.scrollY / 2.4 + "px";
            a.style.display = "";
            header.style.background = "";
            header.style.boxShadow = "none";
        } else {
            a.style.display = "none";
            header.style.background = "#1e9fff";
            header.style.boxShadow = "0px 2px 8px rgba(0,0,0,0.2)";
            if (u.style.top != "0px" || u.style.marginLeft != "68.0833px") {
                u.style.top = "0px";
                u.style.marginLeft = "68.0833px";
            }
        }
    }
    var urlParams = new URLSearchParams(window.location.search);
var appid = urlParams.get('id');
var lx = urlParams.get('lx');

function down() {
    var adminFlag = $('#isAdmin').val() === '1' ? '&admin=1' : '';
    var url = './downtj.php?id=' + appid + '&lx=' + lx + adminFlag;

    $.get(url, function(data){
    });
}

</script>

</html>