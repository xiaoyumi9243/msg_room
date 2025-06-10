<?php
session_start();

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    die("未登录");
}

$username = trim($_SESSION['username']);
$filename = 'users.txt'; // 确保文件名正确

// 确保文件存在
if (!file_exists($filename)) {
    // 如果文件不存在，创建一个空文件
    file_put_contents($filename, '');
}

// 从 users.txt 中删除该用户的所有实例
$users = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$updatedUsers = [];

foreach ($users as $user) {
    $user = trim($user);
    // 保留不匹配的用户名
    if ($user !== $username) {
        $updatedUsers[] = $user;
    }
}

// 写回文件 - 删除所有匹配项
file_put_contents($filename, implode("\n", $updatedUsers));

// 销毁会话
session_destroy();

// 返回成功响应
echo "注销成功";
?>