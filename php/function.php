<?php
<<<<<<< HEAD
// function.php - 函数库文件
=======
>>>>>>> d842d29ae4c970dbd5dec7f557c3fef514378871
function copydir($source, $destination) {
    // 检查源目录是否存在
    if (!is_dir($source)) {
        throw new Exception("源目录不存在: $source");
    }

    // 创建目标目录
    if (!is_dir($destination)) {
        mkdir($destination, 0755, true);
    }

    // 打开源目录
    $files = scandir($source);
    foreach ($files as $file) {
        // 跳过当前目录和父目录
        if ($file === '.' || $file === '..') {
            continue;
        }

        $srcFile = $source . DIRECTORY_SEPARATOR . $file;
        $destFile = $destination . DIRECTORY_SEPARATOR . $file;

        // 如果是目录，则递归调用
        if (is_dir($srcFile)) {
            copydir($srcFile, $destFile);
        } else {
            // 复制文件
            if (!copy($srcFile, $destFile)) {
                throw new Exception("无法复制文件: $srcFile 到 $destFile");
            }
        }
    }
}

// // 使用示例
// try {
//     copyDirectory('path/to/source/directory', 'path/to/destination/directory');
//     echo "目录复制成功。";
// } catch (Exception $e) {
//     echo "错误: " . $e->getMessage();
// }

function copyfile($sourceFile, $destinationFile) {
    // 检查源文件是否存在
    if (!file_exists($sourceFile)) {
        throw new Exception("源文件不存在: $sourceFile");
    }

    // 复制文件
    if (!copy($sourceFile, $destinationFile)) {
        throw new Exception("无法复制文件: $sourceFile 到 $destinationFile");
    }
}

// // 使用示例
// try {
//     copyFile('path/to/source/file.txt', 'path/to/destination/file.txt');
//     echo "文件复制成功。";
// } catch (Exception $e) {
//     echo "错误: " . $e->getMessage();
// }

function connectSQL($host, $dbname, $username, $password) {
    try {
        // 创建 PDO 实例
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password);
        
        // 设置 PDO 错误模式为异常
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $pdo;
    } catch (PDOException $e) {
        // 捕获连接错误并抛出异常
        throw new Exception("数据库连接失败: " . $e->getMessage());
    }
}

// // 使用示例
// try {
//     $db = connectDatabase('localhost', 'your_database_name', 'your_username', 'your_password');
//     echo "数据库连接成功。";
// } catch (Exception $e) {
//     echo "错误: " . $e->getMessage();
// }

function dataExists($host, $dbname, $username, $password, $db, $data) {
    try {
        // 连接数据库
        $pdo = connectSQL($host, $dbname, $username, $password);
        
        // 检查连接是否成功
        if (!$pdo) {
            throw new Exception("数据库连接失败");
        }
        
        // 构建查询语句
        $query = "SELECT COUNT(*) FROM $db";
        $conditions = [];
        $params = [];

        // 检查是否有条件
        if (!empty($data)) {
            $query .= " WHERE ";
            foreach ($data as $column => $value) {
                $conditions[] = "$column = :$column";
                $params[":$column"] = $value;
            }
            $query .= implode(" AND ", $conditions);
        }
        
        // 准备并执行 SQL 语句
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        
        // 获取结果
        $count = $stmt->fetchColumn();
        
        // 判断是否存在数据
        return $count > 0; // 返回 true 或 false
    } catch (Exception $e) {
        // 处理错误（可以根据需要记录错误或抛出异常）
        return false; // 连接失败或其他错误时返回 false
    }
}

// // 使用示例
// $host = 'localhost';
// $dbname = 'your_database_name';
// $username = 'your_username';
// $password = 'your_password';
// $db = 'your_table_name'; // 假设你的表名
// $data = ['username' => 'example_user']; // 要查询的条件

// $result = dataExists($host, $dbname, $username, $password, $db, $data);

// // 输出结果
// var_dump($result); // 输出 true 或 false

function search($host, $dbname, $username, $password, $db, $data) {
    try {
        // 连接数据库
        $pdo = connectSQL($host, $dbname, $username, $password);
        
        // 检查连接是否成功
        if (!$pdo) {
            return json_encode(["error" => "数据库连接失败"]);
        }
        
        // 构建查询语句
        $query = "SELECT * FROM $db";
        $conditions = [];
        $params = [];

        // 检查是否有条件
        if (!empty($data)) {
            $query .= " WHERE ";
            foreach ($data as $column => $value) {
                $conditions[] = "$column = :$column";
                $params[":$column"] = $value;
            }
            $query .= implode(" AND ", $conditions);
        }
        
        // 准备并执行 SQL 语句
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        
        // 获取结果
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // 返回 JSON 格式的结果
        return json_encode($results);
    } catch (Exception $e) {
        return json_encode(["error" => $e->getMessage()]);
    }
}

