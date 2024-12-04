<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    include 'connect.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tenNV = $_POST['TenNV'];
        $email = $_POST['Email'];
        $soDienThoai = $_POST['SoDienThoai'];
        $chucVu = $_POST['ChucVu'];
        $luongCoBan = $_POST['LuongCoBan'];
        $trangThai = $_POST['TrangThai'];
        $ghiChu = $_POST['GhiChu'];

        $sql_themnv = "INSERT INTO nhan_vien (TenNV, Email, SoDienThoai, ChucVu, LuongCoBan, TrangThai, GhiChu) 
                       VALUES ('$tenNV', '$email', '$soDienThoai', '$chucVu', '$luongCoBan', '$trangThai', '$ghiChu')";

        if (mysqli_query($conn, $sql_themnv)) {
            echo "<script>alert('Thêm nhân viên thành công');</script>";
        } else {
            echo "<script>alert('Lỗi khi thêm nhân viên');</script>";
        }
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm mới nhân viên</h2>
        <div class="block">
            <form action="" method="POST">
                <table class="form">
                    <tr>
                        <td>Tên nhân viên</td>
                        <td><input type="text" name="TenNV" placeholder="Nhập tên nhân viên" required /></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="email" name="Email" placeholder="Nhập email" required /></td>
                    </tr>
                    <tr>
                        <td>Số điện thoại</td>
                        <td><input type="text" name="SoDienThoai" placeholder="Nhập số điện thoại" required /></td>
                    </tr>
                    <tr>
                        <td>Chức vụ</td>
                        <td><input type="text" name="ChucVu" placeholder="Nhập chức vụ" required /></td>
                    </tr>
                    <tr>
                        <td>Lương cơ bản</td>
                        <td><input type="number" name="LuongCoBan" placeholder="Nhập lương cơ bản" required /></td>
                    </tr>
                    <tr>
                        <td>Trạng thái</td>
                        <td>
                            <select name="TrangThai" required>
                                <option value="1">Hoạt động</option>
                                <option value="0">Ngừng hoạt động</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Ghi chú</td>
                        <td><textarea name="GhiChu" placeholder="Nhập ghi chú"></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Thêm mới" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php';?>
