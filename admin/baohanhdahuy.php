<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
    include 'connect.php';

    // Truy vấn lấy yêu cầu bảo hành đã hủy (Trang thái = 2) và số điện thoại từ bảng tai_khoan
    $sql_baohanhdahuy = "SELECT bh.*, sp.TenSP, tk.SDT FROM bao_hanh bh 
                         JOIN san_pham sp ON bh.MaSP = sp.MaSP
                         JOIN tai_khoan tk ON bh.TenDangNhap = tk.TenDangNhap
                         WHERE bh.TrangThai = 2
                         ORDER BY bh.NgayYeuCau ASC";  // Ngày yêu cầu để theo dõi các yêu cầu đã hủy

    $result_baohanhdahuy = mysqli_query($conn, $sql_baohanhdahuy);
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Yêu cầu bảo hành đã hủy</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Ngày yêu cầu</th>
                        <th>Sản phẩm</th>
                        <th>Vấn đề</th>
                        <th>Số điện thoại</th>
                        <th>Ghi chú hủy</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $stt = 1;
                        while ($data = mysqli_fetch_array($result_baohanhdahuy)) {                                 
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $stt++; ?></td>
                        <td><?php echo $data['TenDangNhap']; ?></td>
                        <td><?php echo $data['NgayYeuCau']; ?></td>
                        <td><?php echo $data['TenSP']; ?></td>
                        <td><?php echo $data['LyDo']; ?></td>
                        <td><?php echo $data['SDT']; ?></td>
                        <td><?php echo $data['GhiChu']; ?></td>
                        <td>Đã hủy</td>
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
