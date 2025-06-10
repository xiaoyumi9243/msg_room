<?php
session_start();

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    die("未登录");
}

echo $_SESSION['username'];
?>
