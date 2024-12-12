<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
    include 'connect.php';

    // Fetch attendance data with pagination
    $limit = 10; // Records per page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    $sql_chamcong = "SELECT MaChamCong, MaNV, Ngay, SoGio, TrangThai FROM ChamCong LIMIT ?, ?";
    $stmt = $conn->prepare($sql_chamcong);
    $stmt->bind_param("ii", $offset, $limit);
    $stmt->execute();
    $result_cc = $stmt->get_result();

    if (!$result_cc) {
        die("Error fetching attendance data: " . $stmt->error);
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Chấm công nhân viên</h2>
        <div class="block">  
            <table class="data display datatable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã NV</th>
                        <th>Ngày</th>
                        <th>Số giờ</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $stt = $offset + 1;
                    while ($row = $result_cc->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo htmlspecialchars($row['MaNV']); ?></td>
                            <td><?php echo htmlspecialchars($row['Ngay']); ?></td>
                            <td><?php echo htmlspecialchars($row['SoGio']); ?></td>
                            <td><?php echo htmlspecialchars($row['TrangThai']); ?></td>
                            <td>
                                <a href="suachamcong.php?id=<?php echo $row['MaChamCong']; ?>">Sửa</a> ||
                                <a href="xoachamcong.php?id=<?php echo $row['MaChamCong']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                            </td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
            <a href="themmoi_chamcong.php" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.datatable').dataTable();
    });
</script>
<?php include 'inc/footer.php'; ?>
