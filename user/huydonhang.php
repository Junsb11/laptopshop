<?php
include "../admin/connect.php";

// Bắt đầu session nếu chưa tồn tại
if (!isset($_SESSION)) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa, nếu chưa thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit(); // Thoát khỏi script sau khi chuyển hướng
}

// Lấy tên đăng nhập từ session
$tendn = $_SESSION['tendn'];

if (isset($_GET['mabh'])) {
    $mabh = mysqli_real_escape_string($conn, $_GET['mabh']);

    // Kiểm tra xem yêu cầu hủy có hợp lệ
    $query = "SELECT * FROM hoa_don WHERE MaHD='$mabh' AND TenDangNhap='$tendn' AND TrangThai=0";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Cập nhật trạng thái thành "Đã hủy" (TrangThai = 3)
        $update = "UPDATE hoa_don SET TrangThai=3 WHERE MaHD='$mabh'";
        if (mysqli_query($conn, $update)) {
            header("Location: dsdonhang.php?loai=choxacnhan&msg=Hủy yêu cầu thành công!");
        } else {
            header("Location: dsdonhang.php?loai=choxacnhan&msg=Hủy yêu cầu thất bại!");
        }
    } else {
        header("Location: dsdonhang.php?loai=choxacnhan&msg=Yêu cầu không hợp lệ hoặc không tìm thấy đơn hàng!");
    }
} else {
    header("Location: dsdonhang.php?loai=choxacnhan&msg=Không tìm thấy yêu cầu!");
}
?>
