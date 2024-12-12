<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
    include 'connect.php';

    // Cập nhật câu truy vấn SQL để lấy thêm trường NgàyHen
    $sql_xembaohanh = "SELECT bh.*, sp.TenSP, bh.NgayHen FROM bao_hanh bh 
                       JOIN san_pham sp ON bh.MaSP = sp.MaSP
                       WHERE bh.TrangThai = 0 
                       ORDER BY bh.NgayYeuCau ASC";

    $result_baohanh = mysqli_query($conn, $sql_xembaohanh);
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Yêu cầu bảo hành chờ xử lý</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Ngày yêu cầu</th>
                        <th>Ngày Hẹn</th> <!-- Cột "Ngày Hẹn" -->
                        <th>Sản phẩm</th>
                        <th>Vấn đề</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $stt = 1;
                        while ($data = mysqli_fetch_array($result_baohanh)) {                                      

                            // Hiển thị trạng thái phù hợp
                            $trangthai = $data['TrangThai'] == 0 ? 'Chờ xử lý' : 'Đã xử lý';
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $stt++; ?></td>
                        <td><?php echo $data['TenDangNhap']; ?></td>
                        <td><?php echo $data['NgayYeuCau']; ?></td>
                        <td><?php echo $data['NgayHen'] ? $data['NgayHen'] : 'Chưa có'; ?></td> <!-- Hiển thị Ngày Hẹn -->
                        <td><?php echo $data['TenSP']; ?></td> <!-- Hiển thị tên sản phẩm -->
                        <td><?php echo $data['LyDo']; ?></td>
                        <td><?php echo $trangthai; ?></td> <!-- Hiển thị trạng thái -->
                        <td>
                            <a href="xulybaohanh.php?id=<?php echo $data['MaBH']; ?>">Xử lý</a> || 
                            <a href="huybaohanh.php?id=<?php echo $data['MaBH']; ?>">Hủy yêu cầu</a>
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
