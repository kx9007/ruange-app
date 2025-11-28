<?php 
require '../config.php';
require 'function.php';

// 创建数据库连接
$conn = new mysqli($config['host'], $config['dbname'], $config['dbpass'], $config['sqlname']);

// 清理输入
$user = clean_input($_POST['user']);
$pass = clean_input($_POST['pass']);
$nc = clean_input($_POST['nc']);
$qq = clean_input($_POST['qq']);
$time = date('Y-m-d H:i:s');
$ip = getIP();
// 检查输入是否完整
if (empty($user) || empty($pass) || empty($nc) || empty($qq)) {
    echo "参数不完整";
    exit;
}

// 检查数据库连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 检查用户是否已存在
$sql_check_user = "SELECT user FROM user WHERE user = '$user'";
$result_check_user = $conn->query($sql_check_user);

if ($result_check_user->num_rows > 0) {
    echo '注册失败:账号已存在';
} else {
    if(qq($qq)){
        if(nc($nc)){
            if(mm($pass)){
    // 插入新用户
    $sql_insert_user = "INSERT INTO user (user, pass, nickname, qq, zc_time, ip, money) VALUES ('$user', '$pass', '$nc', '$qq', '$time', '$ip', '0')";
    
    if ($conn->query($sql_insert_user) === TRUE) {
        echo "注册成功";
    } else {
        echo "注册失败:请重试或者联系管理员";
    }
            }else{
                echo '注册失败:密码8~20位且包括一个字母和一个数字';
            }
        }else{
            echo '注册失败:昵称限制10中文或者20英文';
        }
    }else{
        echo "注册失败:QQ限制5位~10位";
    }
}

// 关闭连接
$conn->close();
?>
