<?php
include 'connect.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa và kiểm tra quyền hạn
if (!isset($_SESSION['VaiTro']) || $_SESSION['VaiTro'] != 'admin') {
    echo "Bạn không có quyền truy cập.";
    exit;
}

// Kiểm tra trạng thái khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maNV = intval($_POST['maNV']);
    $trangThai = $_POST['TrangThai'];

    // Kiểm tra trạng thái hợp lệ
    if (!in_array($trangThai, ['active', 'locked'])) {
        echo "Trạng thái không hợp lệ.";
        exit;
    }

    // Kiểm tra nhân viên có tồn tại không
    $checkSql = "SELECT MaNV FROM nhan_vien WHERE MaNV = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $maNV);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows === 0) {
        echo "Mã nhân viên không tồn tại.";
        exit;
    }

    // Cập nhật trạng thái nhân viên
    $sql = "UPDATE nhan_vien SET TrangThai = ? WHERE MaNV = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $trangThai, $maNV);
    $stmt->execute();

    // Kiểm tra xem câu lệnh UPDATE có thành công không
    if ($stmt->affected_rows > 0) {
        header("Location: quanlyquyen.php?status=success");
        exit;
    } else {
        echo "Không có thay đổi nào được thực hiện.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý quyền hạn nhân viên</title>
</head>
<body>
    <h2>Quản lý quyền hạn nhân viên</h2>

    <!-- Hiển thị thông báo nếu có -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'success'): ?>
            <p style="color: green;">Cập nhật trạng thái thành công!</p>
        <?php else: ?>
            <p style="color: red;">Có lỗi xảy ra. Vui lòng thử lại.</p>
        <?php endif; ?>
    <?php endif; ?>

    <form action="quanlyquyen.php" method="post">
        <label for="maNV">Mã nhân viên:</label>
        <input type="number" name="maNV" id="maNV" required>

        <label for="trangThai">Trạng thái:</label>
        <select name="TrangThai" id="trangThai" required>
            <option value="active">Kích hoạt</option>
            <option value="locked">Khóa</option>
        </select>

        <button type="submit">Cập nhật trạng thái</button>
    </form>
</body>
</html>
