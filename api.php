<?php
//用于获取应用信息列表的api接口
// api.php - 应用列表API接口

// 设置响应头为JSON格式
header('Content-Type: application/json; charset=utf-8');

// 引入配置文件
require_once 'config.php';
require_once './php/function.php';

// 初始化响应数组
$response = [
    'code' => 0,
    'msg' => '获取成功',
    'result' => []
];

try {
    // 获取参数
    $lx = isset($_POST['lx']) ? intval($_POST['lx']) : null;
    $admin = isset($_POST['admin']) ? $_POST['admin'] : '';
    
    // 验证管理员权限
    $isAdmin = !empty($admin) && $admin === $config['pass'];
    $baseDir = $isAdmin ? "shapp" : "app";
    
    // 获取分类
    $categories = arrdir($baseDir);
    
    if (count($categories) === 0) {
        $response['code'] = 1;
        $response['msg'] = '没有找到任何分类';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    $appsData = [];
    
    // 遍历分类
    foreach ($categories as $index => $categoryId) {
        // 如果指定了lx参数，只获取该分类的应用
        if ($lx !== null && $lx != ($index + 1)) continue;
        
        // 获取该分类下的应用
        $apps = arrdir("$baseDir/$categoryId");
        
        if (count($apps) > 0) {
            // 排序逻辑（与原始代码一致）
            usort($apps, function($a, $b) use ($baseDir, $categoryId, $isAdmin) {
                $appPathA = "$baseDir/$categoryId/$a";
                $appPathB = "$baseDir/$categoryId/$b";
                
                if ($isAdmin) {
                    return filectime($appPathB) - filectime($appPathA);
                } else {
                    $downloadsA = (int)@file_get_contents("$appPathA/download");
                    $downloadsB = (int)@file_get_contents("$appPathB/download");
                    
                    if ($downloadsA != $downloadsB) {
                        return $downloadsB - $downloadsA;
                    }
                    return filectime($appPathB) - filectime($appPathA);
                }
            });
            
            // 处理每个应用
            foreach ($apps as $appId) {
                $appPath = "$baseDir/$categoryId/$appId";
                $name = @file_get_contents("$appPath/name");
                $icon = @file_get_contents("$appPath/icon");
                $downloads = @file_get_contents("$appPath/download");
                $images = @file_get_contents("$appPath/image");
                
                if (!$name || !$icon) continue;
                
                // 添加到结果数组
                $appsData[] = [
                    'id' => $appId,
                    'name' => $name,
                    'icon' => $icon,
                    'downloads' => $downloads ? intval($downloads) : 0,
                    'category' => $categoryId,
                    'category_index' => $index + 1,
                    'base_dir' => $baseDir,
                    'is_admin' => $isAdmin
                ];
            }
        }
    }
    
    if (count($appsData) === 0) {
        $response['code'] = 2;
        $response['msg'] = '没有找到任何应用';
    } else {
        $response['result'] = $appsData;
    }
    
} catch (Exception $e) {
    $response['code'] = 500;
    $response['msg'] = '服务器错误: ' . $e->getMessage();
}

// 输出JSON响应
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>