// // 使用示例
// $host = 'localhost';
// $dbname = 'your_database_name';
// $username = 'your_username';
// $password = 'your_password';
// $db = 'your_table_name';
// $data = [
//     'status' => 'active',
// ];

// $jsonResult = search($host, $dbname, $username, $password, $db, $data);
// echo $jsonResult;

// // 解析 JSON 数据
// $parsedData = json_decode($jsonResult, true); // 设置第二个参数为 true 以获取数组

// // 检查解析结果
// if (isset($parsedData['error'])) {
//     echo "错误: " . $parsedData['error'];
// } else {
//     // 遍历并输出解析后的数据
//     foreach ($parsedData as $row) {
//         echo "用户: " . $row['user'] . ", 状态: " . $row['status'] . ", 年龄: " . $row['age'] . "<br>";
//     }
// }

function insertData($host, $dbname, $username, $password, $db, $data) {
    try {
        // 连接数据库
        $pdo = connectSQL($host, $dbname, $username, $password);
        
        // 检查连接是否成功
        if (!$pdo) {
            return json_encode(["error" => "数据库连接失败"]);
        }

        // 构建插入查询
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $db ($columns) VALUES ($placeholders)";
        
        // 准备并执行 SQL 语句
        $stmt = $pdo->prepare($query);
        $stmt->execute($data);
        
        // 返回成功消息
        return json_encode(["success" => true, "message" => "数据插入成功"]);
    } catch (Exception $e) {
        return json_encode(["error" => $e->getMessage()]);
    }
}

// // 示例用法
// $host = 'localhost';
// $dbname = 'your_database';
// $username = 'your_username';
// $password = 'your_password';
// $db = 'your_table';

// // 要插入的数据
// $data = [
//     'column1' => 'value1',
//     'column2' => 'value2',
//     'column3' => 'value3'
// ];

// // 调用函数
// $result = insertData($host, $dbname, $username, $password, $db, $data);
// echo $result;


function deleteData($host, $dbname, $username, $password, $db, $conditions) {
    try {
        // 连接数据库
        $pdo = connectSQL($host, $dbname, $username, $password);
        
        // 检查连接是否成功
        if (!$pdo) {
            return json_encode(["error" => "数据库连接失败"]);
        }

        // 构建删除查询
        $query = "DELETE FROM $db";
        $params = [];
        
        // 检查是否有条件
        if (!empty($conditions)) {
            $query .= " WHERE ";
            $conditionParts = [];
            foreach ($conditions as $column => $value) {
                $conditionParts[] = "$column = :$column";
                $params[":$column"] = $value;
            }
            $query .= implode(" AND ", $conditionParts);
        }
        
        // 准备并执行 SQL 语句
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        
        // 返回成功消息
        return json_encode(["success" => true, "message" => "数据删除成功"]);
    } catch (Exception $e) {
        return json_encode(["error" => $e->getMessage()]);
    }
}
// $host = 'localhost'; // 数据库主机
// $dbname = 'your_database_name'; // 数据库名称
// $username = 'your_username'; // 数据库用户名
// $password = 'your_password'; // 数据库密码
// $db = 'your_table_name'; // 表名
// $conditions = [
//     'id' => 1 // 删除条件，例如 id = 1
// ];

// // 调用 deleteData 函数
// $result = deleteData($host, $dbname, $username, $password, $db, $conditions);
// echo $result; // 输出结果


function updateData($host, $dbname, $username, $password, $db, $data, $conditions) {
    try {
        // 连接数据库
        $pdo = connectSQL($host, $dbname, $username, $password);
        
        // 检查连接是否成功
        if (!$pdo) {
            return json_encode(["error" => "数据库连接失败"]);
        }

        // 构建更新查询
        $query = "UPDATE $db SET ";
        $setParts = [];
        $params = [];

        // 设置要更新的字段
        foreach ($data as $column => $value) {
            $setParts[] = "$column = :$column";
            $params[":$column"] = $value;
        }
        $query .= implode(", ", $setParts);

        // 检查是否有条件
        if (!empty($conditions)) {
            $query .= " WHERE ";
            $conditionParts = [];
            foreach ($conditions as $column => $value) {
                $conditionParts[] = "$column = :cond_$column";
                $params[":cond_$column"] = $value;
            }
            $query .= implode(" AND ", $conditionParts);
        }

        // 准备并执行 SQL 语句
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        
        // 返回成功消息
        return json_encode(["success" => true, "message" => "数据更新成功"]);
    } catch (Exception $e) {
        return json_encode(["error" => $e->getMessage()]);
    }
}


