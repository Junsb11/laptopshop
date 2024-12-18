<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maCode = $_POST['maCode'];
    $tongTien = floatval($_POST['tongTien']);
    
    // Kiểm tra mã khuyến mãi
    $stmt = $conn->prepare("SELECT * FROM ma_khuyen_mai WHERE MaCode = ? AND SoLuongDaDung < SoLuong");
    $stmt->bind_param("s", $maCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $maKM = $result->fetch_assoc();
        $giamGia = $tongTien * ($maKM['PhanTramGiam'] / 100);
        $tongTienMoi = $tongTien - $giamGia;

        // Cập nhật số lượng sử dụng
        $stmt_update = $conn->prepare("UPDATE ma_khuyen_mai SET SoLuongDaDung = SoLuongDaDung + 1 WHERE MaCode = ?");
        $stmt_update->bind_param("s", $maCode);
        $stmt_update->execute();

        echo "Áp dụng mã thành công! Số tiền giảm: " . number_format($giamGia, 0) . "đ. Tổng tiền mới: " . number_format($tongTienMoi, 0) . "đ.";
    } else {
        echo "Mã khuyến mãi không hợp lệ hoặc đã hết lượt sử dụng!";
    }
}
?>

<form action="" method="POST">
    Tổng tiền: <input type="number" name="tongTien" required><br>
    Mã khuyến mãi: <input type="text" name="maCode" required><br>
    <input type="submit" value="Áp Dụng">
</form>
