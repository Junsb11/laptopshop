<?php
include 'connect.php';
session_start();

// Kiểm tra quyền nhân viên
if ($_SESSION['VaiTro'] != 'kythuat') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhân viên Kỹ Thuật Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <!-- Thêm các liên kết CSS khác tại đây -->
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <h1>Chào mừng <?= $_SESSION['Username']; ?></h1>
            <p>Thông tin công việc của bạn</p>
            <div class="user-info">
                <img src="img/profile.jpg" alt="Ảnh đại diện" />
                <span>Xin chào, <?= $_SESSION['Username']; ?></span>
                <a href="?logout=true">Đăng xuất</a>
            </div>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Công việc hiện tại -->
            <section class="current-tasks">
                <h2>Công việc của bạn</h2>
                <ul>
                    <li><a href="baohanhchoxuly.php">Bảo Hành Chờ Xử Lý</a></li>
                    <li><a href="baohanhdangxuly.php">Bảo Hành Đang Xử Lý</a></li>
                    <li><a href="baohanhdaxuly.php">Bảo Hành Đa Xử Lý</a></li>
                    <li><a href="baohanhdahuy.php">Bảo Hành Đã Hủy</a></li>
                    <li><a href="info.php">Cập nhật thông tin cá nhân</a></li>
                    <li><a href="xem_bao_cao.php">Xem báo cáo công việc</a></li>
                </ul>
            </section>

            <!-- Thông báo -->
            <section class="notifications">
                <h2>Thông báo mới</h2>
                <ul>
                    <li>Cập nhật thông tin khách hàng trong đơn hàng #123</li>
                    <li>Thực hiện kiểm tra kho hàng vào cuối tuần</li>
                </ul>
            </section>
        </div>
    </div>

</body>
</html>
