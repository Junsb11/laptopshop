<?php
// Khởi tạo session nếu chưa có
session_start();
include "../admin/connect.php";

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['tendn'])) {
    // Nếu không có session 'tendn', chuyển hướng về trang đăng nhập
    header("Location: dangnhap.php");
    exit();
}

// Lấy mã đơn hàng từ URL
$mahd = isset($_GET['mahd']) ? $_GET['mahd'] : 0;

// Kiểm tra nếu mã đơn hàng hợp lệ và thực hiện cập nhật trạng thái
if ($mahd > 0) {
    // Câu lệnh SQL để cập nhật trạng thái đơn hàng thành "Đang giao" (TrangThai = 1)
    $sql_update = "UPDATE hoa_don SET TrangThai = 2 WHERE MaHD = '$mahd' AND TenDangNhap = '" . $_SESSION['tendn'] . "'";

    // Thực thi câu lệnh SQL
    $result = mysqli_query($conn, $sql_update);

    // Kiểm tra kết quả của câu lệnh SQL
    if ($result) {
        // Nếu cập nhật thành công, chuyển hướng về trang đơn hàng đã giao
        header("Location: dsdonhang.php?loai=dagiao");
        exit();  // Dừng script lại sau khi chuyển hướng
    } else {
        // Nếu có lỗi khi thực hiện câu lệnh SQL
        echo "Có lỗi xảy ra khi cập nhật đơn hàng: " . mysqli_error($conn);
    }
} else {
    // Nếu mã đơn hàng không hợp lệ
    echo "Mã đơn hàng không hợp lệ.";
}
?>
