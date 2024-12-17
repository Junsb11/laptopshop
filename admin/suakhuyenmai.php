<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include 'connect.php';

if (!$conn) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM khuyen_mai WHERE MaKM = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result_chinhsua = $stmt->get_result();

    if ($result_chinhsua->num_rows > 0) {
        $data = $result_chinhsua->fetch_assoc();
    } else {
        die("Không tìm thấy khuyến mãi với ID: $id");
    }
    $stmt->close();
} else {
    die("ID không hợp lệ hoặc không được cung cấp.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenkm = isset($_POST['tenkm']) ? trim($_POST['tenkm']) : '';
    $tungay = isset($_POST['tungay']) && !empty($_POST['tungay']) ? $_POST['tungay'] : $data['TuNgay'];
    $denngay = isset($_POST['denngay']) && !empty($_POST['denngay']) ? $_POST['denngay'] : $data['DenNgay'];
    $trangthai = isset($_POST['trangthai']) ? intval($_POST['trangthai']) : 0;

    $masp = isset($_POST['MaSP']) ? trim($_POST['MaSP']) : '';
    $tylekm = isset($_POST['TyleKM']) ? floatval($_POST['TyleKM']) : 0;
    $soluong = isset($_POST['SoLuong']) ? intval($_POST['SoLuong']) : 0;
    $macode = isset($_POST['MaCode']) ? trim($_POST['MaCode']) : '';
    $ghichu = isset($_POST['GhiChu']) ? trim($_POST['GhiChu']) : '';

    if ($tenkm === '') {
        echo "Tên khuyến mãi không được để trống.";
    } elseif ($macode !== '') {
        $stmt_check_code = $conn->prepare("SELECT MaCode FROM chi_tiet_khuyen_mai WHERE MaCode = ?");
        $stmt_check_code->bind_param("s", $macode);
        $stmt_check_code->execute();
        $result_code = $stmt_check_code->get_result();

        if ($result_code->num_rows > 0) {
            echo "<div style='color: red;'>Mã Code đã tồn tại. Vui lòng nhập mã khác.</div>";
        } else {
            $stmt_check_code->close();

            $stmt_update = $conn->prepare("UPDATE khuyen_mai SET TenKM = ?, TuNgay = ?, DenNgay = ?, TrangThai = ? WHERE MaKM = ?");
            $stmt_update->bind_param("sssii", $tenkm, $tungay, $denngay, $trangthai, $id);

            if ($stmt_update->execute()) {
                echo "<div style='color: green;'>Cập nhật thông tin khuyến mãi thành công!</div>";

                $stmt_check = $conn->prepare("SELECT * FROM chi_tiet_khuyen_mai WHERE MaKM = ?");
                $stmt_check->bind_param("i", $id);
                $stmt_check->execute();
                $result_check = $stmt_check->get_result();

                if ($result_check->num_rows > 0) {
                    $stmt_update_detail = $conn->prepare(
                        "UPDATE chi_tiet_khuyen_mai SET MaSP = ?, TyleKM = ?, SoLuong = ?, MaCode = ?, GhiChu = ? WHERE MaKM = ?"
                    );
                    $stmt_update_detail->bind_param("sdisii", $masp, $tylekm, $soluong, $macode, $ghichu, $id);
                    $stmt_update_detail->execute();
                    $stmt_update_detail->close();
                    echo "<div style='color: green;'>Cập nhật chi tiết khuyến mãi thành công!</div>";
                } else {
                    $stmt_insert_detail = $conn->prepare(
                        "INSERT INTO chi_tiet_khuyen_mai (MaKM, MaSP, TyleKM, SoLuong, MaCode, GhiChu) VALUES (?, ?, ?, ?, ?, ?)"
                    );
                    $stmt_insert_detail->bind_param("isdisi", $id, $masp, $tylekm, $soluong, $macode, $ghichu);
                    $stmt_insert_detail->execute();
                    $stmt_insert_detail->close();
                    echo "<div style='color: green;'>Thêm mới chi tiết khuyến mãi thành công!</div>";
                }
                $stmt_check->close();
            } else {
                echo "<div style='color: red;'>Có lỗi xảy ra khi cập nhật: " . $stmt_update->error . "</div>";
            }
            $stmt_update->close();
        }
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
                        <td><input type="text" name="tenkm" value="<?php echo htmlspecialchars($data['TenKM']); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Từ ngày:</td>
                        <td><input type="date" name="tungay" value="<?php echo htmlspecialchars($data['TuNgay']); ?>" /></td>
                    </tr>
                    <tr>
                        <td>Đến ngày:</td>
                        <td><input type="date" name="denngay" value="<?php echo htmlspecialchars($data['DenNgay']); ?>" /></td>
                    </tr>
                    <tr>
                        <td>Mã Sản Phẩm:</td>
                        <td><input type="text" name="MaSP" value="<?php echo htmlspecialchars($data['MaSP']); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Tỷ lệ khuyến mãi:</td>
                        <td><input type="text" name="TyleKM" value="<?php echo htmlspecialchars($data['TyleKM']); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Số lượng:</td>
                        <td><input type="number" name="SoLuong" value="<?php echo htmlspecialchars($data['SoLuong']); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Mã Code:</td>
                        <td><input type="text" name="MaCode" value="<?php echo htmlspecialchars($data['MaCode']); ?>" /></td>
                    </tr>
                    <tr>
                        <td>Ghi chú:</td>
                        <td><input type="text" name="GhiChu" value="<?php echo htmlspecialchars($data['GhiChu']); ?>" /></td>
                    </tr>
                    <tr>
                        <td>Trạng thái:</td>
                        <td>
                            <select name="trangthai" required>
                                <option value="1" <?php if ($data['TrangThai'] == 1) echo 'selected'; ?>>Đang hoạt động</option>
                                <option value="0" <?php if ($data['TrangThai'] == 0) echo 'selected'; ?>>Ngừng hoạt động</option>
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
