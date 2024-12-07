<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    include 'connect.php';

    // Truy vấn đơn hàng đang giao
    $sql_danggiao = "SELECT * FROM hoa_don WHERE TrangThai = 1 ORDER BY NgayHD ASC";
    $result_danggiao = mysqli_query($conn, $sql_danggiao);

    // Truy vấn đơn hàng đã giao (khách đã xác nhận)
    $sql_dagiao = "SELECT * FROM hoa_don WHERE TrangThai = 2 ORDER BY NgayHD ASC";
    $result_dagiao = mysqli_query($conn, $sql_dagiao);
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Đơn hàng đang giao</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Ngày lập</th>
                        <th>Ghi chú</th>
                        <th>Địa chỉ</th>
                        <th>SĐT</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $stt = 1;
                    while ($data = mysqli_fetch_array($result_danggiao)) { ?>
                        <tr class="odd gradeX">
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo $data['HoTenNN']; ?></td>
                            <td><?php echo $data['NgayHD']; ?></td>
                            <td><?php echo $data['GhiChu']; ?></td>
                            <td><?php echo $data['DiaChi']; ?></td>
                            <td><?php echo $data['SDT']; ?></td>
                            <td>Đang giao</td>
                            <td>
                                <a href="dathanhtoan.php?id=<?php echo $data['MaHD']; ?>">Đã thanh toán</a> || 
                                <a href="velaidonmoi.php?id=<?php echo $data['MaHD']; ?>">Về lại đơn mới</a> || 
                                <a href="huydon.php?id=<?php echo $data['MaHD']; ?>" onclick="return confirm('Bạn có muốn hủy hóa đơn này không?')">Hủy</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Danh sách đơn hàng đã giao -->
    <div class="box round second grid">
        <h2>Thông báo: Khách hàng đã xác nhận nhận đơn hàng</h2>
        <div class="block">
            <table class="data display datatable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Ngày lập</th>
                        <th>Ghi chú</th>
                        <th>Địa chỉ</th>
                        <th>SĐT</th>
                        <th>Trạng thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $stt = 1;
                    while ($data = mysqli_fetch_array($result_dagiao)) { ?>
                        <tr class="odd gradeX">
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo $data['HoTenNN']; ?></td>
                            <td><?php echo $data['NgayHD']; ?></td>
                            <td><?php echo $data['GhiChu']; ?></td>
                            <td><?php echo $data['DiaChi']; ?></td>
                            <td><?php echo $data['SDT']; ?></td>
                            <td>Đã giao</td>
                            <td><a href="dathanhtoan.php?id=<?php echo $data['MaHD']; ?>">Đã thanh toán</a></td>
                        </tr>
                    <?php } ?>
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
<?php include 'inc/footer.php';?>
