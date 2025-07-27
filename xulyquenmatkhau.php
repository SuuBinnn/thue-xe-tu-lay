<?php
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
    $email = $_POST['email'] ?? '';
    if (empty($email)) {
        echo '<p style="color:red">Vui lòng nhập email đã đăng ký.</p>';
    } else {
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($result) > 0) {
            // TODO: Triển khai gửi email xác nhận reset password tại đây
            echo '<p style="color:green">Vui lòng liên hệ quản trị viên để đặt lại mật khẩu hoặc kiểm tra email nếu hệ thống đã hỗ trợ gửi lại mật khẩu!</p>';
        } else {
            echo '<p style="color:red">Email không tồn tại trong hệ thống.</p>';
        }
    }
}
?>