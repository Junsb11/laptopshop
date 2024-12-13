<?php
include "../admin/connect.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Bắt đầu session nếu chưa tồn tại
if (!isset($_SESSION)) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa, nếu chưa thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit();
}

// Lấy mã hóa đơn từ tham số GET
if (isset($_GET['mahd'])) {
    $mahd = $_GET['mahd'];

    // Kiểm tra xem hóa đơn có tồn tại và thuộc về người dùng hiện tại không
    $tendn = $_SESSION['tendn'];
    $sql_check = "SELECT * FROM hoa_don WHERE MaHD = '$mahd' AND TenDangNhap = '$tendn' AND TrangThai = 3";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Cập nhật trạng thái của hóa đơn thành "Chờ xác nhận" (0)
        $sql_update = "UPDATE hoa_don SET TrangThai = 0 WHERE MaHD = '$mahd'";

        if (mysqli_query($conn, $sql_update)) {
            $msg = "Khôi phục đơn hàng thành công.";
        } else {
            $msg = "Lỗi khi khôi phục đơn hàng: " . mysqli_error($conn);
        }
    } else {
        $msg = "Đơn hàng không tồn tại hoặc không hợp lệ.";
    }
} else {
    $msg = "Không tìm thấy mã hóa đơn.";
}

// Chuyển hướng về trang danh sách đơn hàng với thông báo
header("Location: dsdonhang.php?loai=dahuy&msg=" . urlencode($msg));
exit();
?>
