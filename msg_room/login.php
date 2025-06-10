<?php
// 开启错误报告
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 确保会话启动
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 确保数据文件存在
function ensureFilesExist() {
    $files = ['messages.txt', 'users.txt'];
    foreach ($files as $file) {
        if (!file_exists($file)) {
            file_put_contents($file, '');
            chmod($file, 0666);
        }
    }
}

ensureFilesExist();

// 处理登录请求
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = trim($_POST['username']);
    
    // 验证用户名
    if (empty($username)) {
        http_response_code(400);
        die("用户名不能为空");
    }
    
    if (strlen($username) > 20) {
        http_response_code(400);
        die("用户名太长(最多20个字符)");
    }
    
    // 过滤特殊字符但保留基本标点
    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    
    // 设置会话
    $_SESSION['username'] = $username;
    
    // 记录用户加入
    file_put_contents('users.txt', $username . PHP_EOL, FILE_APPEND);
    file_put_contents('messages.txt', "系统: {$username} 加入了聊天室" . PHP_EOL, FILE_APPEND);
    
    // 成功响应
    http_response_code(200);
    exit;
}

// 如果不是POST请求，返回错误
http_response_code(400);
die("无效请求");
?>