<?php
    include 'inc/header.php';
    include 'inc/sidebar.php';
    include 'connect.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tenkm = $_POST['tenkm'];
        $tungay = $_POST['tungay'];
        $denngay = $_POST['denngay'];
        $trangthai = $_POST['trangthai'];

        $sql_themkm = "INSERT INTO khuyen_mai (TenKM, TuNgay, DenNgay, TrangThai) 
                       VALUES ('$tenkm', '$tungay', '$denngay', $trangthai)";
        
        $result_themkm = mysqli_query($conn, $sql_themkm);

        if ($result_themkm) {
            $makm = mysqli_insert_id($conn);

            // Insert into CT_khuyen_mai if needed
            if (!empty($_POST['masp']) && !empty($_POST['tylekm']) && !empty($_POST['soluong'])) {
                $masp = $_POST['masp'];
                $tylekm = $_POST['tylekm'];
                $ghichu = $_POST['ghichu'];
                $soluong = $_POST['soluong'];

                $sql_ctkm = "INSERT INTO CT_khuyen_mai (MaKM, MaSP, TyLeKM, GhiChu, SoLuong) 
                             VALUES ('$makm', '$masp', '$tylekm', '$ghichu', '$soluong')";
                mysqli_query($conn, $sql_ctkm);
            }
            echo "<p style='color: green;'>Thêm mới thành công!</p>";
        } else {
            echo "<p style='color: red;'>Có lỗi xảy ra khi thêm dữ liệu!</p>";
        }
    }
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm mới khuyến mãi</h2>
        <div class="block">               
            <form action="themmmoikhuyenmai.php" method="post">
                <table class="form">
                    <tr>
                        <td><label for="tenkm">Tên khuyến mãi:</label></td>
                        <td><input type="text" name="tenkm" id="tenkm" required /></td>
                    </tr>
                    <tr>
                        <td><label for="tungay">Từ ngày:</label></td>
                        <td><input type="date" name="tungay" id="tungay" required /></td>
                    </tr>
                    <tr>
                        <td><label for="denngay">Đến ngày:</label></td>
                        <td><input type="date" name="denngay" id="denngay" required /></td>
                    </tr>
                    <tr>
                        <td><label for="trangthai">Trạng thái:</label></td>
                        <td>
                            <select name="trangthai" id="trangthai" required>
                                <option value="1">Đang hoạt động</option>
                                <option value="0">Ngừng hoạt động</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="masp">Mã sản phẩm:</label></td>
                        <td><input type="text" name="masp" id="masp" /></td>
                    </tr>
                    <tr>
                        <td><label for="tylekm">Tỷ lệ khuyến mãi:</label></td>
                        <td><input type="text" name="tylekm" id="tylekm" /></td>
                    </tr>
                    <tr>
                        <td><label for="ghichu">Ghi chú:</label></td>
                        <td><input type="text" name="ghichu" id="ghichu" /></td>
                    </tr>
                    <tr>
                        <td><label for="soluong">Số lượng:</label></td>
                        <td><input type="number" name="soluong" id="soluong" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Thêm mới" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<style>
    .form {
        width: 100%;
        border-collapse: collapse;
    }
    .form td {
        padding: 10px;
        vertical-align: top;
    }
    .form label {
        display: block;
        margin-bottom: 5px;
    }
    .form input, .form select {
        width: 100%;
        padding: 5px;
    }
    .box {
        background-color: #f9f9f9;
        padding: 20px;
    }
    .grid_10 {
        width: 100%;
    }
    .block {
        margin-top: 20px;
    }
</style>

<?php include 'inc/footer.php';?>
