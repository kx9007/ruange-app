<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <title>软阁</title>
    <meta name="keywords" content="酷侠,个人主页,homepage,博客,引导页">
    <meta name="author" content="酷侠">
    <meta name="copyright" content="酷侠">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="cache-control" content="no-cache">
    <meta itemprop="name" content="酷侠 | 离开池鱼的往昔！" />
    <meta itemprop="image" content="./applogo.png" />
    <meta name="description" itemprop="description" content="酷侠 | 羁鸟恋旧林，池鱼思故渊" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <link rel="icon" href="./applogo.png" type="image/x-icon" />
    <meta name="robots" content="index,follow">
    <link rel="stylesheet" href="src/layui/css/layui.css">
    <script src="src/layui/layui.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/gradient-text.css">
    <link rel="stylesheet" href="https://at.alicdn.com/t/font_1092713_tcnnod74va9.css">
    <meta name="baidu-site-verification" content="codeva-Ow2vnT6soH" />
    <script src="js/min.js"></script>
    <script src="js/mes.js"></script>
    <script charset="UTF-8" id="LA_COLLECT" src="https://sdk.51.la/js-sdk-pro.min.js"></script>
    <script>LA.init({id:"K07hlFi3m0ToqaBT",ck:"K07hlFi3m0ToqaBT"})</script>
    <link rel="stylesheet" type="text/css" href="src/font-awesome/css/font-awesome.css">
</head>
<script>
// 图片加载失败重试函数
function setupImageRetry() {
    // 存储需要重试的图片及当前重试次数
    const retryImages = new Map();
    // 最大重试次数
    const maxRetries = 100;
    // 重试间隔时间(毫秒)
    const retryInterval = 1000;

    // 重试函数
    function retryLoadImage(img, url) {
        // 获取当前重试次数，默认0
        let retries = retryImages.get(img) || 0;
        
        // 超过最大重试次数则停止
        if (retries >= maxRetries) {
            retryImages.delete(img);
            // 可以在这里添加加载失败的提示样式
            img.style.opacity = "0.5";
            return;
        }

        // 重试次数+1并存储
        retries++;
        retryImages.set(img, retries);

        // 延迟重试
        setTimeout(() => {
            // 重新设置图片源触发加载
            img.src = "";
            img.src = url;
        }, retryInterval);
    }

    // 监听图片加载失败事件
    function handleImageError(e) {
        const img = e.target;
        const originalSrc = img.src;
        // 注册重试
        retryLoadImage(img, originalSrc);
    }

    // 监听图片加载成功事件（成功后移除重试记录）
    function handleImageLoad(e) {
        const img = e.target;
        retryImages.delete(img);
    }

    // 初始化页面上所有图片
    function initImages() {
        const allImages = document.querySelectorAll('img');
        
        allImages.forEach(img => {
            // 为每个图片添加事件监听
            img.addEventListener('error', handleImageError);
            img.addEventListener('load', handleImageLoad);

            // 检查已经加载失败的图片（页面加载时可能已失败）
            if (img.complete && !img.naturalWidth) {
                // 触发一次错误处理
                handleImageError({ target: img });
            }
        });
    }

    // 页面加载完成后初始化
    if (document.readyState === 'complete') {
        initImages();
    } else {
        window.addEventListener('load', initImages);
    }
}

