<?php
// Bắt đầu session và kiểm tra đăng nhập
session_start();

if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit();
}

// Kết nối CSDL
include "../admin/connect.php";

// Kiểm tra và lấy dữ liệu từ form
$txtproduct = $_POST['txtproduct'] ?? '';
$txtreason = $_POST['txtreason'] ?? '';
$txtaccessories = $_POST['txtaccessories'] ?? '';
$txtngayyeucau = date('Y-m-d H:i:s');  // Lấy thời gian hiện tại cho NgayYeuCau

if (empty($txtproduct) || empty($txtreason)) {
    echo "Vui lòng điền đầy đủ thông tin!";
    exit();
}

// Lấy thông tin sản phẩm và đơn hàng
$sql_insert = "INSERT INTO bao_hanh (TenDangNhap, MaSP, LyDo, NgayYeuCau,GhiChu) 
               VALUES (?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("sssss", $_SESSION['tendn'], $txtproduct, $txtreason, $txtaccessories, $txtngayyeucau);

if ($stmt_insert->execute()) {
    echo "Yêu cầu bảo hành của bạn đã được gửi thành công!";
} else {
    echo "Có lỗi xảy ra, vui lòng thử lại!";
}

$stmt_insert->close();
$conn->close();
?>
