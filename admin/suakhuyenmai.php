<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include 'connect.php';

// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

// Kiểm tra tham số ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy dữ liệu khuyến mãi từ bảng khuyen_mai
    $stmt = $conn->prepare("SELECT * FROM khuyen_mai WHERE MaKM = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        die("Không tìm thấy khuyến mãi với ID: $id");
    }
    $stmt->close();

    // Lấy dữ liệu chi tiết khuyến mãi từ bảng chi_tiet_khuyen_mai
    $stmt_detail = $conn->prepare("SELECT * FROM chi_tiet_khuyen_mai WHERE MaKM = ?");
    $stmt_detail->bind_param("i", $id);
    $stmt_detail->execute();
    $result_detail = $stmt_detail->get_result();
    $detail = $result_detail->num_rows > 0 ? $result_detail->fetch_assoc() : [];
    $stmt_detail->close();
} else {
    die("ID không hợp lệ hoặc không được cung cấp.");
}

// Xử lý dữ liệu form khi gửi POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy và xử lý dữ liệu đầu vào
    $tenkm = isset($_POST['tenkm']) ? trim($_POST['tenkm']) : '';
    $tungay = isset($_POST['tungay']) && !empty($_POST['tungay']) ? $_POST['tungay'] : $data['TuNgay'];
    $denngay = isset($_POST['denngay']) && !empty($_POST['denngay']) ? $_POST['denngay'] : $data['DenNgay'];
    $trangthai = isset($_POST['trangthai']) ? intval($_POST['trangthai']) : 0;

    $masp = isset($_POST['MaSP']) ? trim($_POST['MaSP']) : '';
    $tylekm = isset($_POST['TyleKM']) ? floatval($_POST['TyleKM']) : 0;
    $soluong = isset($_POST['SoLuong']) ? intval($_POST['SoLuong']) : 0;
    $macode = isset($_POST['MaCode']) ? trim($_POST['MaCode']) : '';
    $ghichu = isset($_POST['GhiChu']) ? trim($_POST['GhiChu']) : '';

    // Kiểm tra dữ liệu bắt buộc
    if ($tenkm === '') {
        echo "<div style='color: red;'>Tên khuyến mãi không được để trống.</div>";
    } else {
        // Cập nhật bảng khuyen_mai
        $stmt_update = $conn->prepare("UPDATE khuyen_mai SET TenKM = ?, TuNgay = ?, DenNgay = ?, TrangThai = ? WHERE MaKM = ?");
        $stmt_update->bind_param("sssii", $tenkm, $tungay, $denngay, $trangthai, $id);

        if ($stmt_update->execute()) {
            echo "<div style='color: green;'>Cập nhật thông tin khuyến mãi thành công!</div>";

            // Kiểm tra dữ liệu chi tiết khuyến mãi
            if (!empty($detail)) {
                $stmt_update_detail = $conn->prepare(
                    "UPDATE chi_tiet_khuyen_mai SET  TyleKM = ?, SoLuong = ?, MaCode = ?, GhiChu = ? WHERE MaKM = ?"
                );
                $stmt_update_detail->bind_param("sdisii", $masp, $tylekm, $soluong, $macode, $ghichu, $id);
                $stmt_update_detail->execute();
                echo "<div style='color: green;'>Cập nhật chi tiết khuyến mãi thành công!</div>";
                $stmt_update_detail->close();
            } else {
                $stmt_insert_detail = $conn->prepare(
                    "INSERT INTO chi_tiet_khuyen_mai (MaKM, MaSP, TyleKM, SoLuong, MaCode, GhiChu) VALUES (?, ?, ?, ?, ?, ?)"
                );
                $stmt_insert_detail->bind_param("isdisi", $id, $masp, $tylekm, $soluong, $macode, $ghichu);
                $stmt_insert_detail->execute();
                echo "<div style='color: green;'>Thêm mới chi tiết khuyến mãi thành công!</div>";
                $stmt_insert_detail->close();
            }
        } else {
            echo "<div style='color: red;'>Có lỗi xảy ra khi cập nhật: " . $stmt_update->error . "</div>";
        }
        $stmt_update->close();
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa thông tin khuyến mãi</h2>
        <div class="block">
            <form action="suakhuyenmai.php?id=<?php echo $id; ?>" method="post">
                <table>
                    <tr>
                        <td>Tên khuyến mãi:</td>
                        <td><input type="text" name="tenkm" value="<?php echo htmlspecialchars($data['TenKM'] ?? ''); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Từ ngày:</td>
                        <td><input type="date" name="tungay" value="<?php echo htmlspecialchars($data['TuNgay'] ?? ''); ?>" /></td>
                    </tr>
                    <tr>
                        <td>Đến ngày:</td>
                        <td><input type="date" name="denngay" value="<?php echo htmlspecialchars($data['DenNgay'] ?? ''); ?>" /></td>
                    </tr>
                    <tr>
                        <td>Tỷ lệ khuyến mãi:</td>
                        <td><input type="text" name="TyleKM" value="<?php echo htmlspecialchars($detail['TyleKM'] ?? ''); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Số lượng:</td>
                        <td><input type="number" name="SoLuong" value="<?php echo htmlspecialchars($detail['SoLuong'] ?? ''); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Mã Code:</td>
                        <td><input type="text" name="MaCode" value="<?php echo htmlspecialchars($detail['MaCode'] ?? ''); ?>" /></td>
                    </tr>
                    <tr>
                        <td>Ghi chú:</td>
                        <td><input type="text" name="GhiChu" value="<?php echo htmlspecialchars($detail['GhiChu'] ?? ''); ?>" /></td>
                    </tr>
                    <tr>
                        <td>Trạng thái:</td>
                        <td>
                            <select name="trangthai" required>
                                <option value="1" <?php echo ($data['TrangThai'] ?? 0) == 1 ? 'selected' : ''; ?>>Đang hoạt động</option>
                                <option value="0" <?php echo ($data['TrangThai'] ?? 0) == 0 ? 'selected' : ''; ?>>Ngừng hoạt động</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Cập nhật" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
