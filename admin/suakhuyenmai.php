<?php
    include 'inc/header.php';
    include 'inc/sidebar.php';
    include 'connect.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_chinhsua = "SELECT * FROM khuyen_mai WHERE MaKM = $id";
        $result_chinhsua = mysqli_query($conn, $sql_chinhsua);
        $data = mysqli_fetch_array($result_chinhsua);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tenkm = $_POST['tenkm'];
        $tungay = $_POST['tungay'];
        $denngay = $_POST['denngay'];
        $trangthai = $_POST['trangthai'];

        $sql_capnhat = "UPDATE khuyen_mai 
                        SET TenKM = '$tenkm', 
                            TuNgay = '$tungay', 
                            DenNgay = '$denngay', 
                            TrangThai = $trangthai 
                        WHERE MaKM = $id";
        
        $result_capnhat = mysqli_query($conn, $sql_capnhat);

        if ($result_capnhat) {
            echo "Cập nhật thành công!";
        } else {
            echo "Có lỗi xảy ra khi cập nhật!";
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
                        <td><input type="text" name="tenkm" value="<?php echo $data['TenKM']; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Từ ngày:</td>
                        <td><input type="date" name="tungay" value="<?php echo $data['TuNgay']; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Đến ngày:</td>
                        <td><input type="date" name="denngay" value="<?php echo $data['DenNgay']; ?>" required /></td>
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

<?php include 'inc/footer.php';?>
