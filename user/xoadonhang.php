<?php
include "../admin/connect.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit();
}

if (isset($_GET['mahd'])) {
    $mahd = mysqli_real_escape_string($conn, $_GET['mahd']);
    $tendn = $_SESSION['tendn'];

    // Kiểm tra xem đơn hàng thuộc quyền của người dùng và đã giao
    $query = "SELECT * FROM hoa_don WHERE MaHD='$mahd' AND TenDangNhap='$tendn' AND TrangThai=2";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Xóa đơn hàng
        $delete = "DELETE FROM hoa_don WHERE MaHD='$mahd'";
        if (mysqli_query($conn, $delete)) {
            header("Location: dsdonhang.php?loai=dagiao&msg=Xóa đơn hàng thành công!");
        } else {
            header("Location: dsdonhang.php?loai=dagiao&msg=Xóa đơn hàng thất bại!");
        }
    } else {
        header("Location: dsdonhang.php?loai=dagiao&msg=Đơn hàng không hợp lệ!");
    }
} else {
    header("Location: dsdonhang.php?loai=dagiao&msg=Không tìm thấy đơn hàng!");
}
?>