// 执行初始化
setupImageRetry();
</script>
<body>
    <div class="centent">
        <div class="mian">
            <div class="main-top">
                <div class="main-top-title">
                    <h1>欢迎光临➡️</h1>
                    <a onclick="openSearch()"><img src="https://q4.qlogo.cn/g?b=qq&nk=1661993235&s=640" alt="咦，图片消失了"></a>
                </div>
                <div class="main-top-Brief">
                    <p><script src="http://kxlove.top"></script></p>
                </div>
            </div>
            <div class="main-bot">
                <div class="main-bot-tb">
                    <a href="index.php?lx=1"  class="main-bot-tb-1" title="影视音乐"><i class="fa fa-volume-up"></i></a>
                    <a href="index.php?lx=2"  class="main-bot-tb-2" title="实用工具"><i class="fa fa-cubes"></i></a>
                    <a href="index.php?lx=3"  class="main-bot-tb-3" title="小说资源"><i class="fa fa-book"></i></a>
                    <a href="index.php?lx=4"  class="main-bot-tb-3" title="开源代码"><i class="fa fa-code"></i></a>
                    <?php
                    require 'config.php';
                    if (isset($_GET['admin']) && $_GET['admin'] === $config['pass']) {
                        echo "<a href='index.php?admin=".$config['pass']."' class='main-bot-tb-3' title='后台管理'><i class='fa fa-user'></i></a>";
                    }
                    ?>
                </div>
                <div class="main-bot-title">
                   <h3>全部软件</h3>
                </div>
                <div class="main-bot-nr">
                 <?php
                require_once './php/function.php';
                require_once 'config.php';

                $isAdmin = isset($_GET['admin']) && $_GET['admin'] === $config['pass'];
                $baseDir = $isAdmin ? "shapp" : "app";
                $lx = isset($_GET['lx']) ? intval($_GET['lx']) : null;
                $categories = arrdir($baseDir);

                if (count($categories) > 0) {
                    foreach ($categories as $index => $categoryId) {
                        if ($lx !== null && $lx != ($index + 1)) continue;
                        
                        $apps = arrdir("$baseDir/$categoryId");
                        
                        if (count($apps) > 0) {
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

                            foreach ($apps as $appId) {
                                $appPath = "$baseDir/$categoryId/$appId";
                                $name = @file_get_contents("$appPath/name");
                                $icon = @file_get_contents("$appPath/icon");
                                $downloads = @file_get_contents("$appPath/download");
                                $images = @file_get_contents("$appPath/image");
                                
                                if (!$name || !$icon) continue;
                                
                                $safeName = htmlspecialchars($name);
                                $safeIcon = htmlspecialchars($icon);
                                $safeDownloads = $downloads ? "下载量:".htmlspecialchars($downloads) : "下载量:0";
                                $adminClass = $isAdmin ? 'admin-mode' : '';
                                $adminAttr = $isAdmin ? 'data-admin="' . htmlspecialchars($config['pass']) . '"' : '';
                                
                                echo <<<HTML
                                <a onclick='handleAppClick(this)' class='main-bot-nr-kp $adminClass' 
                                   id='$appId' lx='$categoryId' base-dir='$baseDir' $adminAttr>
                                    <div class='main-bot-nr-kp-k'>
                                        <div class='main-bot-nr-kp-k-img'>
                                            <img src="$safeIcon" 
                                                 onclick='openImage("$safeIcon")' 
                                                 style='cursor:pointer;'>
                                        </div>
                                        <div class='main-bot-nr-kp-k-n'>
                                            <span class='p1'>$safeName</span>
                                            <span class='p2'>$safeDownloads</span>
                                        </div>
                                    </div>
                                </a>
HTML;
                            }
                        }
                    }
                }
                ?>
                </div>
            </div>
        </div>
        <div class="footer">
            Copyright © 2023 - <span>2025</span> 
            <a href="http://kxlove.top" class="footer-link">酷侠</a> All Rights Reserved.<br>
           <p>
                <a href="http://kxlove.top/" class="gradient-text icp" >
                    <img src="https://q4.qlogo.cn/g?b=qq&nk=1661993235&s=640" style="width: 20px;" alt="酷侠">
                    king团队
                </a>
                <span class="separator">&nbsp;|&nbsp;</span>
                <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=36012102000605" class="gradient-text gonganbei" >
                    <img src="https://cdn.heylie.cn/tb/gongwanganbei.png" style="width: 18px;" alt="中国警察">
                    网安
                </a>
                <span class="separator">&nbsp;|&nbsp;</span>
                <a href="https://www.06dn.com/" class="gradient-text tencentcloud" >
                    <img src="https://www.06dn.com/images/favicon.ico" style="width: 20px;" alt="七彩云">
                    由七彩云提供储存支持
                </a>
                <span class="separator">&nbsp;|&nbsp;</span>
                <a href="https://www.iconfont.cn/" class="gradient-text aliyunecs" >
                    <img src="https://img.alicdn.com/imgextra/i4/O1CN01XZe8pH1USpiUNT1QN_!!6000000002517-2-tps-114-114.png" style="width: 20px;" alt="阿里巴巴矢量库">
                    由阿里巴巴矢量库提供插画图标支持
                </a>
                <span class="separator">&nbsp;|&nbsp;</span>
                <a href="http://file.kxlove.top" class="gradient-text duojiyun" >
                    <img src="https://file.kxlove.top/view.php/5005b3a3df484ec7f426e57040950fab.png" style="width: 20px;" alt="文件快递">
                    图片储存由文件快递支持
                </a>
            </p>
        </div>
    </div>
    
    <script>
        // 初始化 layer
        layui.use('layer', function(){
            window.layer = layui.layer;
        });
        
        // 图片查看函数
        function openImage(src) {
            layer.open({
                type: 1,
                title: false,
                closeBtn: 1,
                shade: false,
                area: ['30vw', 'auto'],
                content: '<img src="' + src + ' "style="width:100%;height:auto;">'
            });
        }
        
        // 应用点击处理函数
        function handleAppClick(element) {
            var isAdminMode = element.classList.contains('admin-mode');
            var appid = element.id;
            var lx = element.getAttribute('lx');
            var admin = element.getAttribute('data-admin');
            
            if (isAdminMode) {
                showAdminOptions(appid, lx, admin);
            } else {
                openNormalApp(appid, lx, admin);
            }
        }
        
        // 显示管理员操作选项
        function showAdminOptions(appid, lx, admin) {
            layer.open({
                type: 1,
                title: '<i class="fa fa-cog"></i> 管理员操作',
                skin: 'layui-layer-lan',
                area: ['300px', '200px'],
                content: '<div style="padding:20px; text-align:center;">' +
                         '<button class="layui-btn layui-btn-normal" style="width:100%;margin-bottom:10px;" onclick="openNormalApp(\'' + appid + '\', \'' + lx + '\', \'' + admin + '\')">' +
                         '   <i class="fa fa-eye"></i> 查看应用' +
                         '</button>' +
                         '<button class="layui-btn layui-btn-success" style="width:100%;margin-bottom:10px;" onclick="approveApp(\'' + appid + '\', \'' + lx + '\', \'' + admin + '\')">' +
                         '   <i class="fa fa-check"></i> 通过审核' +
                         '</button>' +
                         '<button class="layui-btn layui-btn-danger" style="width:100%;" onclick="rejectApp(\'' + appid + '\', \'' + lx + '\', \'' + admin + '\')">' +
                         '   <i class="fa fa-times"></i> 拒绝审核' +
                         '</button>' +
                         '</div>'
            });
        }
        
        // 正常打开应用
        function openNormalApp(appid, lx, admin) {
            var url = 'download.php?id=' + encodeURIComponent(appid) + '&lx=' + encodeURIComponent(lx);
            if (admin) {
                url += '&admin=' + encodeURIComponent(admin);
            }
            window.location.href = url;
        }
        
        // 通过审核
        function approveApp(appid, lx, admin) {
            layer.confirm('确定要通过此应用的审核吗？', {
                icon: 3,
                title: '确认操作',
                btn: ['确定', '取消']
            }, function() {
                submitReview('pass', appid, lx, admin);
            });
        }
        
        // 拒绝审核
        function rejectApp(appid, lx, admin) {
            layer.confirm('确定要拒绝此应用吗？此操作将永久删除！', {
                icon: 3,
                title: '警告',
                btn: ['确定删除', '取消']
            }, function() {
                submitReview('reject', appid, lx, admin);
            });
        }
        
        // 显示管理员操作选项（优化移动端布局）
