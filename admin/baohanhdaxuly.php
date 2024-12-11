<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
    include 'connect.php';

    $sql_baohanhdaxuly = "SELECT bh.*, sp.TenSP FROM bao_hanh bh 
                          JOIN san_pham sp ON bh.MaSP = sp.MaSP
                          WHERE bh.TrangThai = 2
                          ORDER BY bh.NgayHen ASC";  // Ngày hẹn để theo dõi quá trình xử lý

    $result_baohanhdaxuly = mysqli_query($conn, $sql_baohanhdaxuly);
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Yêu cầu bảo hành đã xử lý</h2>
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
                        while ($data = mysqli_fetch_array($result_baohanhdaxuly)) {                                  
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $stt++; ?></td>
                        <td><?php echo $data['TenDangNhap']; ?></td>
                        <td><?php echo $data['NgayYeuCau']; ?></td>
                        <td><?php echo $data['NgayHen']; ?></td>
                        <td><?php echo $data['TenSP']; ?></td>
                        <td><?php echo $data['LyDo']; ?></td>
                        <td>Đã xử lý</td>
                        <td>
                            <!-- Nếu đã xử lý, có thể chỉ xem chi tiết hoặc không thao tác thêm -->
                            <a href="xemchitiet.php?id=<?php echo $data['MaBH']; ?>">Xem chi tiết</a>
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
