<?php
include '../admin/connect.php'; // Kết nối với cơ sở dữ liệu

// Kiểm tra đã đăng nhập chưa
session_start();
if (!isset($_SESSION['TenDangNhap'])) {
    header("Location: dangnhap.php");
    exit;
}

// Xử lý form gửi lên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $sql_insert_review = "INSERT INTO danhgia (MaSP, SoSao, NoiDung, TenDangNhap, NgayDG) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql_insert_review);
    $stmt->bind_param('iiss', $product_id, $rating, $comment, $_SESSION['TenDangNhap']);
    
    if ($stmt->execute()) {
        // Redirect or show success message
        exit;
    } else {
        // Error handling
        echo "Lỗi khi thêm nhận xét: " . $stmt->error;
    }
}
?>