// 显示管理员操作选项（优化移动端布局）
function showAdminOptions(appid, lx, admin) {
    // 创建自定义内容HTML
    var contentHTML = `
    <div class="admin-options-container" style="padding: 15px;">
        <div class="admin-btn-container">
            <button class="admin-btn admin-btn-view" onclick="openNormalApp('${appid}', '${lx}', '${admin}')">
                <i class="fa fa-eye"></i> 查看应用
            </button>
        </div>
        <div class="admin-btn-container">
            <button class="admin-btn admin-btn-approve" onclick="approveApp('${appid}', '${lx}', '${admin}')">
                <i class="fa fa-check"></i> 通过审核
            </button>
        </div>
        <div class="admin-btn-container">
            <button class="admin-btn admin-btn-reject" onclick="rejectApp('${appid}', '${lx}', '${admin}')">
                <i class="fa fa-times"></i> 拒绝审核
            </button>
        </div>
    </div>
    `;
    
    layer.open({
        type: 1,
        title: '<i class="fa fa-cog"></i> 管理员操作',
        skin: 'layui-layer-lan admin-layer',
        area: ['300px', 'auto'], // 响应式宽度
        maxWidth: 300, // 最大宽度限制
        content: contentHTML
    });
}

// 添加CSS样式确保移动端显示正常
var adminStyle = document.createElement('style');
adminStyle.innerHTML = `
/* 完全自定义按钮样式，不使用Layui样式 */
.admin-options-container {
    display: flex;
    flex-direction: column;
    padding: 15px;
    gap: 12px; /* 按钮间距 */
}

.admin-btn-container {
    display: flex;
    justify-content: center;
}

.admin-btn {
    width: 100%;
    height: 42px;
    border-radius: 4px;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: none;
    transition: all 0.3s;
    font-weight: 500;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
    padding: 0 10px;
}

.admin-btn i {
    margin-right: 8px;
    font-size: 16px;
}

/* 查看应用按钮样式 */
.admin-btn-view {
    background: #1E9FFF;
    color: white;
}

.admin-btn-view:hover {
    background: #0d8bf2;
}

/* 通过审核按钮样式 */
.admin-btn-approve {
    background: #16b777;
    color: white;
}

.admin-btn-approve:hover {
    background: #0da466;
}

/* 拒绝审核按钮样式 */
.admin-btn-reject {
    background: #FF5722;
    color: white;
}

.admin-btn-reject:hover {
    background: #e64a19;
}

/* 按钮点击效果 */
.admin-btn:active {
    transform: scale(0.98);
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

/* 移动端适配 */
@media (max-width: 480px) {
    .admin-btn {
        height: 46px;
        font-size: 16px;
    }
}

/* 覆盖Layui默认样式 */
.layui-layer-admin-layer .layui-layer-content {
    padding: 0 !important;
    overflow: hidden !important;
}

.layui-layer-admin-layer .layui-layer-btn {
    display: none !important;
}
`;
document.head.appendChild(adminStyle);

