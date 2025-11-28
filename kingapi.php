<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $show = $_POST['show'];//0为不显示在首页，1为显示在首页
    $ispwd = $_POST['ispwd'];//0为无密码，1为有密码
    $pwd = $_POST['pwd'] ?? '';//密码值，默认空
    $url = $_GET['url'] ?? 'http://file.kxlove.top/api.php';
    // 确保文件上传没有错误
    if ($file['error'] === 0) {
        // 初始化POST参数
        $postFields = [
            'file' => new CURLFile($file['tmp_name'], $file['type'], $file['name']),
            'show' => $show,
            'ispwd' => $ispwd // 必传是否需要密码的标识
        ];
        
        // 只有当ispwd为1时，才添加密码参数
        if ($ispwd == 1) {
            $postFields['pwd'] = $pwd;
        }

        // 初始化cURL会话
        $curl = curl_init();

        // 设置cURL选项
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);

        // 执行cURL会话
        $response = curl_exec($curl);

        // 关闭cURL资源
        curl_close($curl);

        // 输出响应
        echo $response;
    } else {
        echo "File upload error: " . $file['error'];
    }
} else {
    echo "No file uploaded.";
}
?>
