<?php include 'inc/header.php'; 
include 'inc/sidebar.php'; ?>

<?php
    include 'connect.php';
    $sql_xembh = "SELECT baohanh.*, san_pham.TenSP FROM baohanh 
                  INNER JOIN san_pham ON baohanh.MaSP = san_pham.MaSP";
    $result_bh = mysqli_query($conn, $sql_xembh);
?>

<div class="grid_10">
    <div class="box round first grid">
        <form action="xembaohanh.php" method="get">
            <h2>Danh sách bảo hành</h2>
            <div class="block">        
                <table class="data display datatable" id="example">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã bảo hành</th>
                            <th>Tên sản phẩm</th>
                            <th>Tên khách hàng</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Trạng thái</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stt = 1;
                        while ($data = mysqli_fetch_array($result_bh)) {									
                        ?>
                        <tr class="odd gradeX">
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo $data['MaBH']; ?></td>
                            <td><?php echo $data['TenSP']; ?></td>
                            <td><?php echo $data['TenKhachHang']; ?></td>
                            <td><?php echo $data['NgayBatDau']; ?></td>
                            <td><?php echo $data['NgayKetThuc']; ?></td>
                            <td><?php echo ($data['TrangThai'] == 1) ? 'Đang hiệu lực' : 'Hết hiệu lực'; ?></td>
                            <td><a href="xoabaohanh.php?id=<?php echo $data['MaBH']; ?>" onclick="return confirm('Bạn có muốn xóa thông tin bảo hành này không?')">Delete</a></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php'; ?>