// // 使用示例
// $host = 'localhost';
// $dbname = 'your_database_name';
// $username = 'your_username';
// $password = 'your_password';
// $db = 'your_table_name';

// // 要更新的数据
// $data = [
//     'status' => 'active', // 假设要将状态更新为 'active'
//     'name' => 'New Name'  // 假设要更新名称
// ];

// // 更新的条件，可以包含多个条件
// $conditions = [
//     'id' => 1, // 假设要更新 id 为 1 的记录
//     'status' => 'inactive' // 例如，当前状态为 'inactive'
// ];

// $jsonResult = updateData($host, $dbname, $username, $password, $db, $data, $conditions);
// echo $jsonResult;

// // 解析 JSON 数据
// $parsedData = json_decode($jsonResult, true);

// // 检查解析结果
// if (isset($parsedData['error'])) {
//     echo "错误: " . $parsedData['error'];
// } else {
//     echo $parsedData['message'];
// }


function getApkIcon($apkFilePath) {
    // 检查 APK 文件是否存在
    if (!file_exists($apkFilePath) || pathinfo($apkFilePath, PATHINFO_EXTENSION) !== 'apk') {
        return false; // 文件不存在或不是 APK 文件
    }

    // 创建临时目录用于解压
    $tempDir = sys_get_temp_dir() . '/apk_temp_' . uniqid();
    mkdir($tempDir);

    // 解压 APK 文件
    $zip = new ZipArchive;
    if ($zip->open($apkFilePath) === TRUE) {
        $zip->extractTo($tempDir);
        $zip->close();
    } else {
        return false; // 解压失败
    }

    // 查找图标文件
    $iconFilePath = '';
    $iconPaths = [
        'res/mipmap-mdpi/ic_launcher.png',
        'res/mipmap-hdpi/ic_launcher.png',
        'res/mipmap-xhdpi/ic_launcher.png',
        'res/mipmap-xxhdpi/ic_launcher.png',
        'res/mipmap-xxxhdpi/ic_launcher.png',
        'res/drawable-mdpi/ic_launcher.png',
        'res/drawable-hdpi/ic_launcher.png',
        'res/drawable-xhdpi/ic_launcher.png',
        'res/drawable-xxhdpi/ic_launcher.png',
        'res/drawable-xxxhdpi/ic_launcher.png',
    ];

    foreach ($iconPaths as $path) {
        if (file_exists($tempDir . '/' . $path)) {
            $iconFilePath = $tempDir . '/' . $path;
            break;
        }
    }

    // 删除临时目录
    array_map('unlink', glob("$tempDir/*.*")); // 删除文件
    rmdir($tempDir); // 删除目录

    // 返回图标文件路径
    return $iconFilePath ? $iconFilePath : false; // 如果找到图标，返回路径，否则返回 false
}

// // 使用示例
// $apkPath = 'path/to/your/app.apk'; // 替换为 APK 文件的实际路径
// $iconPath = getApkIcon($apkPath);

// if ($iconPath) {
//     echo "图标路径: " . $iconPath;
// } else {
//     echo "未找到图标";
// }


function getApkName($apkFilePath) {
    // 检查 APK 文件是否存在
    if (!file_exists($apkFilePath) || pathinfo($apkFilePath, PATHINFO_EXTENSION) !== 'apk') {
        return false; // 文件不存在或不是 APK 文件
    }

    // 创建临时目录用于解压
    $tempDir = sys_get_temp_dir() . '/apk_temp_' . uniqid();
    mkdir($tempDir);

    // 解压 APK 文件
    $zip = new ZipArchive;
    if ($zip->open($apkFilePath) === TRUE) {
        $zip->extractTo($tempDir);
        $zip->close();
    } else {
        return false; // 解压失败
    }

    // 解析 AndroidManifest.xml
    $manifestPath = $tempDir . '/AndroidManifest.xml';
    if (!file_exists($manifestPath)) {
        // 删除临时目录
        array_map('unlink', glob("$tempDir/*.*")); // 删除文件
        rmdir($tempDir); // 删除目录
        return false; // 找不到 AndroidManifest.xml
    }

    // 使用 aapt 工具解析 AndroidManifest.xml
    $apkName = '';
    $aaptPath = '/path/to/aapt'; // 替换为 aapt 工具的实际路径
    $output = [];
    exec("$aaptPath dump badging $apkFilePath", $output);

    foreach ($output as $line) {
        if (preg_match("/application: label='(.+?)'/", $line, $matches)) {
            $apkName = $matches[1];
            break;
        }
    }

    // 删除临时目录
    array_map('unlink', glob("$tempDir/*.*")); // 删除文件
    rmdir($tempDir); // 删除目录

    return $apkName ? $apkName : false; // 返回应用名或 false
}

