<?php
include 'connect.php';

// Lấy mã nhân viên từ URL
$maNV = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$maNV) {
    echo "Mã nhân viên không hợp lệ.";
    exit();
}

// Lấy thông tin nhân viên
$sql_nv = "SELECT HoTen, LuongCB FROM nhan_vien WHERE MaNV = ?";
$stmt_nv = $conn->prepare($sql_nv);
$stmt_nv->bind_param("i", $maNV);
$stmt_nv->execute();
$result_nv = $stmt_nv->get_result();
$nhan_vien = $result_nv->fetch_assoc();

if (!$nhan_vien) {
    echo "Nhân viên không tồn tại.";
    exit();
}

// Đếm số lượng hóa đơn nhân viên đã duyệt
$sql_hoadon = "SELECT COUNT(*) AS SoLuongHoaDon FROM hoa_don WHERE MaNV = ?";
$stmt_hd = $conn->prepare($sql_hoadon);
$stmt_hd->bind_param("i", $maNV);
$stmt_hd->execute();
$result_hd = $stmt_hd->get_result();
$data_hd = $result_hd->fetch_assoc();

// Đếm số lượng đơn bảo hành đã xử lý hoàn tất
$sql_baohanh = "SELECT COUNT(*) AS SoLuongBaoHanh FROM bao_hanh WHERE MaNV = ? AND TrangThai = 2";
$stmt_bh = $conn->prepare($sql_baohanh);
$stmt_bh->bind_param("i", $maNV);
$stmt_bh->execute();
$result_bh = $stmt_bh->get_result();
$data_bh = $result_bh->fetch_assoc();

// Tính toán tiền thưởng
$tong_cong_viec = $data_hd['SoLuongHoaDon'] + $data_bh['SoLuongBaoHanh'];
$thuong = $tong_cong_viec * ($nhan_vien['LuongCB'] * 0.05);
$tong_luong = $nhan_vien['LuongCB'] + $thuong;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết công nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        table {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Chi tiết Bảng Lương nhân viên</h2>

        <div class="mb-4">
            <h4>Thông tin nhân viên</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Tên nhân viên</th>
                    <td><?php echo htmlspecialchars($nhan_vien['HoTen'] ?? 'Không xác định'); ?></td>
                </tr>
                <tr>
                    <th>Lương cơ bản</th>
                    <td><?php echo number_format($nhan_vien['LuongCB'] ?? 0, 0, '.', ','); ?> đ</td>
                </tr>
            </table>
        </div>

        <div class="mb-4">
            <h4>Kết quả công việc</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Số lượng hóa đơn đã duyệt</th>
                    <td><?php echo $data_hd['SoLuongHoaDon'] ?? 0; ?></td>
                </tr>
                <tr>
                    <th>Số lượng đơn bảo hành đã xử lý</th>
                    <td><?php echo $data_bh['SoLuongBaoHanh'] ?? 0; ?></td>
                </tr>
                <tr>
                    <th>Tổng số công việc đã hoàn thành</th>
                    <td><?php echo $tong_cong_viec ?? 0; ?></td>
                </tr>
            </table>
        </div>

        <div class="mb-4">
            <h4>Bảng lương</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Tiền thưởng</th>
                    <td class="text-success"><?php echo number_format($thuong ?? 0, 0, '.', ','); ?> đ</td>
                </tr>
                <tr>
                    <th>Tổng lương</th>
                    <td class="text-primary"><?php echo number_format($tong_luong ?? 0, 0, '.', ','); ?> đ</td>
                </tr>
            </table>
        </div>

        <a href="xemnhanvien.php" class="btn btn-secondary w-100">Quay lại</a>
    </div>
</body>
</html>
