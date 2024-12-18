<?php
include '../admin/connect.php'; // Kết nối với cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Rửa dữ liệu để bảo mật
    $name = htmlspecialchars($_POST['name']);
    $feedback = htmlspecialchars($_POST['feedback']);

    // Kết nối cơ sở dữ liệu
    try {
        $conn = new PDO("mysql:host=localhost;dbname=my_database", 'my_username', 'my_password');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Thêm dữ liệu vào bảng danhgia
        $stmt = $conn->prepare("INSERT INTO danhgia (TenDangNhap, NoiDung) VALUES (:name, :feedback)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':feedback', $feedback);
        $stmt->execute();

        echo "Cảm ơn bạn đã gửi góp ý!";

    } catch(PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
    $conn = null; // Đóng kết nối
}
?>