// // 使用示例
// $apkPath = 'path/to/your/app.apk'; // 替换为 APK 文件的实际路径
// $appName = getApkName($apkPath);

// if ($appName) {
//     echo "应用名称: " . $appName;
// } else {
//     echo "未找到应用名称";
// }



function getApkVersion($apkFilePath) {
    // 检查 APK 文件是否存在
    if (!file_exists($apkFilePath) || pathinfo($apkFilePath, PATHINFO_EXTENSION) !== 'apk') {
        return false; // 文件不存在或不是 APK 文件
    }

    // 使用 aapt 工具解析 APK 文件
    $versionName = '';
    $aaptPath = '/path/to/aapt'; // 替换为 aapt 工具的实际路径
    $output = [];
    exec("$aaptPath dump badging $apkFilePath", $output);

    foreach ($output as $line) {
        if (preg_match("/versionName='(.+?)'/", $line, $matches)) {
            $versionName = $matches[1];
            break;
        }
    }

    return $versionName ? $versionName : false; // 返回版本名或 false
}

// // 使用示例
// $apkPath = 'path/to/your/app.apk'; // 替换为 APK 文件的实际路径
// $appVersion = getApkVersion($apkPath);

// if ($appVersion) {
//     echo "应用版本: " . $appVersion;
// } else {
//     echo "未找到应用版本";
// }


function getApkPackageName($apkFilePath) {
    // 检查 APK 文件是否存在
    if (!file_exists($apkFilePath) || pathinfo($apkFilePath, PATHINFO_EXTENSION) !== 'apk') {
        return false; // 文件不存在或不是 APK 文件
    }

    // 使用 aapt 工具解析 APK 文件
    $packageName = '';
    $aaptPath = '/path/to/aapt'; // 替换为 aapt 工具的实际路径
    $output = [];
    exec("$aaptPath dump badging $apkFilePath", $output);

    foreach ($output as $line) {
        if (preg_match("/package: name='(.+?)'/", $line, $matches)) {
            $packageName = $matches[1];
            break;
        }
    }

    return $packageName ? $packageName : false; // 返回包名或 false
}

// // 使用示例
// $apkPath = 'path/to/your/app.apk'; // 替换为 APK 文件的实际路径
// $appPackageName = getApkPackageName($apkPath);

// if ($appPackageName) {
//     echo "应用包名: " . $appPackageName;
// } else {
//     echo "未找到应用包名";
// }
// 定义一个函数getIP()
function getIP()
{
    global $ip;
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;
}

function arrdir($dir){
    if( is_dir($dir) ){
        if( $arr=scandir($dir) ){
            $sz=array();
            for($i=0;$i<count($arr);$i++){
                if($arr[$i]!='..' && $arr[$i]!='.'){
                    array_push($sz,$arr[$i]);
                }
            }
            return $sz;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
function qq($qq) {
    // 使用正则表达式匹配QQ号格式：5位以上数字开头，最多15位数字
    if (preg_match('/^[1-9][0-9]{4,14}$/', $qq)) {
        return true;
    } else {
        return false;
    }
}
function mm($password) {
    // 密码长度在8到20个字符之间
    if (strlen($password) < 8 || strlen($password) > 20) {
        return false;
    }

    // 包含至少一个数字
    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }

    // 包含至少一个字母
    if (!preg_match('/[a-zA-Z]/', $password)) {
        return false;
    }

    return true;
}
function nc($string) {
    $length = strlen($string);
    
    if ($length <= 40) { // 20 英文 或者 10 中文
        return true;
    } else {
        return false;
    }
}
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = $conn->real_escape_string($data);
    return $data;
}
?>