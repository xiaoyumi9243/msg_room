<?php
session_start();

// 检查是否已登录
if (!isset($_SESSION['username'])) {
    die("未登录");
}

// 获取POST数据
$username = $_SESSION['username'];
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (!empty($message)) {
    // 保存消息到文件
    $content = "$username: $message\n";
    file_put_contents('messages.txt', $content, FILE_APPEND);
    
    echo "消息已发送";
} else {
    echo "消息不能为空";
}
?>