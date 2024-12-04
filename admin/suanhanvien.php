<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    include 'connect.php';
    $id = $_GET['id'];
    $sql_laynv = "SELECT * FROM nhan_vien WHERE MaNV = $id";
    $result = mysqli_query($conn, $sql_laynv);
    $nhanVien = mysqli_fetch_array($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tenNV = $_POST['TenNV'];
        $email = $_POST['Email'];
        $soDienThoai = $_POST['SoDienThoai'];
        $chucVu = $_POST['ChucVu'];
        $luongCoBan = $_POST['LuongCoBan'];
        $trangThai = $_POST['TrangThai'];
        $ghiChu = $_POST['GhiChu'];

        $sql_suanv = "UPDATE nhan_vien SET 
                      TenNV = '$tenNV', Email = '$email', SoDienThoai = '$soDienThoai', 
                      ChucVu = '$chucVu', LuongCoBan = '$luongCoBan', TrangThai = '$trangThai', 
                      GhiChu = '$ghiChu' WHERE MaNV = $id";

        if (mysqli_query($conn, $sql_suanv)) {
            echo "<script>alert('Sửa thông tin thành công'); window.location='xemnhanvien.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi sửa thông tin');</script>";
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
                        <td>Tên nhân viên</td>
                        <td><input type="text" name="TenNV" value="<?php echo $nhanVien['TenNV']; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="email" name="Email" value="<?php echo $nhanVien['Email']; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Số điện thoại</td>
                        <td><input type="text" name="SoDienThoai" value="<?php echo $nhanVien['SoDienThoai']; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Chức vụ</td>
                        <td><input type="text" name="ChucVu" value="<?php echo $nhanVien['ChucVu']; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Lương cơ bản</td>
                        <td><input type="number" name="LuongCoBan" value="<?php echo $nhanVien['LuongCoBan']; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Trạng thái</td>
                        <td>
                            <select name="TrangThai" required>
                                <option value="1" <?php if ($nhanVien['TrangThai'] == 1) echo 'selected'; ?>>Hoạt động</option>
                                <option value="0" <?php if ($nhanVien['TrangThai'] == 0) echo 'selected'; ?>>Ngừng hoạt động</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Ghi chú</td>
                        <td><textarea name="GhiChu"><?php echo $nhanVien['GhiChu']; ?></textarea></td>
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
<?php include 'inc/footer.php';?>
