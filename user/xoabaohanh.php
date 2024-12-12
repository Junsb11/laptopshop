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

if (isset($_GET['mabh'])) {
    $mabh = mysqli_real_escape_string($conn, $_GET['mabh']);
    $tendn = $_SESSION['tendn'];

    // Kiểm tra xem yêu cầu bảo hành thuộc quyền của người dùng và đã hoàn thành
    $query = "SELECT * FROM bao_hanh WHERE MaBH='$mabh' AND TenDangNhap='$tendn' AND TrangThai=2";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Xóa yêu cầu bảo hành
        $delete = "DELETE FROM bao_hanh WHERE MaBH='$mabh'";
        if (mysqli_query($conn, $delete)) {
            header("Location: dsbaohanh.php?loai=dahoanthanh&msg=Xóa yêu cầu bảo hành thành công!");
        } else {
            header("Location: dsbaohanh.php?loai=dahoanthanh&msg=Xóa yêu cầu bảo hành thất bại!");
        }
    } else {
        header("Location: dsbaohanh.php?loai=dahoanthanh&msg=Yêu cầu bảo hành không hợp lệ!");
    }
} else {
    header("Location: dsbaohanh.php?loai=dahoanthanh&msg=Không tìm thấy yêu cầu bảo hành!");
}
?>
