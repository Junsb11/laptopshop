<?php
include 'connect.php';

// Lấy id từ URL và kiểm tra tính hợp lệ
$idbh = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($idbh) {
    // Lấy thông tin bảo hành từ cơ sở dữ liệu
    $sql_baohanh = "SELECT bh.*, sp.TenSP FROM bao_hanh bh 
                    JOIN san_pham sp ON bh.MaSP = sp.MaSP
                    WHERE MaBH = ?";
    $stmt = $conn->prepare($sql_baohanh);
    $stmt->bind_param("i", $idbh);
    $stmt->execute();
    $result_baohanh = $stmt->get_result();
    $data = $result_baohanh->fetch_array();

    if ($data) {
        // Xử lý form gửi lên
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy mã nhân viên và chi tiết xử lý từ form
            $maNV = filter_input(INPUT_POST, 'maNV', FILTER_VALIDATE_INT);
            $chiTiet = filter_input(INPUT_POST, 'chiTiet', FILTER_SANITIZE_STRING);

            if ($maNV && !empty($chiTiet)) {
                // Cập nhật trạng thái yêu cầu bảo hành và thêm mã nhân viên
                $sql_update = "UPDATE bao_hanh SET MaNV = ?, TrangThai = 2 WHERE MaBH = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("ii", $maNV, $idbh);

                if ($stmt_update->execute()) {
                    // Thêm thông tin chi tiết xử lý vào bảng `chi_tiet_bao_hanh`
                    $sql_chitiet = "INSERT INTO chi_tiet_bao_hanh (MaBH, MoTaChiTiet) VALUES (?, ?)";
                    $stmt_chitiet = $conn->prepare($sql_chitiet);
                    $stmt_chitiet->bind_param("is", $idbh, $chiTiet);
                    $stmt_chitiet->execute();

                    // Gửi thông báo cho người dùng
                    $thongBao = "Yêu cầu bảo hành của bạn đã được xử lý.";
                    $trangThai = 0; // Chưa đọc
                    $sql_thongbao = "INSERT INTO thong_bao (TenDangNhap, NoiDung, NgayGui, TrangThai) VALUES (?, ?, NOW(), ?)";
                    $stmt_thongbao = $conn->prepare($sql_thongbao);
                    $stmt_thongbao->bind_param("ssi", $data['TenDangNhap'], $thongBao, $trangThai);
                    $stmt_thongbao->execute();

                    // Chuyển hướng về danh sách bảo hành đã xử lý
                    header("Location: baohanhdaxuly.php");
                    exit();
                } else {
                    $error_message = "Cập nhật không thành công. Vui lòng thử lại.";
                }
            } else {
                $error_message = "Dữ liệu không hợp lệ. Vui lòng kiểm tra lại thông tin.";
            }
        }
    } else {
        $error_message = "Không tìm thấy yêu cầu bảo hành.";
    }
} else {
    $error_message = "Mã bảo hành không hợp lệ.";
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

        <form action="daxuly.php?id=<?php echo $idbh; ?>" method="POST">
            <div class="mb-3">
                <label for="maNV" class="form-label">Mã nhân viên xử lý:</label>
                <input type="text" id="maNV" name="maNV" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="chiTiet" class="form-label">Chi tiết xử lý:</label>
                <textarea id="chiTiet" name="chiTiet" class="form-control" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Hoàn tất xử lý</button>
        </form>

        <br>
        <a href="baohanhchoxuly.php" class="btn btn-secondary w-100">Quay lại danh sách bảo hành</a>

        <h4 class="mt-5">Thông tin yêu cầu bảo hành:</h4>
        <ul>
            <li><strong>Mã yêu cầu bảo hành:</strong> <?php echo htmlspecialchars($data['MaBH']); ?></li>
            <li><strong>Sản phẩm:</strong> <?php echo htmlspecialchars($data['TenSP']); ?></li>
            <li><strong>Vấn đề:</strong> <?php echo htmlspecialchars($data['LyDo']); ?></li>
            <li><strong>Ngày yêu cầu:</strong> <?php echo htmlspecialchars($data['NgayYeuCau']); ?></li>
        </ul>
    </div>
</body>
</html>
