<?php
// 要上传的本地文件路径
$localFilePath = 'applogo.png';

// 检查文件是否存在
if (!file_exists($localFilePath)) {
    die("错误：本地文件 '$localFilePath' 不存在不存在");
}

$curl = curl_init();

// 获取文件内容
$fileContent = file_get_contents($localFilePath);

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://cloud.kxlove.top/api/fs/put',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => $fileContent,  // 这里是文件实际内容
    CURLOPT_HTTPHEADER => array(
        'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwicHdkX3RzIjoxNzU4Nzk3NTA0LCJleHAiOjE3NTkyMjY2MzAsIm5iZiI6MTc1OTA1MzgzMCwiaWF0IjoxNzU5MDUzODMwfQ.aGlngvTO_kv0dmA46KktjeVZ0SKy_X_nidfLV0O8skM',
        'File-Path: %2fKing%e5%9b%a2%e9%98%9f%2f%e9%85%b7%e4%be%a0%2f%e5%a4%a9%e7%bf%bc%e4%ba%91%2f1.png',  // 修改为目标路径和文件名
        'As-Task: true',
        'Content-Length: ' . strlen($fileContent),  // 自动计算文件大小
        'Content-Type: application/octet-stream'
    ),
));

$response = curl_exec($curl);

// 检查是否有curl错误
if(curl_errno($curl)) {
    $error_msg = curl_error($curl);
    echo "CURL错误: " . $error_msg;
}

curl_close($curl);
echo $response;
?>
