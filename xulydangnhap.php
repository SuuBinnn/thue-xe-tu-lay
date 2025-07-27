<?php
session_start();
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'sulydangky';
$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die('Không thể kết nối: ' . mysqli_connect_error());
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $errors = [];
    if (empty($username) || empty($password)) {
        echo "Vui lòng nhập đầy đủ thông tin.";
        exit();
    }
    $stmt = $conn->prepare('SELECT password FROM users WHERE username = ?');
    if ($stmt === false) {
        echo "Lỗi hệ thống!";
        $conn->close();
        exit();
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hash);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            $_SESSION['username'] = $username;
            echo "success";
        } else {
            echo "Sai tài khoản hoặc mật khẩu!";
        }
    } else {
        echo "Sai tài khoản hoặc mật khẩu!";
    }
    $stmt->close();
    $conn->close();
}
?>