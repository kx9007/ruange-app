<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
<<<<<<< HEAD
//上传接口文件，对接的是彩虹外联网盘
=======

>>>>>>> d842d29ae4c970dbd5dec7f557c3fef514378871
    // 确保文件上传没有错误
    if ($file['error'] === 0) {
        // 初始化cURL会话
        $curl = curl_init();

        // 设置cURL选项
        curl_setopt($curl, CURLOPT_URL, 'http://file.kxlove.top/api.php');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            'file' => new CURLFile($file['tmp_name'], $file['type'], $file['name']),
            'show' => '1'
        ]);

        // 执行cURL会话
        $response = curl_exec($curl);

        // 关闭cURL资源，并释放系统资源
        curl_close($curl);

        // 解析JSON响应
        $data = json_decode($response, true);
        // 打印解析后的数据
        echo $response;
    } else {
        echo "File upload error: " . $file['error'];
    }
} else {
    echo "No file uploaded.";
}
?>
