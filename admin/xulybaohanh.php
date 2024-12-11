<?php
include 'connect.php';

// Lấy id từ URL và kiểm tra tính hợp lệ
$idbh = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($idbh) {
    // Lấy thông tin bảo hành từ cơ sở dữ liệu
    $sql_baohanh = "SELECT * FROM bao_hanh WHERE MaBH = ?";
    $stmt = $conn->prepare($sql_baohanh);
    $stmt->bind_param("i", $idbh);  // Liên kết tham số
    $stmt->execute();
    $result_baohanh = $stmt->get_result();
    $data = $result_baohanh->fetch_array();

    // Xử lý form gửi lên
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy mã nhân viên và ngày hẹn từ form
        $maNV = filter_input(INPUT_POST, 'maNV', FILTER_VALIDATE_INT);
        $ngayHen = filter_input(INPUT_POST, 'ngayHen', FILTER_SANITIZE_STRING);

        // Kiểm tra tính hợp lệ của ngày hẹn
        $date_check = DateTime::createFromFormat('Y-m-d\TH:i', $ngayHen);
        $is_valid_date = $date_check && $date_check->format('Y-m-d\TH:i') === $ngayHen;

        if ($maNV && $is_valid_date) {
            // Cập nhật trạng thái yêu cầu bảo hành và thêm mã nhân viên và ngày hẹn
            $sql_update = "UPDATE bao_hanh SET MaNV = ?, NgayHen = ?, TrangThai = 1 WHERE MaBH = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("isi", $maNV, $ngayHen, $idbh);

            if ($stmt_update->execute()) {
                // Nếu thành công, chuyển hướng về danh sách yêu cầu bảo hành
                header("Location: baohanhchoxuly.php");
                exit();
            } else {
                $error_message = "Cập nhật không thành công.";
            }
        } else {
            $error_message = "Dữ liệu không hợp lệ. Hãy kiểm tra lại.";
        }
    }
} else {
    echo "Mã bảo hành không hợp lệ.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xử lý yêu cầu bảo hành</title>
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
        <h2 class="text-center">Xử lý yêu cầu bảo hành</h2>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="xulybaohanh.php?id=<?php echo $idbh; ?>" method="POST">
            <div class="mb-3">
                <label for="maNV" class="form-label">Mã nhân viên:</label>
                <input type="text" id="maNV" name="maNV" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ngayHen" class="form-label">Ngày hẹn:</label>
                <input type="datetime-local" id="ngayHen" name="ngayHen" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Xử lý</button>
        </form>

        <br>
        <a href="baohanhchoxuly.php" class="btn btn-secondary w-100">Quay lại danh sách yêu cầu bảo hành</a>
    </div>
</body>
</html>
