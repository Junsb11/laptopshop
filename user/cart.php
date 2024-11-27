<?php
if (!isset($_SESSION)) {
    session_start();
}
include '../admin/connect.php';

// Lấy tham số từ GET và làm sạch
$masp = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$quantity = filter_input(INPUT_GET, 'quantity', FILTER_SANITIZE_NUMBER_INT);

// Kiểm tra thông tin đầu vào
if (!isset($masp) || !isset($quantity) || $quantity <= 0) {
    header("Location: chitietsp.php?id=$masp&error=invalid_quantity");
    exit;
}

// Truy vấn sản phẩm bằng prepared statement
$stmt = $conn->prepare("SELECT * FROM san_pham WHERE MaSP = ?");
$stmt->bind_param("i", $masp);
$stmt->execute();
$result_sp = $stmt->get_result();

// Kiểm tra nếu sản phẩm tồn tại
if ($row_sp = $result_sp->fetch_assoc()) {
    // Cập nhật hoặc thêm sản phẩm vào giỏ hàng
    if (!empty($_SESSION['cart'][$masp])) {
        $_SESSION['cart'][$masp]['sl'] += $quantity;
    } else {
        $_SESSION['cart'][$masp] = array(
            "idsp" => $row_sp['MaSP'],
            "tensp" => $row_sp['TenSP'],
            "sl" => $quantity,
            "dongia" => $row_sp['DonGia'],
            "hinhanh" => $row_sp['HinhAnh']
        );
    }
    // Chuyển hướng đến giỏ hàng
    header("Location: listcart.php");
} else {
    // Sản phẩm không tồn tại
    header("Location: chitietsp.php?id=$masp&error=product_not_found");
}

$stmt->close();
$conn->close();
?>
