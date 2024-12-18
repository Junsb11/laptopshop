<?php
include 'connect.php';

// Hàm tạo mã code ngẫu nhiên
function taoMaCode($length = 8) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenKM = $_POST['tenKM'];
    $tuNgay = $_POST['tuNgay'];
    $denNgay = $_POST['denNgay'];
    $phanTramGiam = floatval($_POST['phanTramGiam']);
    $soLuong = intval($_POST['soLuong']);
    
    // Thêm khuyến mãi
    $stmt = $conn->prepare("INSERT INTO khuyen_mai (TenKM, TuNgay, DenNgay, TrangThai) VALUES (?, ?, ?, 1)");
    $stmt->bind_param("sss", $tenKM, $tuNgay, $denNgay);
    $stmt->execute();
    $maKM = $conn->insert_id; // Lấy ID vừa thêm

    // Tạo mã giảm giá
    for ($i = 0; $i < $soLuong; $i++) {
        $maCode = taoMaCode();
        $stmt_code = $conn->prepare("INSERT INTO ma_khuyen_mai (MaCode, MaKM, PhanTramGiam, SoLuong) VALUES (?, ?, ?, 1)");
        $stmt_code->bind_param("sii", $maCode, $maKM, $phanTramGiam);
        $stmt_code->execute();
    }
    echo "Tạo mã khuyến mãi thành công!";
}
?>

<form action="" method="POST">
    Tên khuyến mãi: <input type="text" name="tenKM" required><br>
    Từ ngày: <input type="date" name="tuNgay" required><br>
    Đến ngày: <input type="date" name="denNgay" required><br>
    Phần trăm giảm giá: <input type="number" name="phanTramGiam" step="0.01" required><br>
    Số lượng mã: <input type="number" name="soLuong" required><br>
    <input type="submit" value="Tạo Khuyến Mãi">
</form>
