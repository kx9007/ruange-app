<?php 
require '../config.php';
require 'function.php';
$conn = new mysqli($config['host'], $config['dbname'], $config['dbpass'], $config['sqlname']);
$user = clean_input($_POST['user']);
$pass = clean_input($_POST['pass']);
$time = date('Y-m-d H:i:s');
$ip = getIP();
// 检查用户是否已存在
$sql_check_user = "SELECT user FROM user WHERE user = '$user'";
$result_check_user = $conn->query($sql_check_user);

$update = "UPDATE user SET log_time = '$time', ip = '$ip' WHERE user = '$user'";
if($user=='' || $pass==''){
    echo "参数不完整";
}else{
    if($conn->connect_error){
        die("连接失败: " . $conn->connect_error);
    }else{
        if($result_check_user->num_rows > 0){
        $sql_get_pass = "SELECT pass FROM user WHERE user = '$user'";
        $result_get_pass = $conn->query($sql_get_pass);
        if ($result_get_pass->num_rows > 0) {
            $row = $result_get_pass->fetch_assoc();
            $user_pass = $row['pass'];
            if($pass==$row['pass']){
                if ($conn->query($update) === TRUE) {
                    echo "登录成功";
                } else {
                    echo "登录失败" . $conn->error;
                }
            }else{
                echo '密码错误';
            }
        }
        }else{
            echo '账号不存在';
        }
    }
}

 ?>