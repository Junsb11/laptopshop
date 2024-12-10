<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
    include 'connect.php';

    // Truy vấn lấy yêu cầu bảo hành đang xử lý (Trang thái = 1)
    $sql_baohanhdangxuly = "SELECT bh.*, sp.TenSP FROM bao_hanh bh 
                            JOIN san_pham sp ON bh.MaSP = sp.MaSP
                            WHERE bh.TrangThai = 1
                            ORDER BY bh.NgayHen ASC";  // Ngày hẹn để dễ dàng theo dõi

    $result_baohanhdangxuly = mysqli_query($conn, $sql_baohanhdangxuly);
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Yêu cầu bảo hành đang xử lý</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Ngày yêu cầu</th>
                        <th>Ngày hẹn</th>
                        <th>Sản phẩm</th>
                        <th>Vấn đề</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $stt = 1;
                        while ($data = mysqli_fetch_array($result_baohanhdangxuly)) {                                  
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $stt++; ?></td>
                        <td><?php echo $data['TenDangNhap']; ?></td>
                        <td><?php echo $data['NgayYeuCau']; ?></td>
                        <td><?php echo $data['NgayHen']; ?></td>
                        <td><?php echo $data['TenSP']; ?></td>
                        <td><?php echo $data['LyDo']; ?></td>
                        <td>Đang xử lý</td>
                        <td>
                            <a href="daxuly.php?id=<?php echo $data['MaBH']; ?>">Đã xử lý</a> || 
                            <a href="chuaxuly.php?id=<?php echo $data['MaBH']; ?>">Về lại chưa xử lý</a> || 
                            <a href="huybaohanh.php?id=<?php echo $data['MaBH']; ?>" onclick="return confirm('Bạn có muốn hủy đơn bảo hành này không?')">Hủy</a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
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
