<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
    include 'connect.php';
    $sql_baohanhhoanthanh = "SELECT * FROM bao_hanh WHERE TrangThai = 1 ORDER BY NgayBH ASC";
    $result_hoanthanh = mysqli_query($conn, $sql_baohanhhoanthanh);
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Yêu cầu bảo hành đã hoàn thành</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Ngày yêu cầu</th>
                        <th>Ngày hoàn thành</th>
                        <th>Sản phẩm</th>
                        <th>Vấn đề</th>
                        <th>Số điện thoại</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $stt = 1;
                        while ($data = mysqli_fetch_array($result_hoanthanh)) {                                    
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $stt++; ?></td>
                        <td><?php echo $data['HoTenKH']; ?></td>
                        <td><?php echo $data['NgayYeuCau']; ?></td>
                        <td><?php echo $data['NgayHoanThanh']; ?></td>
                        <td><?php echo $data['SanPham']; ?></td>
                        <td><?php echo $data['VanDe']; ?></td>
                        <td><?php echo $data['SDT']; ?></td>
                        <td>Đã hoàn thành</td>
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
