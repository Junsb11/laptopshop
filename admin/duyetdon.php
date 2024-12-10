<?php
include 'connect.php';

// Lấy id từ URL và kiểm tra tính hợp lệ
$idhd = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($idhd) {
    // Lấy thông tin đơn hàng từ cơ sở dữ liệu
    $sql_donhang = "SELECT * FROM hoa_don WHERE MaHD = ?";
    $stmt = $conn->prepare($sql_donhang);
    $stmt->bind_param("i", $idhd);  // Liên kết tham số
    $stmt->execute();
    $result_donhang = $stmt->get_result();
    $data = $result_donhang->fetch_array();

    // Xử lý form gửi lên
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy mã nhân viên và ngày duyệt từ form
        $maNV = filter_input(INPUT_POST, 'maNV', FILTER_VALIDATE_INT);
        $ngayDuyet = date('Y-m-d H:i:s'); // Ngày giờ hiện tại

        if ($maNV && $ngayDuyet) {
            // Cập nhật trạng thái đơn hàng và thêm mã nhân viên và ngày duyệt
            $sql_update = "UPDATE hoa_don SET MaNV = ?, NgayDuyet = ?, TrangThai = 1 WHERE MaHD = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("isi", $maNV, $ngayDuyet, $idhd);

            if ($stmt_update->execute()) {
                // Nếu thành công, chuyển hướng về danh sách đơn hàng chờ xét duyệt
                header("Location: donhangchoxetduyet.php");
                exit();
            } else {
                $error_message = "Cập nhật không thành công.";
            }
        } else {
            $error_message = "Dữ liệu không hợp lệ.";
        }
    }
} else {
    echo "Mã đơn hàng không hợp lệ.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyệt đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .form-control, .btn {
            margin-bottom: 15px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Duyệt đơn hàng</h2>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="duyetdon.php?id=<?php echo $idhd; ?>" method="POST">
            <div class="mb-3">
                <label for="maNV" class="form-label">Mã nhân viên:</label>
                <input type="text" id="maNV" name="maNV" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ngayDuyet" class="form-label">Ngày duyệt:</label>
                <input type="text" id="ngayDuyet" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" disabled>
            </div>

            <button type="submit" class="btn btn-primary w-100">Duyệt đơn</button>
        </form>

        <br>
        <a href="donhangchoxetduyet.php" class="btn btn-secondary w-100">Quay lại danh sách đơn hàng</a>
    </div>
</body>
</html>
