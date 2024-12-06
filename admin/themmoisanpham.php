<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm sản phẩm mới</h2>
        <?php
        include 'connect.php';
        $sql_xemdm = "SELECT * FROM danh_muc";
        $result_dm = mysqli_query($conn, $sql_xemdm);
        ?>
        <div class="block">
            <form action="themmoisanpham.php" method="POST" enctype="multipart/form-data">
                <table class="form">
                    <tr>
                        <td>
                            <label>Tên sản phẩm</label>
                        </td>
                        <td>
                            <input type="text" name="txttensp" placeholder="Tên Sản Phẩm..." class="medium" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Đơn giá</label>
                        </td>
                        <td>
                            <input type="text" name="txtdongia" placeholder="Đơn Giá..." class="medium" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Hình Ảnh</label>
                        </td>
                        <td>
                            <input type="file" name="hinhanh" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Danh mục</label>
                        </td>
                        <td>
                            <select id="select" name="madm" required>
                                <option value="">Chọn Danh Mục</option>
                                <?php
                                while ($data = mysqli_fetch_array($result_dm)) {
                                ?>
                                    <option value='<?php echo $data['MaDM'];?>'><?php echo $data['TenDM']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Trạng thái</label>
                        </td>
                        <td>
                            <input type="radio" id="mo" name="trangthai" value="1" checked="1">
                            <label for="mo">Mở</label>
                            <input type="radio" id="khoa" name="trangthai" value="0">
                            <label for="khoa">Khóa</label>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Mô tả</label>
                        </td>
                        <td>
                            <textarea name="txtmota" class="tinymce" required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" value="Lưu" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $tensp = $_POST['txttensp'];
    $dongia = $_POST['txtdongia'];
    $trangthai = $_POST['trangthai'];
    $mota = $_POST['txtmota'];
    $madm = $_POST['madm'];
    $file = $_FILES['hinhanh']['tmp_name'];
    $filename = $_FILES['hinhanh']['name'];
    $path = "upload/" . $filename;

    // Kiểm tra lỗi tải file
    if ($_FILES['hinhanh']['error'] !== UPLOAD_ERR_OK) {
        echo "Lỗi tải lên file: " . $_FILES['hinhanh']['error'];
        exit();
    }

    // Kiểm tra kiểu file ảnh
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['hinhanh']['type'], $allowedTypes)) {
        echo "Kiểu file không hợp lệ! Chỉ cho phép các định dạng jpg, png, gif.";
        exit();
    }

    // Di chuyển file ảnh
    if (!move_uploaded_file($file, $path)) {
        echo "Tải ảnh thất bại!";
        exit();
    }

    // Kiểm tra dữ liệu nhập vào
    if (empty($tensp) || empty($dongia) || empty($mota) || empty($madm) || empty($file)) {
        echo "Vui lòng điền đầy đủ thông tin!";
        exit();
    }

    // Sử dụng Prepared Statement để bảo mật
    $stmt = $conn->prepare("INSERT INTO san_pham (TenSP, DonGia, HinhAnh, MaDM, TrangThai, MoTa) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $tensp, $dongia, $path, $madm, $trangthai, $mota);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script> window.location.href='xemsanpham.php'; </script>";
    } else {
        echo "Thêm sản phẩm không thành công!";
    }
}
?>

<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>

<?php include 'inc/footer.php';?>
