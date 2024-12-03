<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
    include 'connect.php';
    $sql_xemsp = "SELECT * FROM hoa_don WHERE TrangThai=0 ORDER BY NgayHD ASC";
    $result_sp = mysqli_query($conn, $sql_xemsp);
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Đơn hàng chờ xét duyệt</h2>
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
                    while ($data = mysqli_fetch_array($result_sp)) { 
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $stt++; ?></td>
                        <td><?php echo $data['HoTenNN']; ?></td>
                        <td><?php echo $data['NgayHD']; ?></td>
                        <td><?php echo $data['GhiChu']; ?></td>
                        <td><?php echo $data['DiaChi']; ?></td>
                        <td><?php echo $data['SDT']; ?></td>
                        <td>Chờ xét duyệt</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openModal(<?php echo $data['MaHD']; ?>)">Duyệt đơn</button> || 
                            <button class="btn btn-danger btn-sm" onclick="openModal(<?php echo $data['MaHD']; ?>)">Hủy đơn</button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Chi tiết đơn hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <input type="hidden" name="MaHD" id="MaHD">
                    <div class="form-group">
                        <label for="customerName">Khách hàng:</label>
                        <input type="text" class="form-control" id="HoTenNN" disabled />
                    </div>
                    <div class="form-group">
                        <label for="orderDate">Ngày lập đơn:</label>
                        <input type="text" class="form-control" id="NgayHD" disabled />
                    </div>
                    <div class="form-group">
                        <label for="ma_nv">Mã số nhân viên:</label>
                        <input type="text" name="ma_nv" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="note">Ghi chú:</label>
                        <textarea class="form-control" id="GhiChu" disabled></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Duyệt đơn</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Hàm mở modal và nạp thông tin vào form
    function openModal(id) {
        // Gọi ajax để lấy thông tin đơn hàng theo MaHD
        $.ajax({
            url: 'get_order_details.php', // Tạo một file PHP lấy chi tiết đơn hàng
            method: 'GET',
            data: { MaHD: id },
            success: function(response) {
                var orderData = JSON.parse(response);
                // Nạp thông tin vào modal
                $('#HoTenNN').val(orderData.HoTenNN);
                $('#NgayHD').val(orderData.NgayHD);
                $('#GhiChu').val(orderData.GhiChu);
                $('#MaHD').val(orderData.MaHD);
                // Mở modal
                $('#myModal').modal('show');
            }
        });
    }
</script>

<?php include 'inc/footer.php'; ?>