// 正常打开应用
function openNormalApp(appid, lx, admin) {
    var url = 'download.php?id=' + encodeURIComponent(appid) + '&lx=' + encodeURIComponent(lx);
    if (admin) {
        url += '&admin=' + encodeURIComponent(admin);
    }
    window.location.href = url;
}

// 通过审核
function approveApp(appid, lx, admin) {
    layer.confirm('确定要通过此应用的审核吗？', {
        icon: 3,
        title: '确认操作',
        btn: ['确定', '取消'],
        skin: 'layui-layer-molv'
    }, function() {
        submitReview('pass', appid, lx, admin);
    });
}

// 拒绝审核
function rejectApp(appid, lx, admin) {
    layer.confirm('<span style="color:#ff5722">此操作将永久删除应用！</span><br>确定要拒绝此应用吗？', {
        icon: 2,
        title: '警告',
        btn: ['确定删除', '取消'],
        skin: 'layui-layer-lan'
    }, function() {
        submitReview('reject', appid, lx, admin);
    });
}

// 提交审核操作（使用隐藏iframe避免页面跳转）
function submitReview(action, appid, lx, admin) {
    // 显示加载状态
    var loadIndex = layer.load(1, {shade: [0.3,'#000']});
    
    // 创建隐藏iframe
    var iframe = document.createElement('iframe');
    iframe.name = 'submitReviewFrame';
    iframe.style.display = 'none';
    document.body.appendChild(iframe);
    
    // 创建表单
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = './php/add.php';
    form.target = 'submitReviewFrame';
    
    // 添加隐藏字段
    var fields = {
        'pass': admin,
        'lx': lx,
        'id': appid,
        'act': action
    };
    
    for (var name in fields) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = fields[name];
        form.appendChild(input);
    }
    
    // 添加表单到页面并提交
    document.body.appendChild(form);
    form.submit();
    
    // 监听iframe加载完成
    iframe.onload = function() {
        layer.close(loadIndex);
        
        try {
            // 获取iframe内容
            var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            var responseText = iframeDoc.body.textContent || iframeDoc.body.innerText;
            
            // 解析服务器响应
            if (responseText.includes("成功")) {
                showSuccessMessage(responseText);
                // 2秒后刷新页面
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                showErrorMessage(responseText);
            }
        } catch (e) {
            showErrorMessage('无法解析服务器响应: ' + e.message);
        }
        
        // 清理DOM
        document.body.removeChild(iframe);
        document.body.removeChild(form);
    };
}

