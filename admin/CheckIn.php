<?php
include 'connect.php';
session_start();

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    echo "Vui lòng đăng nhập để thực hiện check-in.";
    exit;
}

$user_id = $_SESSION['user_id'];
$date = date('Y-m-d');
$time = date('H:i:s');

// Kiểm tra người dùng đã check-in hôm nay chưa
$sql_check = "SELECT * FROM check_in WHERE TenDangNhap = ? AND Ngay = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("is", $user_id, $date);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "Bạn đã check-in hôm nay rồi.";
} else {
    // Thực hiện check-in mới
    $sql_insert = "INSERT INTO check_in (TenDangNhap, Ngay, Time) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iss", $user_id, $date, $time);
    $stmt_insert->execute();

    if ($stmt_insert->affected_rows > 0) {
        echo "Check-in thành công lúc $time ngày $date.";
    } else {
        echo "Có lỗi xảy ra khi thực hiện check-in.";
    }
}
?>
