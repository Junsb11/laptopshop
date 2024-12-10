<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include 'connect.php';

// Kiểm tra nếu có id yêu cầu bảo hành
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Truy vấn kiểm tra yêu cầu bảo hành này tồn tại
    $sql_check = "SELECT * FROM bao_hanh WHERE MaBH = '$id' AND TrangThai = 1";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Cập nhật trạng thái bảo hành thành "Đã xử lý"
        $sql_update = "UPDATE bao_hanh SET TrangThai = 2 WHERE MaBH = '$id'";
        if (mysqli_query($conn, $sql_update)) {
            // Nếu cập nhật thành công, thông báo và chuyển hướng
            echo "<script>alert('Đã xử lý yêu cầu bảo hành thành công!'); window.location.href = 'baohanhdangxuly.php';</script>";
        } else {
            // Nếu có lỗi trong quá trình cập nhật
            echo "<script>alert('Có lỗi khi cập nhật yêu cầu bảo hành.'); window.location.href = 'baohanhdangxuly.php';</script>";
        }
    } else {
        // Nếu không tìm thấy yêu cầu bảo hành
        echo "<script>alert('Yêu cầu bảo hành không tồn tại hoặc đã được xử lý.'); window.location.href = 'baohanhdangxuly.php';</script>";
    }
} else {
    // Nếu không có id, chuyển hướng về trang yêu cầu bảo hành
    echo "<script>window.location.href = 'baohanhdangxuly.php';</script>";
}

include 'inc/footer.php';
?>
