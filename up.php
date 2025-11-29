<!DOCTYPE html>
<!-- up.php - 应用发布中心文件 -->
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>应用发布中心</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/layui/2.8.3/css/layui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- 添加Fancybox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <style>
        /* 样式保持不变，与之前相同 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1e5799 0%, #207cca 51%, #2989d8 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 30px 20px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.15);
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: none; /* 直接移除背景 */
}
        
        .header h1 {
            color: white;
            font-size: 2.8rem;
            margin-bottom: 15px;
            text-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
            font-weight: 700;
        }
        
        .header p {
            color: #e0f0ff;
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        @media (max-width: 992px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }
        
        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        }
        
        .card-header {
            background: linear-gradient(to right, #1e88e5, #0d47a1);
            color: white;
            padding: 22px 30px;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            font-weight: 600;
        }
        
        .card-header i {
            margin-right: 12px;
            font-size: 1.8rem;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-item {
            margin-bottom: 25px;
        }
        
        .form-item label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #1e3c72;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
        }
        
        .form-item label i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }
        
        .layui-input, .layui-textarea, .layui-select {
            border-radius: 8px;
            border: 1px solid #d9e3f0;
            padding: 12px 15px;
            background: #f8fbff;
            transition: all 0.3s;
        }
        
        .layui-input:focus, .layui-textarea:focus, .layui-select:focus {
            border-color: #1e88e5;
            box-shadow: 0 0 0 3px rgba(30, 136, 229, 0.15);
            background: #fff;
        }
        
        .preview-area {
            text-align: center;
            padding: 25px;
            background: #f0f7ff;
            border-radius: 12px;
            margin-top: 20px;
            border: 1px dashed #a0c4ff;
            display:none;
        }
        
        .preview-icon {
            width: 110px;
            height: 110px;
            border-radius: 22px;
            background: linear-gradient(135deg, #e0f0ff, #d1e4ff);
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #4a90e2;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(74, 144, 226, 0.2);
        }
        
        .preview-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .preview-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1e3c72;
        }
        
        .preview-desc {
            color: #5a6d8c;
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 1.05rem;
        }
        
        .preview-screenshots {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
        }
        
        .preview-screenshot {
            width: 90px;
            height: 160px;
            border-radius: 10px;
            background: linear-gradient(135deg, #e0f0ff, #d1e4ff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4a90e2;
            font-size: 2.5rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(74, 144, 226, 0.2);
        }
        
        .preview-screenshot img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .upload-section {
            margin: 30px 0;
            padding: 25px;
            background: #f5f9ff;
            border-radius: 12px;
            border: 1px solid #e1ecff;
        }
        
        .upload-section-title {
            font-size: 1.2rem;
            margin-bottom: 18px;
            color: #1e88e5;
            display: flex;
            align-items: center;
            font-weight: 600;
        }
        
        .upload-section-title i {
            margin-right: 10px;
            font-size: 1.3rem;
        }
        
        .upload-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        
        .action-buttons {
    display: flex;
    justify-content: center;
    align-items: center; /* 添加垂直居中 */
    gap: 20px;
    margin-top: 35px;
    flex-wrap: wrap;
}

.action-buttons {
    display: flex;
    justify-content: center;
    align-items: center; /* 确保垂直居中 */
    gap: 20px;
    margin-top: 35px;
    flex-wrap: wrap;
}

/* 确保所有按钮有相同的高度和内部布局 */
.action-buttons .layui-btn {
    display: inline-flex;
    align-items: center; /* 垂直居中内容 */
    justify-content: center; /* 水平居中内容 */
    height: 50px; /* 固定高度 */
    min-width: 160px; /* 最小宽度确保一致性 */
    box-sizing: border-box; /* 包含内边距和边框 */
    padding: 0 25px; /* 左右内边距 */
    line-height: 1.5; /* 重置行高 */
}

/* 调整图标和文本间距 */
.action-buttons .layui-btn i {
    margin-right: 8px;
    font-size: 18px; /* 确保图标大小一致 */
}

/* 特殊处理重置按钮 */
#reset-form-btn {
    line-height: 50px; /* 确保文本垂直居中 */
}
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
            position: relative;
        }
        
        .step-indicator::before {
            content: '';
            position: absolute;
            top: 22px;
            left: 0;
            right: 0;
            height: 3px;
            background: #e0ecff;
            z-index: 1;
            border-radius: 3px;
        }
        
        .step {
            text-align: center;
            position: relative;
            z-index: 2;
            width: 33.33%;
        }
        
        .step-number {
            width: 45px;
            height: 45px;
            background: #1e88e5;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 4px 8px rgba(30, 136, 229, 0.3);
            transition: all 0.3s;
        }
        
        .step.active .step-number {
            background: #0d47a1;
            transform: scale(1.1);
        }
        
        .step-text {
            font-size: 1rem;
            color: #5a6d8c;
            font-weight: 500;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            padding: 20px;
            background: rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            backdrop-filter: blur(4px);
        }
        
        .upload-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }
        
        .preview-item {
            width: 90px;
            height: 90px;
            border-radius: 10px;
            background: linear-gradient(135deg, #e0f0ff, #d1e4ff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4a90e2;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(74, 144, 226, 0.2);
        }
        
        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .badge-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }
        
        .layui-badge {
            font-size: 0.95rem;
            padding: 6px 14px;
            border-radius: 20px;
        }
        
        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .layui-progress {
            border-radius: 10px;
            height: 12px;
            margin-top: 5px;
        }
        
        .layui-progress-bar {
            border-radius: 10px;
        }
        
        .layui-timeline {
            padding-left: 10px;
        }
        
        .layui-timeline-item {
            margin-bottom: 25px;
        }
        
        .layui-timeline-title {
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        
        .app-user-field {
            display: flex;
            align-items: center;
            background: #f0f7ff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        
        .app-user-field label {
            margin-right: 15px;
            font-weight: 600;
            color: #1e3c72;
            min-width: 80px;
        }
        
        .app-user-field input {
            flex: 1;
            border: none;
            background: transparent;
            font-size: 1.1rem;
            color: #2c5282;
            font-weight: 500;
        }
        
        .guide-box {
            margin-top: 30px;
            background: linear-gradient(135deg, #f0f7ff, #e6f2ff);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #d1e4ff;
        }
        
        .guide-box h3 {
            margin-bottom: 20px;
            color: #1e88e5;
            display: flex;
            align-items: center;
            font-size: 1.3rem;
        }
        
        .layui-bg-green {
            background-color: #32CD32 !important;
        }
        
        .layui-bg-orange {
            background-color: #FFA500 !important;
        }
        
        /* 粒子背景效果 */
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }
        
        /* 调试信息样式 */
        .debug-info {
            position: fixed;
            bottom: 10px;
            right: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            z-index: 1000;
            max-width: 300px;
            display: none;
        }
    </style>
</head>
<body>
    <!-- 粒子背景 -->
    <div id="particles-js"></div>
    
    <!-- 调试信息面板 -->
    <div class="debug-info" id="debug-info">
        <h4>上传状态</h4>
        <div id="apk-status">APK: 未上传</div>
        <div id="screenshots-status">截图: 0</div>
    </div>
    
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-cloud-upload-alt"></i> 应用发布中心</h1>
            <p>软件会由人工审核，请耐心等待结果，如有疑问请联系邮箱kuxia9007@qq.com</p>
        </div>
        
        <div class="main-content">
            <!-- 左侧表单区域 -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit"></i> 应用信息
                </div>
                <div class="card-body">
                    <div class="app-user-field">
                        <label><i class="fas fa-user"></i> 发布者</label>
                        <input type="text" id="user" placeholder="请输入您的用户名">
                    </div>
                    
                    <div class="form-item">
                        <label for="lx"><i class="fas fa-tag"></i> 软件类型</label>
                        <select name="lei" id="lx" class="layui-input">
                            <option value="1">影视音乐</option>
                            <option value="2">实用工具</option>
                            <option value="3">小说资源</option>
                            <option value="4">开源代码</option>
                        </select>
                    </div>
                    
                    <div class="form-item">
                        <label for="name"><i class="fas fa-font"></i> 软件名称</label>
                        <input type="text" class="layui-input" id="name" placeholder="请输入应用名称">
                    </div>
                    
                    <div class="form-item">
                        <label for="js"><i class="fas fa-align-left"></i> 软件简介</label>
                        <textarea class="layui-textarea" id="js" placeholder="请输入应用简介" rows="3"></textarea>
                    </div>
                    
                    <div class="form-item">
                        <label for="bb"><i class="fas fa-code-branch"></i> 软件版本</label>
                        <input type="text" class="layui-input" id="bb" placeholder="例如：1.0.0">
                    </div>
                    
                    <div class="step-indicator">
                        <div class="step active">
                            <div class="step-number">1</div>
                            <div class="step-text">填写信息</div>
                        </div>
                        <div class="step">
                            <div class="step-number">2</div>
                            <div class="step-text">上传文件</div>
                        </div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-text">完成发布</div>
                        </div>
                    </div>
                    
                    <div class="upload-section">
                        <div class="upload-section-title">
                            <i class="fas fa-icons"></i> 应用图标上传
                        </div>
                        <div class="upload-buttons">
                            <button type="button" class="layui-btn layui-btn-normal" id="ID-upload-demo-choose">
                                <i class="fas fa-folder-open"></i> 选择图标
                            </button>
                            <button type="button" class="layui-btn" id="ID-upload-demo-action">
                                <i class="fas fa-cloud-upload-alt"></i> 开始上传
                            </button>
                        </div>
                        <div class="upload-preview">
                            <div class="preview-item" id="icon-preview">
                                <i class="fas fa-image"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="upload-section">
                        <div class="upload-section-title">
                            <i class="fas fa-image"></i> 应用背景图上传
                        </div>
                        <div class="upload-buttons">
                            <button type="button" class="layui-btn layui-btn-normal" id="ID-upload-bjt-choose">
                                <i class="fas fa-folder-open"></i> 选择背景图
                            </button>
                            <button type="button" class="layui-btn" id="ID-upload-bjt-action">
                                <i class="fas fa-cloud-upload-alt"></i> 开始上传
                            </button>
                        </div>
                        <div class="upload-preview">
                            <div class="preview-item" id="bjt-preview">
                                <i class="fas fa-landscape"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="upload-section">
                        <div class="upload-section-title">
                            <i class="fas fa-camera"></i> 应用截图上传
                        </div>
                        <div class="layui-upload">
                            <button type="button" class="layui-btn layui-bg-orange" id="ID-upload-demo-files">
                                <i class="fas fa-folder-plus"></i> 选择多页面截图
                            </button>
                            <div class="layui-upload-list">
                                <table class="layui-table">
                                  <colgroup>
                                    <col style="min-width: 100px;">
                                    <col width="150">
                                    <col width="260">
                                    <col width="150">
                                  </colgroup>
                                  <thead>
                                    <th>文件名</th>
                                    <th>大小</th>
                                    <th>进度</th>
                                    <th>操作</th>
                                  </thead>
                                  <tbody id="ID-upload-demo-files-list"></tbody>
                                </table>
                            </div>
                            <button type="button" class="layui-btn" id="ID-upload-demo-files-action">
                                <i class="fas fa-upload"></i> 开始上传截图
                            </button>
                        </div>
                    </div>
                    
                     <!-- APK下载地址输入框 -->
                    <div class="form-item">
                        <label for="apk_url"><i class="fas fa-link"></i> APK下载地址</label>
                        <input type="text" class="layui-input" id="apk_url" placeholder="请输入APK文件的下载地址">
                    </div>
                    
                    <div class="action-buttons">
                        <button type="button" class="layui-btn layui-btn-lg layui-btn-normal" id="submit-app-btn">
                            <i class="fas fa-paper-plane"></i> 发布应用
                        </button>
                        <button type="button" class="layui-btn layui-btn-lg layui-btn-primary" id="reset-form-btn">
                            <i class="fas fa-redo"></i> 重置表单
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- 右侧预览区域 -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-eye"></i> 温馨提示
                </div>
                <div class="card-body">
                    <div class="preview-area">
                        <div class="preview-icon" id="app-icon-preview">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="preview-title" id="app-name-preview">应用名称</div>
                        <div class="preview-desc" id="app-desc-preview">应用简介将显示在这里</div>
                        <div class="badge-container">
                            <div class="layui-badge layui-bg-blue" id="app-type-preview">影视音乐</div>
                            <div class="layui-badge" id="app-version-preview">版本号</div>
                        </div>
                        
                        <div class="preview-screenshots" id="screenshots-preview">
                            <div class="preview-screenshot">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        
                        <div style="margin-top: 30px;">
                            <button class="layui-btn layui-btn-radius layui-btn-warm">
                                <i class="fas fa-download"></i> 下载应用
                            </button>
                        </div>
                    </div>
                    
                    <div class="guide-box">
                        <h3>
                            <i class="fas fa-lightbulb"></i> 发布指南
                        </h3>
                        <ul class="layui-timeline">
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title">填写应用信息</h3>
                                    <p>准确填写应用名称、类型、简介和版本号</p>
                                </div>
                            </li>
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title">上传应用素材</h3>
                                    <p>上传应用图标、背景图、至少3张应用截图和APK文件</p>
                                </div>
                            </li>
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title">检查并发布</h3>
                                    <p>预览应用信息，确认无误后点击发布按钮</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>© 2023 软阁 | 用心分享每一款软件 | King团队©️</p>
        </div>
    </div>

    <!-- 调整脚本加载顺序 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/layui/2.8.3/layui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <!-- 添加Fancybox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script>
        // 在全局作用域定义 uploadedFiles
        var uploadedFiles = {
            icon: null,
            bjt: null,
            screenshots: [],
            apk: null
        };

        // 粒子背景初始化
        particlesJS("particles-js", {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: { type: "circle", stroke: { width: 0, color: "#000000" } },
                opacity: { value: 0.2, random: true },
                size: { value: 3, random: true },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#ffffff",
                    opacity: 0.1,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: "none",
                    random: true,
                    straight: false,
                    out_mode: "out",
                    bounce: false
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "grab" },
                    onclick: { enable: true, mode: "push" },
                    resize: true
                },
                modes: {
                    grab: { distance: 140, line_linked: { opacity: 0.3 } },
                    push: { particles_nb: 4 }
                }
            },
            retina_detect: true
        });

        // 初始化Layui模块
        layui.use(['upload', 'element', 'layer'], function(){
            var upload = layui.upload;
            var element = layui.element;
            var layer = layui.layer;
            var $ = layui.$;

            // 实时预览功能
            $('#name').on('input', function() {
                $('#app-name-preview').text(this.value || '应用名称');
            });
            
            $('#js').on('input', function() {
                $('#app-desc-preview').text(this.value || '应用简介将显示在这里');
            });
            
            $('#bb').on('input', function() {
                $('#app-version-preview').text(this.value || '版本号');
            });
            
            $('#lx').change(function() {
                var types = ['影视音乐', '实用工具', '小说资源', '开源代码'];
                $('#app-type-preview').text(types[this.value-1] || '应用类型');
            });
            
            // 图标上传
            var iconUpload = upload.render({
                elem: '#ID-upload-demo-choose',
                url: './upload.php',
                auto: false,
                bindAction: '#ID-upload-demo-action',
                accept: 'images',
                exts: 'jpg|png|jpeg|gif',
                choose: function(obj){
                    obj.preview(function(index, file, result){
                        $('#icon-preview').html('<img src="' + result + '">');
                    });
                },
                done: function(res){
                    if(res.code === 0) {
                        layer.msg('图标上传成功', {icon: 1});
                        uploadedFiles.icon = res.viewurl;
                        $('#app-icon-preview').html('<img src="' + res.viewurl + '">');
                    } else {
                        layer.msg('图标上传失败: ' + res.msg, {icon: 2});
                    }
                },
                error: function() {
                    layer.msg('图标上传失败' + res.msg, {icon: 2});
                }
            });
            
            // 背景图上传
            var bgUpload = upload.render({
                elem: '#ID-upload-bjt-choose',
                url: './upload.php',
                auto: false,
                bindAction: '#ID-upload-bjt-action',
                accept: 'images',
                exts: 'jpg|png|jpeg|gif',
                choose: function(obj){
                    obj.preview(function(index, file, result){
                        $('#bjt-preview').html('<img src="' + result + '">');
                    });
                },
                done: function(res){
                    if(res.code === 0) {
                        layer.msg('背景图上传成功', {icon: 1});
                        uploadedFiles.bjt = res.viewurl;
                    } else {
                        layer.msg('背景图上传失败: ' + res.msg, {icon: 2});
                    }
                },
                error: function() {
                    layer.msg('背景图上传失败' + res.msg, {icon: 2});
                }
            });
            
            // 多文件上传（截图）
            var uploadListIns = upload.render({
                elem: '#ID-upload-demo-files',
                elemList: $('#ID-upload-demo-files-list'),
                url: './upload.php',
                accept: 'images',
                exts: 'jpg|png|jpeg|gif',
                multiple: true,
                auto: false,
                bindAction: '#ID-upload-demo-files-action',
                choose: function(obj){   
                    var that = this;
                    var files = this.files = obj.pushFile();
                    
                    obj.preview(function(index, file, result){
                        var tr = $(['<tr id="upload-'+ index +'">',
                            '<td>'+ file.name +'</td>',
                            '<td>'+ (file.size/1024).toFixed(1) +'kb</td>',
                            '<td><div class="layui-progress" lay-filter="progress-demo-'+ index +'"><div class="layui-progress-bar" lay-percent=""></div></div></td>',
                            '<td>',
                                '<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>',
                                '<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>',
                            '</td>',
                        '</tr>'].join(''));
                        
                        tr.find('.demo-reload').on('click', function(){
                            obj.upload(index, file);
                        });
                        
                        tr.find('.demo-delete').on('click', function(){
                            delete files[index];
                            tr.remove();
                            uploadListIns.config.elem.next()[0].value = ''; 
                        });
                        
                        // 使用Fancybox预览图片
                        if (/^image\//.test(file.type)) {
                            tr.on('click', function() {
                                $.fancybox.open({
                                    src: result,
                                    type: 'image',
                                    buttons: [
                                        "zoom",
                                        "slideShow",
                                        "fullScreen",
                                        "download",
                                        "thumbs",
                                        "close"
                                    ],
                                    animationEffect: "fade",
                                    transitionEffect: "slide"
                                });
                            });
                        }

                        that.elemList.append(tr);
                        element.render('progress');
                    });
                },
                done: function(res, index, upload){
                    var that = this;
                    if(res.code === 0) {
                        var tr = that.elemList.find('tr#upload-'+ index);
                        var tds = tr.children();
                        tds.eq(3).html('<span class="layui-badge layui-bg-green">上传成功</span>');
                        delete this.files[index];
                        
                        // 添加截图预览
                        if (res.viewurl) {
                            // 确保 URL 格式正确且没有转义
                            var cleanUrl = res.viewurl.replace(/\\/g, '');
                            uploadedFiles.screenshots.push(cleanUrl);
                            // 使用Fancybox相册模式
                            $('#screenshots-preview').append(
                                '<div class="preview-screenshot">' +
                                '<a href="' + cleanUrl + '" data-fancybox="screenshots" data-caption="应用截图">' +
                                '<img src="' + cleanUrl + '">' +
                                '</a>' +
                                '</div>'
                            );
                            // 更新调试信息
                            $('#screenshots-status').text('截图: ' + uploadedFiles.screenshots.length);
                        }
                        
                        layer.msg('截图上传成功', {icon: 1});
                        return;
                    }
                    this.error(index, upload);
                },
                error: function(index, upload){
                    var that = this;
                    var tr = that.elemList.find('tr#upload-'+ index);
                    var tds = tr.children();
                    tds.eq(3).find('.demo-reload').removeClass('layui-hide');
                    layer.msg('截图上传失败', {icon: 2});
                },
                progress: function(n, elem, e, index){
                    element.progress('progress-demo-'+ index, n + '%');
                }
            });
            
            // 提交应用信息 - 在Layui模块内部定义
            window.submitApp = function() {
                // 获取表单数据
                var user = $('#user').val();
                var name = $('#name').val();
                var bb = $('#bb').val();
                var lx = $('#lx').val();
                var js = $('#js').val();
                var icon = uploadedFiles.icon;
                var bjt = uploadedFiles.bjt;
                var images = uploadedFiles.screenshots;
                var apk = $('#apk_url').val();
                
                // 调试面板
                $('#debug-info').show();
                $('#apk-status').text('APK: ' + (apk ? '已上传' : '未上传'));
                $('#screenshots-status').text('截图: ' + images.length);
                
                // 验证表单
                if (!user) {
                    layer.msg('请填写发布者名称', {icon: 2});
                    return;
                }
                
                if (!name) {
                    layer.msg('请填写应用名称', {icon: 2});
                    return;
                }
                
                if (!bb) {
                    layer.msg('请填写应用版本', {icon: 2});
                    return;
                }
                
                if (!js) {
                    layer.msg('请填写应用简介', {icon: 2});
                    return;
                }
                
                if (!icon) {
                    layer.msg('请上传应用图标', {icon: 2});
                    return;
                }
                
                if (!bjt) {
                    layer.msg('请上传应用背景图', {icon: 2});
                    return;
                }
                
                if (images.length < 1) {
                    layer.msg('请至少上传一张应用截图', {icon: 2});
                    return;
                }
                
                // 重点修复：确保APK文件已上传
                if (!apk) {
                    layer.msg('请上传APK文件', {icon: 2});
                    
                    // 显示调试信息
                    layer.open({
                        type: 1,
                        title: 'APK上传状态',
                        content: '<div style="padding:15px;">APK文件未上传或上传未完成<br>状态: ' + 
                                 (uploadedFiles.apk ? '已上传' : '未上传') + '</div>',
                        area: ['300px', '150px']
                    });
                    return;
                }
                
                // 显示加载中
                layer.msg('正在提交应用信息...', {icon: 16, time: 0, shade: 0.3});
                
                // 发送AJAX请求到app.php
                $.post('app.php', {
                    user: user,
                    name: name,
                    bb: bb,
                    lx: lx,
                    js: js,
                    icon: icon,
                    bjt: bjt,
                    images: JSON.stringify(images).replace(/\\/g, ''),  // 关键修改：移除所有反斜杠转义
                    apk: apk
                }, function(res) {
                    layer.closeAll();
                    if (res === '发布成功') {
                        layer.open({
                            type: 1,
                            title: '发布成功',
                            content: '<div style="padding:30px;text-align:center;"><i class="layui-icon layui-icon-ok-circle" style="font-size:60px;color:#5FB878;"></i><p style="font-size:20px;margin-top:20px;line-height:1.6;">应用已成功发布！请耐心等待审核结果!<br><small>文件已暂存储到服务器</small></p></div>',
                            area: ['400px', '300px'],
                            btn: ['退出', '确定'],
                            yes: function(index, layero){
                                layer.close(index);
                                
                                // 实际项目中这里可以跳转到应用详情页
                            },
                            btn2: function(index, layero){
                                layer.close(index);
                            }
                        });
                    } else {
                        layer.msg('发布失败: ' + res, {icon: 2});
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    layer.closeAll();
                    layer.msg('请求失败: ' + textStatus, {icon: 2});
                });
            };
            
            // 重置表单 - 在Layui模块内部定义
            window.resetForm = function() {
                layer.confirm('确定要重置表单吗？所有输入的内容将被清空', {
                    icon: 3,
                    title: '确认重置'
                }, function(index){
                    $('#user, #name, #js, #bb').val('');
                    $('#lx').val('1');
                    $('#ID-upload-demo-files-list').empty();
                    $('#ID-upload-apk-list').empty();
                    $('#screenshots-preview').html('<div class="preview-screenshot"><i class="fas fa-plus"></i></div>');
                    $('#icon-preview, #bjt-preview').html('<i class="fas fa-image"></i>');
                    $('#app-icon-preview').html('<i class="fas fa-mobile-alt"></i>');
                    $('#app-name-preview').text('应用名称');
                    $('#app-desc-preview').text('应用简介将显示在这里');
                    $('#app-version-preview').text('版本号');
                    $('#app-type-preview').text('影视音乐');
                    
                    // 重置上传文件状态
                    uploadedFiles = {
                        icon: null,
                        bjt: null,
                        screenshots: [],
                        apk: null
                    };
                    
                    // 更新调试信息
                    $('#apk-status').text('APK: 未上传');
                    $('#screenshots-status').text('截图: 0');
                    
                    layer.msg('表单已重置', {icon: 1});
                    layer.close(index);
                });
            };
            
            // 绑定按钮事件
            $('#submit-app-btn').on('click', submitApp);
            $('#reset-form-btn').on('click', resetForm);
            
            // 启用调试信息快捷键 (Ctrl+D)
            $(document).on('keydown', function(e) {
                if (e.ctrlKey && e.key === 'd') {
                    $('#debug-info').toggle();
                }
            });
        });
    </script>
</body>
</html>