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

if (isset($_GET['madh'])) {
    $madh = mysqli_real_escape_string($conn, $_GET['madh']);
    $tendn = $_SESSION['tendn'];

    // Kiểm tra xem đơn hàng thuộc quyền của người dùng và đang chờ xử lý
    $query = "SELECT * FROM don_hang WHERE MaDH='$madh' AND TenDangNhap='$tendn' AND TrangThai=0";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Cập nhật trạng thái thành "Đã hủy" (TrangThai = 3)
        $update = "UPDATE hoa_don SET TrangThai=3 WHERE MaHD='$madh'";
        if (mysqli_query($conn, $update)) {
            header("Location: dsdonhang.php?loai=choxuly&msg=Hủy đơn hàng thành công!");
        } else {
            header("Location: dsdonhang.php?loai=choxuly&msg=Hủy đơn hàng thất bại!");
        }
    } else {
        header("Location: dsdonhang.php?loai=choxuly&msg=Đơn hàng không hợp lệ!");
    }
} else {
    header("Location: dsdonhang.php?loai=choxuly&msg=Không tìm thấy đơn hàng!");
}
?>
