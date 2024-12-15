<?php
    include 'inc/header.php';
    include 'inc/sidebar.php';
    include 'connect.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_xoa = "DELETE FROM khuyen_mai WHERE MaKM = $id";
        $result_xoa = mysqli_query($conn, $sql_xoa);

        if ($result_xoa) {
            echo "Xóa thành công!";
        } else {
            echo "Có lỗi xảy ra khi xóa!";
        }
    }
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Xóa khuyến mãi</h2>
        <div class="block">               
            <p><a href="xemkhuyenmai.php">Trở về danh sách khuyến mãi</a></p>
        </div>
    </div>
</div>

<?php include 'inc/footer.php';?>
