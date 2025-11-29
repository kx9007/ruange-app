<?php
require '../config.php';
require 'function.php';
// add.php - 应用添加接口,用于添加应用和审核通过应用
// 验证密码
if (!isset($_POST['pass']) || $_POST['pass'] !== $config["pass"]) {
    die("密码验证失败");
}

// 获取并过滤参数
$action = isset($_POST['act']) ? trim($_POST['act']) : '';
$lx = isset($_POST['lx']) ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $_POST['lx']) : '';
$id = isset($_POST['id']) ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $_POST['id']) : '';

$sourceBase = "../shapp/{$lx}/{$id}";

// 检查源目录是否存在
if (!is_dir($sourceBase)) {
    die("应用目录不存在: {$sourceBase}");
}

// 递归删除函数（优化错误处理）
function delete_recursive($dir) {
    if (!is_dir($dir) || !is_writable($dir)) {
        return false;
    }
    
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            if (!delete_recursive($path)) {
                return false;
            }
        } else {
            if (!@unlink($path)) {
                return false;
            }
        }
    }
    return @rmdir($dir);
}

// 目录操作封装（修复移动逻辑）
function move_directory($source, $target) {
    // 确保目标目录父级存在
    $targetParent = dirname($target);
    if (!is_dir($targetParent)) {
        @mkdir($targetParent, 0755, true);
    }
    
    // 优先使用rename（高效）
    if (@rename($source, $target)) {
        return ['success' => true];
    }
    
    // 递归复制作为备选方案
    if (!is_dir($target) && !@mkdir($target, 0755, true)) {
        return ['success' => false, 'msg' => "无法创建目标目录: {$target}"];
    }
    
    $dir = opendir($source);
    if (!$dir) {
        return ['success' => false, 'msg' => "无法打开源目录: {$source}"];
    }
    
    $error = null;
    while (false !== ($file = readdir($dir))) {
        if ($file == '.' || $file == '..') continue;
        
        $src = $source . '/' . $file;
        $dst = $target . '/' . $file;
        
        if (is_dir($src)) {
            $result = move_directory($src, $dst);
            if (!$result['success']) {
                $error = $result['msg'];
                break;
            }
        } else {
            if (!@copy($src, $dst)) {
                $error = "文件复制失败: {$src}";
                break;
            }
            @chmod($dst, fileperms($src));
        }
    }
    closedir($dir);
    
    if ($error) {
        return ['success' => false, 'msg' => $error];
    }
    
    // 复制成功后删除源目录
    if (!delete_recursive($source)) {
        return ['success' => false, 'msg' => "移动成功，但源目录清理失败: {$source}"];
    }
    
    return ['success' => true];
}

// 根据操作类型处理
if ($action === 'pass') {
    $targetBase = "../app/{$lx}/{$id}";
    
    // 修复关键点：确保目标目录不存在
    if (is_dir($targetBase)) {
        if (!delete_recursive($targetBase)) {
            die("发布失败：目标目录已存在且无法删除");
        }
    }
    
    $moveResult = move_directory($sourceBase, $targetBase);
    if ($moveResult['success']) {
        echo "软件已成功发布";
    } else {
        echo "发布失败：{$moveResult['msg']}";
        // 清理可能残留的部分文件
        if (is_dir($targetBase)) delete_recursive($targetBase);
    }
} elseif ($action === 'reject') {
    if (delete_recursive($sourceBase)) {
        echo "应用已成功删除！";
    } else {
        echo "删除失败，请检查目录权限或是否被占用";
    }
} else {
    die("无效的操作类型");
}