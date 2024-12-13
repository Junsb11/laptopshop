<?php include 'inc/header.php';
include 'inc/sidebar.php'; ?>

<?php
    include 'connect.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tendangnhap = mysqli_real_escape_string($conn, $_POST['TenDangNhap']);
        $matkhau = mysqli_real_escape_string($conn, $_POST['MatKhau']);
        $hoten = mysqli_real_escape_string($conn, $_POST['HoTen']);
        $gioitinh = mysqli_real_escape_string($conn, $_POST['GioiTinh']);
        $sdt = mysqli_real_escape_string($conn, $_POST['SDT']);
        $email = mysqli_real_escape_string($conn, $_POST['Email']);
        $diachi = mysqli_real_escape_string($conn, $_POST['DiaChi']);
        $maloai = mysqli_real_escape_string($conn, $_POST['MaLoai']);
        $trangthai = isset($_POST['TrangThai']) ? 1 : 0;

        $sql_them = "INSERT INTO tai_khoan (TenDangNhap, MatKhau, HoTen, GioiTinh, SDT, Email, DiaChi, MaLoai, TrangThai) 
                     VALUES ('$tendangnhap', '$matkhau', '$hoten', '$gioitinh', '$sdt', '$email', '$diachi', '$maloai', '$trangthai')";

        if (mysqli_query($conn, $sql_them)) {
            echo "<script>alert('Thêm tài khoản thành công!');</script>";
        } else {
            echo "<script>alert('Thêm tài khoản thất bại: " . mysqli_error($conn) . "');</script>";
        }
    }

    $sql_loai = "SELECT * FROM loai_tk";
    $result_loai = mysqli_query($conn, $sql_loai);
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm Tài Khoản</h2>
        <div class="block">               
         <form action="themtaikhoan.php" method="post">
            <table class="form">
                <tr>
                    <td><label>Tên Đăng Nhập</label></td>
                    <td><input type="text" name="TenDangNhap" placeholder="Nhập tên đăng nhập..." required /></td>
                </tr>
                <tr>
                    <td><label>Mật Khẩu</label></td>
                    <td><input type="password" name="MatKhau" placeholder="Nhập mật khẩu..." required /></td>
                </tr>
                <tr>
                    <td><label>Họ Tên</label></td>
                    <td><input type="text" name="HoTen" placeholder="Nhập họ tên..." required /></td>
                </tr>
                <tr>
                    <td><label>Giới Tính</label></td>
                    <td>
                        <select name="GioiTinh">
                            <option value="1">Nam</option>
                            <option value="0">Nữ</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Số Điện Thoại</label></td>
                    <td><input type="text" name="SDT" placeholder="Nhập số điện thoại..." required /></td>
                </tr>
                <tr>
                    <td><label>Email</label></td>
                    <td><input type="email" name="Email" placeholder="Nhập email..." required /></td>
                </tr>
                <tr>
                    <td><label>Địa Chỉ</label></td>
                    <td><input type="text" name="DiaChi" placeholder="Nhập địa chỉ..." required /></td>
                </tr>
                <tr>
                    <td><label>Loại Tài Khoản</label></td>
                    <td>
                        <select name="MaLoai">
                            <?php while ($loai = mysqli_fetch_array($result_loai)) { ?>
                                <option value="<?php echo $loai['MaLoai']; ?>">
                                    <?php echo $loai['TenLoai']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Trạng Thái</label></td>
                    <td><input type="checkbox" name="TrangThai" value="1" /> Mở</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="form-group  ">
                        <button type="submit" name="submit" class="btn btn-primary" style="background-color: #007BFF; color: white; padding: 10px 20px; border: none; cursor: pointer;">Thêm Tài Khoản</button>
                </div>
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
