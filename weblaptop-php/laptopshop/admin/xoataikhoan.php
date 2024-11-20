<?php
session_start(); // Bắt đầu session ở đầu tệp

include 'connect.php';

// Kiểm tra xem ID có được cung cấp trong URL không
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
if (!$id) {
    echo "ID tài khoản không hợp lệ.";
    exit;
}

// Tạm thời vô hiệu hóa kiểm tra ràng buộc khóa ngoại
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

// Xóa tài khoản từ cơ sở dữ liệu
$sql_delete = "DELETE FROM tai_khoan WHERE TenDangNhap = '$id'";
if (mysqli_query($conn, $sql_delete)) {
    echo "<script>
            alert('Tài khoản đã được xóa thành công.');
            window.location.href = 'xemtaikhoan.php';
          </script>";
} else {
    echo "Lỗi: " . mysqli_error($conn);
}

// Bật lại kiểm tra ràng buộc khóa ngoại
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
?>
