<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
    include 'connect.php';

    // Records per page
    $limit = 10; 
    // Get the current page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // Fetch attendance data with pagination
    $sql_chamcong = "SELECT MaChamCong, MaNV, Ngay, SoGio, TrangThai FROM ChamCong LIMIT ?, ?";
    $stmt = $conn->prepare($sql_chamcong);
    $stmt->bind_param("ii", $offset, $limit);
    $stmt->execute();
    $result_cc = $stmt->get_result();

    if (!$result_cc) {
        die("Error fetching attendance data: " . $stmt->error);
    }

    // Get the total number of records for pagination
    $sql_total = "SELECT COUNT(*) AS total FROM ChamCong";
    $result_total = $conn->query($sql_total);
    $total_records = $result_total->fetch_assoc()['total'];
    $total_pages = ceil($total_records / $limit);
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

            <!-- Pagination -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="chamcong.php?page=<?php echo $page - 1; ?>" class="prev">« Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="chamcong.php?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="chamcong.php?page=<?php echo $page + 1; ?>" class="next">Next »</a>
                <?php endif; ?>
            </div>

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
