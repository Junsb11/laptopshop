<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
    include 'connect.php';

    // Fetch limited employee data with pagination
    $limit = 10; // Records per page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // SQL query to fetch employee data with counts for approved invoices and handled warranty orders
    $sql_xemnv = "SELECT nv.MaNV, nv.HoTen, nv.Email, nv.SDT, nv.VaiTro, nv.LuongCB, nv.TrangThai, nv.GhiChu,
        IFNULL(SUM(CASE WHEN hd.TrangThai = 1 THEN 1 ELSE 0 END), 0) AS SoHoaDonDuyet,
        IFNULL(SUM(CASE WHEN bh.TrangThai = 2 THEN 1 ELSE 0 END), 0) AS SoDonBaoHanh
    FROM nhan_vien nv
    LEFT JOIN hoa_don hd ON nv.MaNV = hd.MaNV
    LEFT JOIN bao_hanh bh ON nv.MaNV = bh.MaNV
    GROUP BY nv.MaNV 
    ORDER BY nv.MaNV
    LIMIT ?, ?";

    $stmt = $conn->prepare($sql_xemnv);
    $stmt->bind_param("ii", $offset, $limit);
    $stmt->execute();
    $result_nv = $stmt->get_result();

    if (!$result_nv) {
        die("Error fetching employee data: " . $stmt->error);
    }

    $result_count = $conn->query("SELECT COUNT(*) AS total FROM nhan_vien");
    $total_rows = $result_count->fetch_assoc()['total'];
    $total_pages = ceil($total_rows / $limit);
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách nhân viên</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên nhân viên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Chức vụ</th>
                        <th>Lương cơ bản</th>
                        <th>Chấm công</th>
                        <th>Trạng thái</th>
                        <th>Lương Thực Tế</th>
                        <th>Ghi chú</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $stt = $offset + 1;
                    while ($data = $result_nv->fetch_assoc()) {                                  
                        $soHoaDonDuyet = $data['SoHoaDonDuyet'];
                        $soDonBaoHanh = $data['SoDonBaoHanh'];
                        $tongDon = $soHoaDonDuyet + $soDonBaoHanh;

                        // Fetch the number of working days for the current month
                        $sql_chamcong = "SELECT COUNT(*) AS SoNgayLamViec FROM ChamCong WHERE MaNV = ? AND MONTH(Ngay) = MONTH(CURDATE()) AND YEAR(Ngay) = YEAR(CURDATE())";
                        $stmt_chamcong = $conn->prepare($sql_chamcong);
                        $stmt_chamcong->bind_param("i", $data['MaNV']);
                        $stmt_chamcong->execute();
                        $result_chamcong = $stmt_chamcong->get_result();
                        $soNgayCong = $result_chamcong->fetch_assoc()['SoNgayLamViec'] ?? 0;

                        // Calculate actual salary
                        $luongThucTe = ($data['LuongCB'] / 30) * $soNgayCong;

                        // Apply a bonus multiplier if applicable
                        $heSoThuong = ($tongDon >= 50) ? 1.1 : 1.0;
                        $luongThucTe *= $heSoThuong;
                ?>
                    <tr class="odd gradeX">
                        <td><?php echo htmlspecialchars($stt++); ?></td>
                        <td><?php echo htmlspecialchars($data['HoTen']); ?></td>
                        <td><?php echo htmlspecialchars($data['Email']); ?></td>
                        <td><?php echo htmlspecialchars($data['SDT']); ?></td>
                        <td><?php echo htmlspecialchars($data['VaiTro']); ?></td>
                        <td><?php echo number_format($data['LuongCB'], 0, ',', '.');?> VND</td>
                        <td><?php echo htmlspecialchars($soNgayCong);?> ngày</td>
                        <td><?php echo $data['TrangThai'] === 'Đang làm' ? 'Đang làm' : 'Đã nghỉ';?></td>
                        <td><?php echo number_format($luongThucTe, 0, ',', '.');?> VND</td>
                        <td><?php echo htmlspecialchars($data['GhiChu']); ?></td>
                        <td>
                            <a href="suanhanvien.php?id=<?php echo urlencode($data['MaNV']); ?>">Edit</a> || 
                            <a href="chitietcongnhanvien.php?id=<?php echo urlencode($data['MaNV']); ?>">Chi Tiết</a> || 
                            <a href="xoanhanvien.php?id=<?php echo urlencode($data['MaNV']); ?>" onclick="return confirm('Bạn có chắc muốn xóa nhân viên này?');">Delete</a>
                        </td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
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