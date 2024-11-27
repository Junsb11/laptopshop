<?php
if (!isset($_SESSION)) {
    session_start();
}
include '../admin/connect.php';

// Kiểm tra nếu giỏ hàng chưa được khởi tạo
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

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

// Kiểm tra nếu có lỗi trong quá trình truy vấn
if ($stmt->error) {
    echo "Error executing query: " . $stmt->error;
    exit;
}

$result_sp = $stmt->get_result();

// Kiểm tra nếu sản phẩm tồn tại
if ($row_sp = $result_sp->fetch_assoc()) {
    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    if (isset($_SESSION['cart'][$masp])) {
        // Nếu sản phẩm đã có, chỉ tăng số lượng
        $_SESSION['cart'][$masp]['sl'] += $quantity;
    } else {
        // Nếu chưa có, thêm sản phẩm mới vào giỏ hàng
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
    exit;
} else {
    // Sản phẩm không tồn tại
    header("Location: chitietsp.php?id=$masp&error=product_not_found");
    exit;
}

$stmt->close();
$conn->close();
?>
