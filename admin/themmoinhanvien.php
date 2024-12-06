<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoTen = $_POST['HoTen'];
    $ngaySinh = $_POST['NgaySinh'];
    $diaChi = $_POST['DiaChi'];
    $ngayVaoLam = $_POST['NgayVaoLam'];
    $luongCB = $_POST['LuongCB'];
    $vaiTro = $_POST['VaiTro'];
    $sdt = $_POST['SDT'];
    $email = $_POST['Email'];
    $trangThai = $_POST['TrangThai'];
    $ghiChu = $_POST['GhiChu'];

    $sql_themnv = "INSERT INTO nhan_vien (HoTen, NgaySinh, DiaChi, NgayVaoLam, LuongCB, VaiTro, SDT, Email, TrangThai, GhiChu) 
                   VALUES ('$hoTen', '$ngaySinh', '$diaChi', '$ngayVaoLam', '$luongCB', '$vaiTro', '$sdt', '$email', '$trangThai', '$ghiChu')";

    if (mysqli_query($conn, $sql_themnv)) {
        echo "<script>alert('Thêm nhân viên thành công');</script>";
    } else {
        echo "<script>alert('Lỗi khi thêm nhân viên: " . mysqli_error($conn) . "');</script>";
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
                        <td>Họ tên</td>
                        <td><input type="text" name="HoTen" placeholder="Nhập họ tên" required /></td>
                    </tr>
                    <tr>
                        <td>Ngày sinh</td>
                        <td><input type="date" name="NgaySinh" required /></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ</td>
                        <td><input type="text" name="DiaChi" placeholder="Nhập địa chỉ" required /></td>
                    </tr>
                    <tr>
                        <td>Ngày vào làm</td>
                        <td><input type="date" name="NgayVaoLam" required /></td>
                    </tr>
                    <tr>
                        <td>Lương cơ bản</td>
                        <td><input type="number" name="LuongCB" placeholder="Nhập lương cơ bản" required /></td>
                    </tr>
                    <tr>
                        <td>Vai trò</td>
                        <td><input type="text" name="VaiTro" placeholder="Nhập vai trò" required /></td>
                    </tr>
                    <tr>
                        <td>Số điện thoại</td>
                        <td><input type="text" name="SDT" placeholder="Nhập số điện thoại" required /></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="email" name="Email" placeholder="Nhập email" required /></td>
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
<?php include 'inc/footer.php'; ?>
