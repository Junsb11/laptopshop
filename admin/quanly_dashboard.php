<?php
include 'connect.php';
session_start();

// Kiểm tra quyền admin
if ($_SESSION['VaiTro'] != 'quanly') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <!-- Thêm các liên kết CSS khác tại đây -->
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <h1>Chào mừng Quản lý</h1>
            <p>Quản lý Shop Laptop</p>
            <div class="user-info">
                <img src="img/profile.jpg" alt="Ảnh đại diện" />
                <span>Xin chào, <?= $_SESSION['Username']; ?></span>
                <a href="?logout=true">Đăng xuất</a>
            </div>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Tổng quan hệ thống -->
            <div class="stats-overview">
                <div class="stats-card">
                    <h3>Tổng số nhân viên</h3>
                    <p>50</p> <!-- Số liệu thực tế từ cơ sở dữ liệu -->
                </div>
                <div class="stats-card">
                    <h3>Doanh thu tháng này</h3>
                    <p>10,000,000 VND</p>
                </div>
                <div class="stats-card">
                    <h3>Số lượng đơn hàng</h3>
                    <p>120</p> <!-- Dữ liệu có thể lấy từ database -->
                </div>
            </div>

            <!-- Biểu đồ thống kê -->
            <section class="charts-section">
                <h2>Thống kê</h2>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                    <!-- Biểu đồ có thể sử dụng Chart.js -->
                </div>
            </section>

            <!-- Thông báo hoặc công việc cần làm -->
            <section class="notifications">
                <h2>Công việc cần làm</h2>
                <ul>
                    <li><a href="themmoinhanvien.php">Thêm mới nhân viên</a></li>
                    <li><a href="donhangchoxetduyet.php">Xem đơn hàng cần xử lý</a></li>
                    <li><a href="xemsanpham.php">Quản lý sản phẩm</a></li>
                </ul>
            </section>
        </div>
    </div>

    <script src="js/Chart.min.js"></script>
    <script>
        // Biểu đồ doanh thu (ví dụ dùng Chart.js)
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'],
                datasets: [{
                    label: 'Doanh thu',
                    data: [2000000, 3000000, 2500000, 4000000],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>
