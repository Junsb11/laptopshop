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
                        <td><?php echo htmlspecialchars($data['HoTenNN']); ?></td>
                        <td><?php echo htmlspecialchars($data['NgayHD']); ?></td>
                        <td><?php echo htmlspecialchars($data['GhiChu']); ?></td>
                        <td><?php echo htmlspecialchars($data['DiaChi']); ?></td>
                        <td><?php echo htmlspecialchars($data['SDT']); ?></td>
                        <td>Chờ xét duyệt</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openModal(<?php echo $data['MaHD']; ?>, 'duyet')">Duyệt đơn</button>
                            ||
                            <button class="btn btn-danger btn-sm" onclick="openModal(<?php echo $data['MaHD']; ?>, 'huy')">Hủy đơn</button>
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
                <h5 class="modal-title" id="myModalLabel">Xác nhận thao tác</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="process_order.php">
                    <input type="hidden" name="MaHD" id="MaHD">
                    <input type="hidden" name="action" id="action">
                    <div class="form-group">
                        <label for="ma_nv">Mã số nhân viên:</label>
                        <input type="text" name="ma_nv" class="form-control" required />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Hàm mở modal và chuẩn bị dữ liệu
    function openModal(id, action) {
        $('#MaHD').val(id);
        $('#action').val(action);
        let title = action === 'duyet' ? 'Xác nhận duyệt đơn hàng' : 'Xác nhận hủy đơn hàng';
        $('#myModalLabel').text(title);
        $('#myModal').modal('show');
    }
</script>

<?php include 'inc/footer.php'; ?>
