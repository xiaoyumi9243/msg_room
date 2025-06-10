<?php
header('Content-Type: application/json');

$lastId = isset($_GET['last_id']) ? (int)$_GET['last_id'] : 0;

// 读取消息文件
$messages = [];
if (file_exists('messages.txt')) {
    $lines = file('messages.txt', FILE_IGNORE_NEW_LINES);
    
    // 只返回新消息
    for ($i = $lastId; $i < count($lines); $i++) {
        $line = $lines[$i];
        $isSystem = strpos($line, '系统: ') === 0;
        
        if ($isSystem) {
            $messages[] = [
                'id' => $i + 1,
                'is_system' => true,
                'content' => $line
            ];
        } else {
            $parts = explode(': ', $line, 2);
            $messages[] = [
                'id' => $i + 1,
                'is_system' => false,
                'username' => $parts[0],
                'content' => $parts[1] ?? ''
            ];
        }
    }
}

echo json_encode(['messages' => $messages]);
?>