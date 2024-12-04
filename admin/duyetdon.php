<?php
include 'connect.php';

// Lấy id đơn hàng từ query string
$idhd = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($idhd) {
    // Câu lệnh cập nhật trạng thái đơn hàng
    $sql_update = "UPDATE hoa_don SET TrangThai = 1 WHERE MaHD = ?";
    
    // Sử dụng prepared statement để bảo mật
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $idhd);
    
    if ($stmt->execute()) {
        // Chuyển hướng về trang quản lý đơn hàng
        header("Location: donhangchoxetduyet.php");
        exit();
    } else {
        echo "Chuyển trạng thái đơn không thành công: " . $conn->error;
    }
    
    $stmt->close();
} else {
    echo "ID đơn hàng không hợp lệ.";
}

// Đóng kết nối
$conn->close();
?>
