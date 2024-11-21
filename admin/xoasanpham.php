<?php
include 'connect.php';

$idsp = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Xóa các đánh giá liên quan đến sản phẩm
$sql_xoa_danhgia = "DELETE FROM danhgia WHERE MaSP = '$idsp'";
$result_xoa_danhgia = mysqli_query($conn, $sql_xoa_danhgia);

if (!$result_xoa_danhgia) {
    echo "Lỗi khi xóa đánh giá: " . mysqli_error($conn);
    exit;
}

// Tiến hành xóa sản phẩm từ bảng san_pham
$sql_xoa_sp = "DELETE FROM san_pham WHERE MaSP = '$idsp'";
$result_xoa_sp = mysqli_query($conn, $sql_xoa_sp);

if ($result_xoa_sp) {
    header("Location: xemsanpham.php");
    exit;
} else {
    echo "Xóa không thành công: " . mysqli_error($conn);
}
?>
