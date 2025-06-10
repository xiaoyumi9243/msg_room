<?php
header('Content-Type: application/json');

$users = [];
if (file_exists('users.txt')) {
    $users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $users = array_unique($users); // 去重
    $users = array_values(array_filter($users)); // 移除空值并重新索引
}

echo json_encode($users);
?>