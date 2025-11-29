<?php
<<<<<<< HEAD
// app.php - 应用发布API接口

// 设置响应头为JSON格式
header('Content-Type: application/json; charset=utf-8');

// 引入配置文件
require_once 'config.php';
=======
// app.php
>>>>>>> d842d29ae4c970dbd5dec7f557c3fef514378871
require 'php/function.php';

// 获取 POST 数据
$user = $_POST['user'];
$name = $_POST['name'];
$bb = $_POST['bb'];
$lx = $_POST['lx'];
$js = $_POST['js'];
$icon = $_POST['icon'];
$bjt = $_POST['bjt'];
$image = $_POST['images']; // 这是一个数组
$apk = $_POST['apk'];
$time = date('Y-m-d H:i:s');
$ip = getIP();
$i = date('YmdHis');

// 检查 image 数组是否为空
if (empty($image)) {
    echo 'image 数组为空';
    exit;
}

// 检查必要参数
if ($name == '' || $bb == '' || $lx == '' || $js == '' || $apk == '' || $user == '' || $icon == '' || $bjt == '') {
    echo '参数不完整';
    exit;
} else {
    if (!is_dir("shapp/$lx/$i")) {
        mkdir("shapp/$lx/$i", 0777, true);
        
        // 处理图片数据 - 修改这里
        // 不再使用 json_encode，直接存储原始数组字符串
        $img = $image; 
        
        // 写入文件
        file_put_contents("shapp/$lx/$i/name", $name);
        file_put_contents("shapp/$lx/$i/js", $js);
        file_put_contents("shapp/$lx/$i/bb", $bb);
        file_put_contents("shapp/$lx/$i/time", $time);
        file_put_contents("shapp/$lx/$i/apk", $apk);
        file_put_contents("shapp/$lx/$i/ip", $ip);
        file_put_contents("shapp/$lx/$i/image", $img); // 直接存储原始数据
        file_put_contents("shapp/$lx/$i/user", $user);
        file_put_contents("shapp/$lx/$i/icon", $icon);
        file_put_contents("shapp/$lx/$i/bjt", $bjt);
        file_put_contents("shapp/$lx/$i/download", '0');
        
        echo '发布成功';
    } else {
        echo "发布失败: 文件已发布";
    }
}