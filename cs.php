<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文件快递 - 专业文件上传系统</title>
    <link href="https://cdn.jsdelivr.net/npm/layui@2.6.8/dist/css/layui.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
    <style>
        :root {
            --primary-color: #1E9FFF;
            --success-color: #52c41a;
            --error-color: #ff4d4f;
            --warning-color: #faad14;
            --card-bg: #ffffff;
            --border-color: #e8e8e8;
            --text-color: #333;
            --text-secondary: #666;
            --bg-color: #f8f9fa;
            --header-gradient: linear-gradient(135deg, #3498db 0%, #1a56db 100%);
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e3e8f0 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            min-height: 100vh;
            padding: 20px;
            background-attachment: fixed;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: var(--header-gradient);
            border-radius: 15px;
            color: white;
            box-shadow: 0 6px 20px rgba(26, 86, 219, 0.2);
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .header p {
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
            opacity: 0.9;
        }
        
        .card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background: linear-gradient(90deg, #3498db, #1E9FFF);
            color: white;
            padding: 18px 25px;
            font-size: 1.2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .upload-area {
            border: 2px dashed #d9d9d9;
            border-radius: 8px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background-color: #fafafa;
            margin-bottom: 25px;
            position: relative;
        }
        
        .upload-area:hover, .upload-area.dragover {
            border-color: var(--primary-color);
            background-color: rgba(30, 159, 255, 0.05);
        }
        
        .upload-icon {
            font-size: 64px;
            color: var(--primary-color);
            margin-bottom: 15px;
            transition: transform 0.3s;
        }
        
        .upload-area:hover .upload-icon {
            transform: scale(1.1);
        }
        
        .upload-text {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: var(--text-secondary);
        }
        
        .upload-hint {
            color: #95a5a6;
            font-size: 0.95rem;
            margin-top: 10px;
        }
        
        .settings-panel {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        
        .setting-item {
            flex: 1;
            min-width: 250px;
        }
        
        .file-list {
            margin-top: 30px;
        }
        
        .file-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s;
            background: white;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        
        .file-item:hover {
            background-color: #f9f9f9;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .file-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e8f4ff;
            border-radius: 8px;
            margin-right: 15px;
            font-size: 24px;
            color: var(--primary-color);
        }
        
        .file-info {
            flex: 1;
        }
        
        .file-name {
            font-weight: 600;
            margin-bottom: 5px;
            word-break: break-all;
        }
        
        .file-meta {
            display: flex;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }
        
        .file-meta span {
            margin-right: 15px;
        }
        
        .file-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .progress-container {
            margin-top: 10px;
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            background-color: var(--primary-color);
            width: 0;
            transition: width 0.3s ease;
        }
        
        .preview-container {
            margin-top: 15px;
        }
        
        .preview-image {
            max-width: 100%;
            max-height: 200px;
            border-radius: 6px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(90deg, #3498db, #1E9FFF);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(90deg, #2980b9, #0d8aee);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 159, 255, 0.3);
        }
        
        .btn-primary:disabled {
            background: linear-gradient(90deg, #a0c4e4, #8fc3eb);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline:hover {
            background-color: rgba(30, 159, 255, 0.1);
        }
        
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-uploading {
            background-color: #e6f7ff;
            color: #1890ff;
        }
        
        .status-queued {
            background-color: #fff7e6;
            color: #fa8c16;
        }
        
        .status-success {
            background-color: #f6ffed;
            color: var(--success-color);
        }
        
        .status-error {
            background-color: #fff2f0;
            color: var(--error-color);
        }
        
        .status-retrying {
            background-color: #fffbe6;
            color: var(--warning-color);
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            color: #7f8c8d;
            font-size: 0.9rem;
            padding: 15px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 8px 15px;
            font-size: 0.85rem;
        }
        
        .clear-all {
            margin-left: 15px;
            background: linear-gradient(90deg, #ff4d4f, #f5222d);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .clear-all:hover {
            background: linear-gradient(90deg, #ff7875, #ff4d4f);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 77, 79, 0.3);
        }
        
        .file-input-container {
            position: relative;
            display: inline-block;
        }
        
        .file-input-btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: 1px solid var(--primary-color);
            background-color: transparent;
            color: var(--primary-color);
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .file-input-btn:hover {
            background-color: rgba(30, 159, 255, 0.1);
        }
        
        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        .thumbnail-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
            justify-content: center;
        }
        
        .thumbnail {
            width: 80px;
            height: 80px;
            border-radius: 6px;
            object-fit: cover;
            border: 2px solid #e8e8e8;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .thumbnail:hover {
            transform: scale(1.05);
            border-color: var(--primary-color);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .preview-title {
            font-weight: 600;
            margin-top: 15px;
            color: var(--text-secondary);
        }
        
        .stats-bar {
            display: flex;
            justify-content: space-between;
            background: #f0f7ff;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .stat-value {
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .upload-queue {
            display: flex;
            gap: 5px;
            margin-top: 10px;
            flex-wrap: wrap;
        }
        
        .queue-item {
            background: #e6f7ff;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            color: #1890ff;
            display: flex;
            align-items: center;
            gap: 3px;
        }
        
        @media (max-width: 768px) {
            .settings-panel {
                flex-direction: column;
            }
            
            .setting-item {
                min-width: 100%;
            }
            
            .file-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .file-actions {
                margin-top: 15px;
                width: 100%;
                justify-content: flex-end;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .header p {
                font-size: 1rem;
            }
        }
        
        .info-content {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            margin-top: 10px;
        }
        
        .info-row {
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
        }
        
        .info-label {
            font-weight: 600;
            min-width: 80px;
            color: var(--text-secondary);
        }
        
        .uploaded-file-info {
            background-color: #f9f9f9;
            border-left: 4px solid var(--success-color);
            padding: 10px 15px;
            margin-top: 10px;
            border-radius: 4px;
        }
        
        .info-url {
            word-break: break-all;
            font-family: monospace;
            background-color: #f0f0f0;
            padding: 2px 5px;
            border-radius: 3px;
        }
        
        .copy-btn {
            background: transparent;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            margin-left: 5px;
        }
        
        .api-status {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }
        
        .api-status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        
        .api-status-connected {
            background-color: var(--success-color);
        }
        
        .api-status-disconnected {
            background-color: var(--error-color);
        }
        
        .retry-indicator {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.8rem;
            margin-left: 5px;
        }
        
        .retry-icon {
            color: var(--warning-color);
        }
        
        .status-controls {
            display: flex;
            flex-direction: column;
            gap: 5px;
            align-items: flex-end;
        }
        
        .queue-indicator {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff5722;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-paper-plane"></i> 文件快递 - 专业文件上传系统</h1>
            <p>支持拖拽上传、多文件上传、进度条显示和图片预览功能</p>
        </div>
        
        <div class="card">
            <div class="card-header">
                <i class="fas fa-cog"></i> 上传设置
            </div>
            <div class="card-body">
                <div class="stats-bar">
                    <div class="stat-item">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>待上传: <span class="stat-value" id="pendingCount">0</span> 个文件</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-check-circle"></i>
                        <span>已上传: <span class="stat-value" id="completedCount">0</span> 个文件</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-sync-alt"></i>
                        <span>上传中: <span class="stat-value" id="uploadingCount">0</span> 个文件</span>
                    </div>
                </div>
                
                <div class="settings-panel">
                    <div class="setting-item">
                        <label>首页显示：</label>
                        <div class="layui-form">
                            <input type="checkbox" name="showOnHome" lay-skin="switch" lay-text="开启|关闭" checked>
                        </div>
                        <div class="upload-hint">开启后文件将在网站首页显示</div>
                    </div>
                    
                    <div class="setting-item">
                        <label>下载密码：</label>
                        <input type="text" class="layui-input" id="filePassword" placeholder="设置下载密码（留空则无密码）">
                        <div class="upload-hint">设置密码后下载文件需要输入正确密码</div>
                    </div>
                </div>
                
                <div class="api-status">
                    <span class="api-status-indicator api-status-connected"></span>
                    <span>API连接状态: 已连接 (http://file.kxlove.top/api.php)</span>
                </div>
                
                <div class="upload-area" id="uploadArea">
                    <div class="queue-indicator" id="queueIndicator">队列: 0</div>
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="upload-text">拖拽文件到此处或点击下方按钮上传</div>
                    
                    <div class="file-input-container">
                        <button class="file-input-btn">
                            <i class="fas fa-folder-open"></i> 选择文件
                        </button>
                        <input type="file" id="fileInput" class="file-input" multiple>
                    </div>
                    
                    <div class="upload-hint">支持多文件上传，单个文件最大支持100MB</div>
                    
                    <div class="upload-queue" id="uploadQueue"></div>
                    
                    <div class="thumbnail-container" id="thumbnailContainer"></div>
                </div>
                
                <div class="layui-form" style="margin-top: 20px; display: flex; gap: 10px;">
                    <button class="btn btn-primary" id="uploadBtn">
                        <i class="fas fa-paper-plane"></i> 开始上传
                    </button>
                    <button class="clear-all" id="clearAllBtn">
                        <i class="fas fa-trash-alt"></i> 清空列表
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-alt"></i> 上传文件列表
            </div>
            <div class="card-body">
                <div class="file-list" id="fileList">
                    <div class="no-files" style="text-align: center; padding: 30px; color: #95a5a6;">
                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px;"></i>
                        <p>暂无文件，请上传文件</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>文件上传系统 &copy; 2025 | 支持多文件同时上传 | 已保留上传记录</p>
        </div>
    </div>

    <!-- 引入必要的JS库 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/layui@2.6.8/dist/layui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
    $(document).ready(function() {
        // 初始化Fancybox
        Fancybox.bind();
        
        // 初始化Layui
        layui.use(['form'], function(){
            var form = layui.form;
            form.render();
        });
        
        // 文件上传区域交互
        const uploadArea = $('#uploadArea');
        const fileInput = $('#fileInput');
        const fileList = $('#fileList');
        const uploadBtn = $('#uploadBtn');
        const clearAllBtn = $('#clearAllBtn');
        const thumbnailContainer = $('#thumbnailContainer');
        const uploadQueue = $('#uploadQueue');
        const queueIndicator = $('#queueIndicator');
        
        let files = [];
        let uploadQueueItems = [];
        let isUploading = false;
        let completedCount = 0;
        let uploadingCount = 0;
        let activeXHRs = {};
        let uploadQueueIndex = 0; // 当前处理的队列索引
        
        // 更新统计信息
        function updateStats() {
            const pending = files.filter(f => !f.uploaded).length;
            $('#pendingCount').text(pending);
            $('#completedCount').text(completedCount);
            $('#uploadingCount').text(uploadingCount);
            queueIndicator.text(`队列: ${pending}`);
        }
        
        // 文件选择处理 - 支持多文件选择
        fileInput.on('change', function() {
            const newFiles = Array.from(this.files);
            newFiles.forEach(f => {
                f.uploaded = false;
                f.response = null;
                f.retryCount = 0;
                f.xhr = null;
            });
            files = [...files, ...newFiles];
            renderFileList();
            generateThumbnails(newFiles);
            updateStats();
            this.value = '';
        });
        
        // 生成上传队列显示
        function updateQueueDisplay() {
            uploadQueue.empty();
            files.forEach((file, index) => {
                if (!file.uploaded) {
                    const queueItem = $(`
                        <div class="queue-item">
                            <i class="fas fa-file"></i> ${file.name}
                        </div>
                    `);
                    uploadQueue.append(queueItem);
                }
            });
        }
        
        // 生成缩略图
        function generateThumbnails(newFiles) {
            newFiles.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const thumbnail = document.createElement('img');
                        thumbnail.src = e.target.result;
                        thumbnail.className = 'thumbnail';
                        thumbnail.title = file.name;
                        thumbnail.setAttribute('data-index', files.length - 1);
                        thumbnailContainer.append(thumbnail);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // 清空所有文件
        clearAllBtn.on('click', function() {
            if (isUploading) {
                Swal.fire({
                    icon: 'warning',
                    title: '正在上传中',
                    text: '请等待当前上传完成后再清空',
                    confirmButtonColor: '#1E9FFF'
                });
                return;
            }
            
            if (files.length > 0) {
                Swal.fire({
                    title: '确定要清空文件列表吗？',
                    text: "所有文件将被移除",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1E9FFF',
                    cancelButtonColor: '#ff4d4f',
                    confirmButtonText: '确定清空',
                    cancelButtonText: '取消'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // 中止所有正在进行的上传
                        Object.values(activeXHRs).forEach(xhr => {
                            if (xhr) {
                                xhr.abort();
                            }
                        });
                        activeXHRs = {};
                        
                        files = [];
                        completedCount = 0;
                        uploadingCount = 0;
                        uploadQueueItems = [];
                        uploadQueueIndex = 0;
                        thumbnailContainer.empty();
                        uploadQueue.empty();
                        renderFileList();
                        updateStats();
                    }
                });
            }
        });
        
        // 拖拽事件处理
        uploadArea.on('dragover', function(e) {
            e.preventDefault();
            uploadArea.addClass('dragover');
        });
        
        uploadArea.on('dragleave', function() {
            uploadArea.removeClass('dragover');
        });
        
        uploadArea.on('drop', function(e) {
            e.preventDefault();
            uploadArea.removeClass('dragover');
            
            if (e.originalEvent.dataTransfer.files.length) {
                const newFiles = Array.from(e.originalEvent.dataTransfer.files);
                newFiles.forEach(f => {
                    f.uploaded = false;
                    f.response = null;
                    f.retryCount = 0;
                    f.xhr = null;
                });
                files = [...files, ...newFiles];
                renderFileList();
                generateThumbnails(newFiles);
                updateQueueDisplay();
                updateStats();
            }
        });
        
        // 渲染文件列表
        function renderFileList() {
            if (files.length === 0) {
                fileList.html('<div class="no-files" style="text-align: center; padding: 30px; color: #95a5a6;">' +
                             '<i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px;"></i>' +
                             '<p>暂无文件，请上传文件</p></div>');
                return;
            }
            
            let html = '';
            files.forEach((file, index) => {
                const fileType = getFileType(file.type);
                const fileSize = formatFileSize(file.size);
                
                let statusClass = 'status-queued';
                let statusText = '排队中';
                
                if (file.uploaded) {
                    statusClass = 'status-success';
                    statusText = '<i class="fas fa-check"></i> 上传成功';
                } else if (uploadQueueItems.includes(index)) {
                    if (file.retryCount > 0) {
                        statusClass = 'status-retrying';
                        statusText = `重试中 (${file.retryCount}/3)...`;
                    } else {
                        statusClass = 'status-uploading';
                        statusText = '上传中...';
                    }
                }
                
                html += `
                <div class="file-item" data-index="${index}">
                    <div class="file-icon">
                        <i class="${fileType.icon}"></i>
                    </div>
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-meta">
                            <span><i class="fas fa-file"></i> ${fileType.name}</span>
                            <span><i class="fas fa-weight-hanging"></i> ${fileSize}</span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-bar" id="progress-${index}" style="${file.uploaded ? 'width:100%' : ''}"></div>
                        </div>
                        ${file.uploaded && file.response ? displayFileInfo(index, file.response, file) : ''}
                    </div>
                    <div class="file-actions">
                        <span class="status-badge ${statusClass}">${statusText}</span>
                        <div class="status-controls">
                            <button class="btn btn-outline remove-btn" data-index="${index}"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
                `;
            });
            
            fileList.html(html);
            
            // 添加移除按钮事件
            $('.remove-btn').on('click', function() {
                const index = $(this).data('index');
                const file = files[index];
                
                // 如果文件正在上传，则中止XHR请求
                if (file.xhr) {
                    file.xhr.abort();
                    delete activeXHRs[index];
                    
                    // 从上传队列中移除
                    const queueIndex = uploadQueueItems.indexOf(index);
                    if (queueIndex !== -1) {
                        uploadQueueItems.splice(queueIndex, 1);
                        uploadingCount--;
                        updateStats();
                    }
                }
                
                // 从files数组中移除
                files.splice(index, 1);
                
                // 更新UI
                thumbnailContainer.empty();
                generateThumbnails(files);
                updateQueueDisplay();
                renderFileList();
                updateStats();
                
                // 如果移除的是正在重试的文件，取消重试定时器
                if (file.retryTimer) {
                    clearTimeout(file.retryTimer);
                }
            });
        }
        
        // 获取文件类型信息
        function getFileType(type) {
            const types = {
                'image': { name: '图片', icon: 'fas fa-image' },
                'video': { name: '视频', icon: 'fas fa-video' },
                'audio': { name: '音频', icon: 'fas fa-music' },
                'application/pdf': { name: 'PDF文档', icon: 'fas fa-file-pdf' },
                'application/msword': { name: 'Word文档', icon: 'fas fa-file-word' },
                'application/vnd.ms-excel': { name: 'Excel文档', icon: 'fas fa-file-excel' },
                'application/zip': { name: '压缩文件', icon: 'fas fa-file-archive' },
                'text/plain': { name: '文本文件', icon: 'fas fa-file-alt' }
            };
            
            for (const [key, value] of Object.entries(types)) {
                if (type.includes(key)) {
                    return value;
                }
            }
            
            return { name: '其他文件', icon: 'fas fa-file' };
        }
        
        // 格式化文件大小
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        // 上传按钮点击事件
        uploadBtn.on('click', function() {
            if (isUploading) {
                Swal.fire({
                    icon: 'info',
                    title: '上传中',
                    text: '文件正在上传中，请耐心等待',
                    confirmButtonColor: '#1E9FFF'
                });
                return;
            }
            
            const pendingFiles = files.filter(f => !f.uploaded && f.retryCount < 3);
            if (pendingFiles.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: '没有可上传的文件',
                    text: '所有文件已经上传完成或已达到重试上限',
                    confirmButtonColor: '#1E9FFF'
                });
                return;
            }
            
            // 禁用上传按钮防止重复点击
            uploadBtn.prop('disabled', true);
            isUploading = true;
            
            // 获取设置
            const showOnHome = $('input[name="showOnHome"]').prop('checked') ? '1' : '0';
            const filePassword = $('#filePassword').val();
            const isPassword = filePassword ? '1' : '0';
            
            // 开始上传队列
            uploadQueueIndex = 0;
            startUploadQueue(showOnHome, isPassword, filePassword);
        });
        
        // 开始上传队列
        function startUploadQueue(show, ispwd, pwd) {
            // 重置上传队列
            uploadQueueItems = [];
            
            // 获取所有待上传文件索引
            files.forEach((file, index) => {
                if (!file.uploaded && file.retryCount < 3) {
                    uploadQueueItems.push(index);
                }
            });
            
            if (uploadQueueItems.length === 0) {
                isUploading = false;
                uploadBtn.prop('disabled', false);
                return;
            }
            
            // 开始处理队列
            processNextFileInQueue(show, ispwd, pwd);
        }
        
        // 处理队列中的下一个文件
        function processNextFileInQueue(show, ispwd, pwd) {
            if (uploadQueueIndex >= uploadQueueItems.length) {
                // 队列处理完成
                isUploading = false;
                uploadBtn.prop('disabled', false);
                
                // 检查是否所有文件都处理完毕
                const pendingFiles = files.filter(f => !f.uploaded && f.retryCount < 3);
                if (pendingFiles.length === 0) {
                    Swal.fire({
                        icon: 'success',
                        title: '全部完成',
                        text: '所有文件已处理完毕',
                        confirmButtonColor: '#1E9FFF'
                    });
                }
                return;
            }
            
            const fileIndex = uploadQueueItems[uploadQueueIndex];
            uploadFile(fileIndex, show, ispwd, pwd);
        }
        
        // 上传单个文件
        function uploadFile(index, show, ispwd, pwd) {
            if (index >= files.length) return;
            
            const file = files[index];
            uploadingCount++;
            updateStats();
            renderFileList();
            
            console.log(`开始上传第${index+1}个文件（共${files.length}个）: ${file.name}`);
            
            const formData = new FormData();
            formData.append('file', file);
            formData.append('show', show);
            formData.append('ispwd', ispwd);
            if (ispwd === '1') {
                formData.append('pwd', pwd);
            }
            
            const xhr = new XMLHttpRequest();
            file.xhr = xhr;
            activeXHRs[index] = xhr;
            
            // 进度事件
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    $(`#progress-${index}`).css('width', percent + '%');
                }
            });
            
            // 完成事件
            xhr.addEventListener('load', function() {
                try {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.code === 0) {
                            // 上传成功
                            files[index].uploaded = true;
                            files[index].response = response;
                            completedCount++;
                            
                            // 清理XHR引用
                            delete activeXHRs[index];
                            file.xhr = null;
                            
                            // 更新统计
                            uploadingCount--;
                            updateStats();
                            
                            // 重新渲染文件列表以显示文件信息
                            renderFileList();
                            
                            // 成功提示
                            Swal.fire({
                                icon: 'success',
                                title: '上传成功',
                                text: `文件 ${file.name} 已成功上传`,
                                confirmButtonColor: '#52c41a',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            // 处理队列中的下一个文件
                            uploadQueueIndex++;
                            processNextFileInQueue(show, ispwd, pwd);
                        } else {
                            // 上传失败
                            handleUploadError(index, file, response.msg || '未知错误', show, ispwd, pwd);
                        }
                    } else {
                        handleUploadError(index, file, `服务器错误: ${xhr.status}`, show, ispwd, pwd);
                    }
                } catch (e) {
                    handleUploadError(index, file, `处理响应出错: ${e.message}`, show, ispwd, pwd);
                }
            });
            
            // 错误事件
            xhr.addEventListener('error', function() {
                handleUploadError(index, file, '网络错误，请检查连接', show, ispwd, pwd);
            });
            
            // 中断事件
            xhr.addEventListener('abort', function() {
                // 仅在用户手动取消时不处理
                if (!file.userAborted) {
                    handleUploadError(index, file, '上传已中断', show, ispwd, pwd);
                }
            });
            
            // 发送请求
            xhr.open('POST', 'kingapi.php?url=http://file.kxlove.top/api.php', true);
            xhr.send(formData);
        }
        
        // 处理上传错误（带重试机制）
        function handleUploadError(index, file, message, show, ispwd, pwd) {
            // 更新统计
            uploadingCount--;
            updateStats();
            
            // 清理XHR引用
            delete activeXHRs[index];
            file.xhr = null;
            
            // 增加重试次数
            file.retryCount = file.retryCount || 0;
            file.retryCount++;
            
            // 重置用户取消标志
            file.userAborted = false;
            
            if (file.retryCount <= 3) {
                // 更新状态显示为重试中
                $(`#fileList .file-item[data-index="${index}"] .status-badge`)
                    .removeClass('status-uploading status-error')
                    .addClass('status-retrying')
                    .html(`重试中 (${file.retryCount}/3)...`);
                
                // 延迟后重试上传
                file.retryTimer = setTimeout(() => {
                    // 检查文件是否还存在（可能被用户删除了）
                    if (index >= files.length || files[index] !== file) {
                        return;
                    }
                    
                    console.log(`重试第${file.retryCount}次上传文件: ${file.name}`);
                    // 直接重新上传当前文件
                    uploadFile(index, show, ispwd, pwd);
                }, 2000); // 2秒后重试
            } else {
                // 重试3次都失败，标记为永久失败
                $(`#fileList .file-item[data-index="${index}"] .status-badge`)
                    .removeClass('status-uploading status-queued status-retrying')
                    .addClass('status-error')
                    .html(`<i class="fas fa-times"></i> 上传失败: ${message}（重试3次）`);
                
                // 处理队列中的下一个文件
                uploadQueueIndex++;
                processNextFileInQueue(show, ispwd, pwd);
            }
        }
        
        // 显示文件信息
        function displayFileInfo(index, response, file) {
            try {
                // 构建详细信息链接
                let detailUrl = 'http://file.kxlove.top/file.php';
                const params = [];
                if (response.hash && typeof response.hash === 'string') {
                    params.push(`hash=${encodeURIComponent(response.hash.trim())}`);
                }
                if (response.pwd && typeof response.pwd === 'string') {
                    params.push(`pwd=${encodeURIComponent(response.pwd.trim())}`);
                }
                if (params.length > 0) {
                    detailUrl += '?' + params.join('&');
                }
                
                // 根据文件类型决定显示方式
                if (isImageFile(file.type)) {
                    return `
                    <div class="preview-container">
                        <div class="action-buttons">
                            <a href="${response.viewurl || response.downurl}" 
                               class="btn btn-outline action-btn" 
                               data-fancybox="gallery" 
                               data-caption="${file.name}">
                                <i class="fas fa-eye"></i> 预览图片
                            </a>
                            <a href="${response.downurl}" class="btn btn-outline action-btn" download>
                                <i class="fas fa-download"></i> 下载文件
                            </a>
                            <button class="btn btn-outline action-btn" 
                                onclick="showFileInfo('${file.name}', '${response.viewurl || ''}', '${response.downurl}', '${detailUrl}')">
                                <i class="fas fa-info-circle"></i> 查看信息
                            </button>
                        </div>
                        <div class="preview-title">图片预览:</div>
                        <img src="${response.viewurl || response.downurl}" class="preview-image" alt="预览">
                    </div>
                    `;
                } else if (isMediaFile(file.type)) {
                    return `
                    <div class="preview-container">
                        <div class="action-buttons">
                            <a href="${response.viewurl || response.downurl}" class="btn btn-outline action-btn" target="_blank">
                                <i class="fas fa-play-circle"></i> 播放文件
                            </a>
                            <a href="${response.downurl}" class="btn btn-outline action-btn" download>
                                <i class="fas fa-download"></i> 下载文件
                            </a>
                            <button class="btn btn-outline action-btn" 
                                onclick="showFileInfo('${file.name}', '${response.viewurl || ''}', '${response.downurl}', '${detailUrl}')">
                                <i class="fas fa-info-circle"></i> 查看信息
                            </button>
                        </div>
                    </div>
                    `;
                } else {
                    return `
                    <div class="preview-container">
                        <div class="action-buttons">
                            <a href="${response.downurl}" class="btn btn-outline action-btn" download>
                                <i class="fas fa-download"></i> 下载文件
                            </a>
                            <button class="btn btn-outline action-btn" 
                                onclick="showFileInfo('${file.name}', '', '${response.downurl}', '${detailUrl}')">
                                <i class="fas fa-info-circle"></i> 查看信息
                            </button>
                        </div>
                    </div>
                    `;
                }
            } catch (e) {
                console.error('显示文件信息失败:', e);
                return '';
            }
        }
        
        // 判断是否为图片文件
        function isImageFile(fileType) {
            return fileType && fileType.toLowerCase().startsWith('image/');
        }
        
        // 判断是否为媒体文件（音频或视频）
        function isMediaFile(fileType) {
            return fileType && (fileType.toLowerCase().startsWith('audio/') || 
                              fileType.toLowerCase().startsWith('video/'));
        }
        
        // 显示文件信息弹窗
        window.showFileInfo = function(filename, viewurl, downurl, detailUrl) {
            let infoContent = `<div class="info-content">`;
            
            if (viewurl) {
                infoContent += `
                    <div class="info-row">
                        <span class="info-label">预览地址:</span>
                        <div class="info-url">${viewurl} <button class="copy-btn" onclick="copyToClipboard('${viewurl}')"><i class="fas fa-copy"></i></button></div>
                    </div>
                `;
            }
            
            infoContent += `
                <div class="info-row">
                    <span class="info-label">下载地址:</span>
                    <div class="info-url">${downurl} <button class="copy-btn" onclick="copyToClipboard('${downurl}')"><i class="fas fa-copy"></i></button></div>
                </div>
                <div class="info-row">
                    <span class="info-label">文件名:</span>
                    <div>${filename}</div>
                </div>
                <div class="info-row" style="margin-top: 15px;">
                    <a href="${detailUrl}" class="btn btn-outline action-btn" target="_blank" style="padding: 5px 15px;">
                        <i class="fas fa-list"></i> 详细信息点我
                    </a>
                </div>
            </div>`;
            
            const textToCopy = viewurl 
                ? `文件名: ${filename}\n预览地址: ${viewurl}\n下载地址: ${downurl}`
                : `文件名: ${filename}\n下载地址: ${downurl}`;
            
            Swal.fire({
                title: '文件信息',
                html: infoContent,
                showCancelButton: true,
                confirmButtonText: '确定',
                cancelButtonText: '复制信息',
                showCloseButton: true,
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    copyToClipboard(textToCopy);
                }
            });
        };

        // 复制到剪贴板
        window.copyToClipboard = function(text) {
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: '复制成功',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: '复制失败',
                    text: '请手动复制信息'
                });
            });
        };
    });
</script>
</body>
</html>