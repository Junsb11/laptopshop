<?php
include 'connect.php';
session_start();

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    echo "Vui lòng đăng nhập để thực hiện check-out.";
    exit;
}

$user_id = $_SESSION['user_id'];
$date = date('Y-m-d');
$time = date('H:i:s');

// Kiểm tra người dùng đã check-in hôm nay chưa
$sql_check = "SELECT * FROM check_in WHERE user_id = ? AND date = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("is", $user_id, $date);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Kiểm tra người dùng đã check-out hôm nay chưa
    $sql_checkout_check = "SELECT * FROM check_out WHERE TenDangNhap = ? AND Ngay= ?";
    $stmt_checkout_check = $conn->prepare($sql_checkout_check);
    $stmt_checkout_check->bind_param("is", $user_id, $date);
    $stmt_checkout_check->execute();
    $result_checkout_check = $stmt_checkout_check->get_result();

    if ($result_checkout_check->num_rows > 0) {
        echo "Bạn đã check-out hôm nay rồi.";
    } else {
        // Thực hiện check-out mới
        $sql_checkout = "INSERT INTO check_out (TenDangNhap, Ngay, Time) VALUES (?, ?, ?)";
        $stmt_checkout = $conn->prepare($sql_checkout);
        $stmt_checkout->bind_param("iss", $user_id, $date, $time);
        $stmt_checkout->execute();

        if ($stmt_checkout->affected_rows > 0) {
            echo "Check-out thành công lúc $time ngày $date.";
        } else {
            echo "Có lỗi xảy ra khi thực hiện check-out.";
        }
    }
} else {
    echo "Bạn chưa check-in hôm nay, không thể check-out.";
}
?>
