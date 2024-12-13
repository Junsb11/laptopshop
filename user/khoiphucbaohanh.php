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

// Lấy mã bảo hành từ tham số GET
if (isset($_GET['mabh'])) {
    $mabh = $_GET['mabh'];

    // Kiểm tra xem bảo hành có tồn tại và thuộc về người dùng hiện tại không
    $tendn = $_SESSION['tendn'];
    $sql_check = "SELECT * FROM bao_hanh WHERE MaBH = '$mabh' AND TenDangNhap = '$tendn' AND TrangThai = 3";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Cập nhật trạng thái của bảo hành thành "Chờ xử lý" (0)
        $sql_update = "UPDATE bao_hanh SET TrangThai = 0 WHERE MaBH = '$mabh'";

        if (mysqli_query($conn, $sql_update)) {
            $msg = "Khôi phục yêu cầu bảo hành thành công.";
        } else {
            $msg = "Lỗi khi khôi phục yêu cầu bảo hành: " . mysqli_error($conn);
        }
    } else {
        $msg = "Yêu cầu bảo hành không tồn tại hoặc không hợp lệ.";
    }
} else {
    $msg = "Không tìm thấy mã bảo hành.";
}

// Chuyển hướng về trang danh sách bảo hành với thông báo
header("Location: dsbaohanh.php?loai=dahuy&msg=" . urlencode($msg));
exit();
?>