// 显示成功消息
function showSuccessMessage(message) {
    layer.msg('<div style="text-align:center;padding:15px">' +
              '<i class="fa fa-check-circle" style="font-size:24px;color:#5FB878"></i>' +
              '<p style="margin-top:10px;font-size:16px">' + message + '</p></div>', {
        time: 3000,
        anim: 5,
        isOutAnim: true,
        skin: 'success-msg'
    });
}

// 显示错误消息
function showErrorMessage(message) {
    layer.msg('<div style="text-align:center;padding:15px">' +
              '<i class="fa fa-exclamation-triangle" style="font-size:24px;color:#FF5722"></i>' +
              '<p style="margin-top:10px;font-size:16px">' + message + '</p></div>', {
        time: 4000,
        skin: 'error-msg'
    });
}

// 添加操作结果弹窗的CSS样式
var msgStyle = document.createElement('style');
msgStyle.innerHTML = `
.success-msg .layui-layer-content {
    background: #f0f9eb !important;
    color: #67C23A !important;
    font-weight: 500;
    padding: 20px !important;
}
.error-msg .layui-layer-content {
    background: #fef0f0 !important;
    color: #F56C6C !important;
    font-weight: 500;
    padding: 20px !important;
}
.layui-layer-success .layui-layer-content {
    padding: 30px 20px !important;
}
`;
document.head.appendChild(msgStyle);
        
        // 搜索功能
        var originalApps = [];
        
        function openSearch() {
    saveOriginalState();
    layer.open({
        type: 1,
        title: '<i class="fa fa-search"></i> 搜索软件',
        skin: 'layui-layer-lan',
        area: ['380px', '280px'], // 增加高度容纳新按钮
        content: '<div class="layui-form" style="padding:20px 30px;">' +
                 '<div class="layui-form-item">' +
                 '  <div class="layui-input-block" style="margin-left:0;">' +
                 '    <input type="text" id="searchInput" placeholder="请输入软件名称关键词" class="layui-input" autocomplete="off">' +
                 '  </div>' +
                 '</div>' +
                 '<div class="layui-form-item" style="text-align:center;margin-top:30px;">' +
                 '  <button class="layui-btn layui-btn-normal" onclick="doSearch()" style="margin-right:20px;width:100px;">' +
                 '    <i class="fa fa-search"></i> 搜索' +
                 '  </button>' +
                 '  <button class="layui-btn layui-btn-primary" onclick="closeSearch()" style="width:100px;">' +
                 '    <i class="fa fa-times"></i> 关闭' +
                 '  </button>' +
                 '</div>' +
                 // 新增投稿按钮区域
                 '<div class="layui-form-item" style="text-align:center;margin-top:10px;">' +
                 '  <button class="layui-btn layui-btn-warm" onclick="goToUpload()" style="width:220px;">' +
                 '    <i class="fa fa-upload"></i> 软件投稿' +
                 '  </button>' +
                 '</div>' +
                 '</div>',
        success: function(layero) {
            document.getElementById('searchInput').focus();
            document.getElementById('searchInput').addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    doSearch();
                }
            });
        }
    });
}

// 新增投稿跳转函数
function goToUpload() {
    closeSearch(); // 关闭搜索弹窗
    window.location.href = 'up.php'; // 跳转到投稿页面
}
        
        function saveOriginalState() {
            originalApps = [];
            var cards = document.getElementsByClassName('main-bot-nr-kp');
            for (var i = 0; i < cards.length; i++) {
                var card = cards[i];
                originalApps.push({
                    element: card,
                    display: card.style.display || 'block'
                });
            }
        }
        
        function doSearch() {
            var keyword = document.getElementById('searchInput').value.trim().toLowerCase();
            if (!keyword) {
                layer.msg('请输入搜索关键词');
                return;
            }
            
            var cards = document.getElementsByClassName('main-bot-nr-kp');
            var found = false;
            
            for (var i = 0; i < cards.length; i++) {
                var card = cards[i];
                var appNameElement = card.querySelector('.p1');
                if (appNameElement) {
                    var appName = appNameElement.textContent.toLowerCase();
                    if (appName.includes(keyword)) {
                        card.style.display = 'block';
                        found = true;
                    } else {
                        card.style.display = 'none';
                    }
                }
            }
            
            if (!found) {
                layer.msg('未找到匹配的软件');
            }
        }
        
        function closeSearch() {
            for (var i = 0; i < originalApps.length; i++) {
                var app = originalApps[i];
                app.element.style.display = app.display;
            }
            layer.closeAll();
        }
    </script>
</body>
</html>