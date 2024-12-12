<?php

include 'connect.php';

// Lấy id từ URL và kiểm tra tính hợp lệ
$idbh = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$error_message = null;
$data = null;
$details = [];
$groupedDetails = [];

if ($idbh) {
    // Lấy thông tin bảo hành từ cơ sở dữ liệu
    $sql_baohanh = "SELECT bh.*, sp.TenSP, nv.HoTen FROM bao_hanh bh 
                    JOIN san_pham sp ON bh.MaSP = sp.MaSP
                    LEFT JOIN nhan_vien nv ON bh.MaNV = nv.MaNV
                    WHERE bh.MaBH = ?";
    $stmt = $conn->prepare($sql_baohanh);
    if ($stmt) {
        $stmt->bind_param("i", $idbh);
        $stmt->execute();
        $result_baohanh = $stmt->get_result();
        $data = $result_baohanh->fetch_assoc();

        if ($data) {
            // Lấy thông tin chi tiết xử lý từ bảng chi_tiet_bao_hanh
            $sql_chitiet = "SELECT MoTaChiTiet, NgayThem, COUNT(*) as SoLuong FROM chi_tiet_bao_hanh WHERE MaBH = ? GROUP BY MoTaChiTiet, NgayThem";
            $stmt_chitiet = $conn->prepare($sql_chitiet);
            if ($stmt_chitiet) {
                $stmt_chitiet->bind_param("i", $idbh);
                $stmt_chitiet->execute();
                $result_chitiet = $stmt_chitiet->get_result();
                $groupedDetails = $result_chitiet->fetch_all(MYSQLI_ASSOC);
            }
        } else {
            $error_message = "Không tìm thấy yêu cầu bảo hành.";
        }
    } else {
        $error_message = "Lỗi truy vấn cơ sở dữ liệu.";
    }
} else {
    $error_message = "Mã bảo hành không hợp lệ.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bảo hành</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 900px;
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Chi tiết bảo hành</h2>

        <?php if ($error_message): ?>
            <div class="alert alert-danger text-center">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Thông tin yêu cầu bảo hành</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Mã yêu cầu bảo hành:</strong> <?php echo htmlspecialchars($data['MaBH']); ?></li>
                        <li class="list-group-item"><strong>Sản phẩm:</strong> <?php echo htmlspecialchars($data['TenSP']); ?></li>
                        <li class="list-group-item"><strong>Nhân viên xử lý:</strong> <?php echo htmlspecialchars($data['HoTen'] ?? 'Chưa phân công'); ?></li>
                        <li class="list-group-item"><strong>Vấn đề:</strong> <?php echo htmlspecialchars($data['LyDo']); ?></li>
                        <li class="list-group-item"><strong>Ngày yêu cầu:</strong> <?php echo htmlspecialchars($data['NgayYeuCau']); ?></li>
                        <li class="list-group-item"><strong>Trạng thái:</strong> <?php echo ($data['TrangThai'] == 1) ? 'Đang xử lý' : 'Đã xử lý'; ?></li>
                        <?php if (!empty($data['NgayHen'])): ?>
                            <li class="list-group-item"><strong>Ngày hẹn:</strong> <?php echo htmlspecialchars($data['NgayHen']); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4>Chi tiết xử lý</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($groupedDetails)): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mô tả</th>
                                    <th>Ngày thêm</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($groupedDetails as $detail): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($detail['MoTaChiTiet']); ?></td>
                                        <td><?php echo htmlspecialchars($detail['NgayThem']); ?></td>
                                        <td><?php echo htmlspecialchars($detail['SoLuong']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Chưa có thông tin chi tiết xử lý.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <a href="baohanhchoxuly.php" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
</body>
</html>
