<?php
<<<<<<< HEAD
// manage.php - 应用管理接口,用于删除应用
=======
>>>>>>> d842d29ae4c970dbd5dec7f557c3fef514378871
require '../config.php';
require 'function.php';

// 验证密码
if (!isset($_POST['pass']) || $_POST['pass'] !== $config["pass"]) {
    die("密码验证失败");
}

// 获取参数
$action = isset($_POST['act']) ? $_POST['act'] : '';
$lx = isset($_POST['lx']) ? trim($_POST['lx']) : '';
$id = isset($_POST['id']) ? trim($_POST['id']) : '';

// 安全过滤
$lx = preg_replace('/[^a-zA-Z0-9_\-]/', '', $lx);
$id = preg_replace('/[^a-zA-Z0-9_\-]/', '', $id);

$appBase = "../app/{$lx}/{$id}";

// 检查目录是否存在
if (!is_dir($appBase)) {
    die("应用目录不存在");
}

// 根据操作类型处理
if ($action === 'delete') {
    // 删除应用
    if (delete_recursive($appBase)) {
        echo "应用已成功删除！";
    } else {
        echo "删除失败，请检查权限";
    }
} else {
    die("无效的操作类型");
}

// 递归删除函数
function delete_recursive($dir) {
    if (!is_dir($dir)) return false;
    
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            delete_recursive($path);
        } else {
            unlink($path);
        }
    }
    return rmdir($dir);
}