<?php
session_start();
include 'connect.php';

// Kiểm tra quyền truy cập
if ($_SESSION['VaiTro'] != 'admin') {
    echo "Bạn không có quyền truy cập vào trang này.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Quản trị viên</title>
    <link rel="stylesheet" href="styles.css"> <!-- Đảm bảo có file CSS cho trang -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Chào mừng bạn đến với trang quản trị viên</h1>
        <div class="user-info">
            <p>Xin chào, <?php echo $_SESSION['TenDangNhap']; ?></p>
            <a href="logout.php">Đăng xuất</a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="xemdanhmuc.php">Quản lý danh mục</a></li>
            <li><a href="xemsanpham.php">Quản lý sản phẩm</a></li>
            <li><a href="xemtaikhoan.php">Quản lý tài khoản</a></li>
            <li><a href="xemnhanvien.php">Quản lý nhân viên</a></li>
            <li><a href="donhangchoxetduyet.php">Quản lý đơn hàng</a></li>
            <li><a href="baohanhchoxuly.php">Quản lý bảo hành</a></li>
            <li><a href="thongkesp.php">Thống kê doanh thu</a></li>
            <li><a href="quanlyquyen.php">Quản lý quyền hạn</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Thông tin tổng quan</h2>

        <div class="stats">
            <div class="stat-item">
                <h3>Thống kê sản phẩm</h3>
                <p>
                    <?php
                    $sql = "SELECT COUNT(*) as product_count FROM san_pham";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo "Số lượng sản phẩm: " . $row['product_count'];
                    ?>
                </p>
            </div>
            <div class="stat-item">
                <h3>Thống kê nhân viên</h3>
                <p>
                    <?php
                    $sql = "SELECT COUNT(*) as employee_count FROM nhanvien";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo "Số lượng nhân viên: " . $row['employee_count'];
                    ?>
                </p>
            </div>
            <div class="stat-item">
                <h3>Doanh thu trong tháng</h3>
                <p>
                    <?php
                    $sql = "SELECT SUM(TongTien) as total_sales FROM don_hang WHERE MONTH(NgayDat) = MONTH(CURRENT_DATE)";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo "Doanh thu: " . number_format($row['total_sales'], 0, ',', '.') . " VND";
                    ?>
                </p>
            </div>
        </div>

        <!-- Quick Actions -->
        <h3>Hành động nhanh</h3>
        <div class="actions">
            <a href="themmoidanhmuc.php" class="action-btn">Thêm mới danh mục</a>
            <a href="themmoisanpham.php" class="action-btn">Thêm mới sản phẩm</a>
            <a href="themtaikhoan.php" class="action-btn">Thêm tài khoản</a>
            <a href="themmoinhanvien.php" class="action-btn">Thêm nhân viên</a>
            <a href="donhangchoxetduyet.php" class="action-btn">Xem đơn hàng chờ duyệt</a>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 Website Bán Laptop. All rights reserved.</p>
    </div>
</body>
</html>
