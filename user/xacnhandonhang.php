<?php
include "../admin/connect.php";

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit();
}

// Lấy mã đơn hàng từ URL
$mahd = isset($_GET['mahd']) ? $_GET['mahd'] : 0;

// Cập nhật trạng thái đơn hàng thành "Đã giao" (TrangThai = 2)
if ($mahd > 0) {
    $sql_update = "UPDATE hoa_don SET TrangThai = 1 WHERE MaHD = '$mahd' AND TenDangNhap = '" . $_SESSION['tendn'] . "'";
    $result = mysqli_query($conn, $sql_update);

    if ($result) {
        echo "Cảm ơn bạn! Đơn hàng đã được xác nhận là đã giao.";
        header("Location: dsdonhang.php?loai=dagiao");
        exit();
    } else {
        echo "Có lỗi xảy ra khi cập nhật đơn hàng.";
    }
}
?>
