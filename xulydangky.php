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
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $repassword = $_POST['repassword'] ?? '';
    $address = $_POST['address'] ?? '';
    $errors = [];
    if (empty($username) || empty($email) || empty($password) || empty($repassword) || empty($address)) {
        $errors[] = 'Vui lòng điền đầy đủ thông tin.';
    }
    if ($password !== $repassword) {
        $errors[] = 'Mật khẩu nhập lại không khớp.';
    }
    // Kiểm tra username/email đã tồn tại chưa
    $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $check->bind_param('ss', $username, $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $errors[] = 'Tên đăng nhập hoặc email đã tồn tại.';
    }
    $check->close();

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (username, email, password, address) VALUES (?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo '<p style="color:red">Lỗi prepare: ' . $conn->error . '</p>';
            echo '<p style="color:red">Câu truy vấn: ' . $sql . '</p>';
            $conn->close();
            exit();
        }
        $stmt->bind_param('ssss', $username, $email, $hash, $address);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            echo "Đăng ký thành công";
            exit();
        } else {
            echo '<p style="color:red">Lỗi khi đăng ký: ' . $conn->error . '</p>';
        }
        $stmt->close();
        $conn->close();
    } else {
        foreach ($errors as $err) {
            echo '<p style="color:red">'.$err.'</p>';
        }
    }
}
?>