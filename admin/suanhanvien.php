<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
    include 'connect.php';

    // Retrieve employee ID from GET parameter
    $id = $_GET['id'];

    // Fetch employee details
    $sql_laynv = "SELECT * FROM nhan_vien WHERE MaNV = '$id'";
    $result = mysqli_query($conn, $sql_laynv);
    
    if (!$result) {
        die("Error fetching employee details: " . mysqli_error($conn));
    }

    $nhanVien = mysqli_fetch_array($result);

    // If form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Use isset() to check if the POST values are set
        $hoTen = isset($_POST['HoTen']) ? mysqli_real_escape_string($conn, $_POST['HoTen']) : '';
        $email = isset($_POST['Email']) ? mysqli_real_escape_string($conn, $_POST['Email']) : '';
        $soDienThoai = isset($_POST['SDT']) ? mysqli_real_escape_string($conn, $_POST['SDT']) : '';
        $vaiTro = isset($_POST['VaiTro']) ? mysqli_real_escape_string($conn, $_POST['VaiTro']) : '';
        $luongCB = isset($_POST['LuongCB']) ? mysqli_real_escape_string($conn, $_POST['LuongCB']) : '';
        $trangThai = isset($_POST['TrangThai']) ? $_POST['TrangThai'] : '';
        $ghiChu = isset($_POST['GhiChu']) ? mysqli_real_escape_string($conn, $_POST['GhiChu']) : '';

        // Check if the necessary fields are provided
        if (empty($hoTen) || empty($email) || empty($soDienThoai) || empty($vaiTro) || empty($luongCB) || empty($trangThai)) {
            echo "<script>alert('Vui lòng điền đầy đủ thông tin');</script>";
        } else {
            // Update employee details in the database
            $sql_suanv = "UPDATE nhan_vien SET 
                          HoTen = '$hoTen', 
                          Email = '$email', 
                          SDT = '$soDienThoai', 
                          VaiTro = '$vaiTro', 
                          LuongCB = '$luongCB', 
                          TrangThai = '$trangThai', 
                          GhiChu = '$ghiChu' 
                          WHERE MaNV = '$id'";

            // Execute the query
            if (mysqli_query($conn, $sql_suanv)) {
                echo "<script>alert('Sửa thông tin nhân viên thành công'); window.location='xemnhanvien.php';</script>";
            } else {
                echo "<script>alert('Lỗi khi sửa thông tin nhân viên: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa thông tin nhân viên</h2>
        <div class="block">
            <form action="" method="POST">
                <table class="form">
                    <tr>
                        <td>Họ tên</td>
                        <td><input type="text" name="HoTen" value="<?php echo isset($nhanVien['HoTen']) ? htmlspecialchars($nhanVien['HoTen']) : ''; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="email" name="Email" value="<?php echo isset($nhanVien['Email']) ? htmlspecialchars($nhanVien['Email']) : ''; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Số điện thoại</td>
                        <td><input type="text" name="SDT" value="<?php echo isset($nhanVien['SDT']) ? htmlspecialchars($nhanVien['SDT']) : ''; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Vai trò</td>
                        <td><input type="text" name="VaiTro" value="<?php echo isset($nhanVien['VaiTro']) ? htmlspecialchars($nhanVien['VaiTro']) : ''; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Lương cơ bản</td>
                        <td><input type="number" name="LuongCB" value="<?php echo isset($nhanVien['LuongCB']) ? htmlspecialchars($nhanVien['LuongCB']) : ''; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Trạng thái</td>
                        <td>
                            <select name="TrangThai" required>
                                <option value="Đang làm" <?php echo isset($nhanVien['TrangThai']) && $nhanVien['TrangThai'] == 'Đang làm' ? 'selected' : ''; ?>>Đang làm</option>
                                <option value="Đã nghỉ" <?php echo isset($nhanVien['TrangThai']) && $nhanVien['TrangThai'] == 'Đã nghỉ' ? 'selected' : ''; ?>>Đã nghỉ</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Ghi chú</td>
                        <td><textarea name="GhiChu"><?php echo isset($nhanVien['GhiChu']) ? htmlspecialchars($nhanVien['GhiChu']) : ''; ?></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Cập nhật" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>
