<?php
// 获取id和lx参数
$id = $_GET['id'];
$lx = $_GET['lx'];
<<<<<<< HEAD
// downtj.php - 应用下载统计接口
=======

>>>>>>> d842d29ae4c970dbd5dec7f557c3fef514378871
// 定义IP获取函数
function getIP() {
    $ip = 'Unknow';
    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else if (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } else if (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
}

$ip = getIP();  // 获取客户端IP

// 文件路径
$dir = "app/$lx/$id";
$countFile = "$dir/download";       // 下载计数文件
$ipFile = "$dir/ip_tmp";            // IP临时记录文件

// 检查目录是否存在，不存在则创建
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

// 检查下载计数文件是否存在，不存在则创建并初始化为0
if (!file_exists($countFile)) {
    file_put_contents($countFile, '0');
}

// 检查IP记录文件是否存在，不存在则创建
if (!file_exists($ipFile)) {
    file_put_contents($ipFile, '');
}

// 读取IP记录文件内容
$ipRecords = file_get_contents($ipFile);
$ipRecords = $ipRecords ? explode('|', $ipRecords) : [];

// 检查当前IP是否在记录中
$ipExists = in_array($ip, $ipRecords);

if (!$ipExists) {
    // 将新IP添加到记录中
    $ipRecords[] = $ip;
    file_put_contents($ipFile, implode('|', $ipRecords));
    
    // 增加下载计数
    $currentCount = intval(file_get_contents($countFile));
    $newCount = $currentCount + 1;
    file_put_contents($countFile, $newCount);
    
    echo '下载成功';
} else {
    // IP已存在，不增加计数
    echo '下载成功';
}
?>