<?php
session_start();
include '../admin/connect.php';

if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit();
}

$tendn = $_SESSION['tendn'];
$txthoten = $_POST['txthoten'];
$txtsdt = $_POST['txtsdt'];
$txtemail = $_POST['txtemail'];
$txtdiachi = $_POST['txtdiachi'];
$txtproduct = $_POST['txtproduct'];
$txtreason = $_POST['txtreason'];
$txtdate = $_POST['txtdate'];
$txtreturn_date = $_POST['txtreturn_date'];
$txtaccessories = $_POST['txtaccessories'];

// Kiểm tra các trường dữ liệu trước khi insert
if (empty($txthoten) || empty($txtsdt) || empty($txtemail) || empty($txtdiachi) || empty($txtproduct) || empty($txtreason) || empty($txtreturn_date)) {
    echo "Vui lòng điền đầy đủ thông tin!";
    exit();
}

// Insert yêu cầu bảo hành vào cơ sở dữ liệu
$sql = "INSERT INTO bao_hanh (TenDangNhap, HoTen, SDT, Email, DiaChi, SanPham, LyDo, NgayLap, NgayTra, PhuKien, TrangThai) 
        VALUES ('$tendn', '$txthoten', '$txtsdt', '$txtemail', '$txtdiachi', '$txtproduct', '$txtreason', '$txtdate', '$txtreturn_date', '$txtaccessories', 0)";

if (mysqli_query($conn, $sql)) {
    echo "Yêu cầu bảo hành của bạn đã được gửi thành công!";
    // Có thể chuyển hướng đến trang khác hoặc hiển thị thông báo
    header("Location: yeucaubaohanh.php?success=1");
} else {
    echo "Có lỗi xảy ra, vui lòng thử lại sau.";
}
?>
