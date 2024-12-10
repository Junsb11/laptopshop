<?php
session_start();
include '../admin/connect.php';

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['tendn'])) {
    header("Location: login.php");
    exit;
}

// Kiểm tra nút thanh toán đã được nhấn hay chưa
$bttt = filter_input(INPUT_POST, 'btnthanhtoan');
if (isset($bttt)) {
    // Lấy thông tin từ form và sanitize
    $tendangnhap = $_SESSION['tendn'];
    $TenKH = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'txthoten', FILTER_SANITIZE_STRING));
    $SoDienThoai = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'txtsdt', FILTER_SANITIZE_STRING));
    $DiaChi = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'txtdiachi', FILTER_SANITIZE_STRING));
    $GhiChu = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'txtghichu', FILTER_SANITIZE_STRING));
    $NgayHD = date("Y-m-d");

    // Begin Transaction
    mysqli_begin_transaction($conn);

    try {
        // Thêm thông tin vào bảng hoa_don
        $sql_inserthd = $conn->prepare("INSERT INTO hoa_don (TenDangNhap, NgayHD, TrangThai, GhiChu, HoTenNN, SDT, DiaChi) VALUES (?, ?, 0, ?, ?, ?, ?)");
        $sql_inserthd->bind_param("ssssss", $tendangnhap, $NgayHD, $GhiChu, $TenKH, $SoDienThoai, $DiaChi);
        $result_inserthd = $sql_inserthd->execute();

        if (!$result_inserthd) {
            throw new Exception("Lỗi khi thêm hóa đơn.");
        }

        // Lấy mã hóa đơn vừa được tạo
        $MaHD = $conn->insert_id; // Get the last inserted ID (Order ID)

        // Thêm chi tiết hóa đơn từ giỏ hàng vào bảng chi_tiet_hoa_don
        foreach ($_SESSION['cart'] as $ds) {
            $MaSP = $ds['idsp'];
            $dongia = $ds['dongia'];
            $TyLeKM = 0; // Khuyến mãi = 0 (có thể thay đổi tùy theo logic của bạn)
            $Sl = $ds['sl'];

            // Sử dụng prepared statement để chèn chi tiết vào chi_tiet_hoa_don
            $sql_insertcthd = $conn->prepare("INSERT INTO chi_tiet_hoa_don (MaHD, MaSP, TenKH, GiaGoc, TyLeKM, SoLuongMua) VALUES (?, ?, ?, ?, ?, ?)");
            $sql_insertcthd->bind_param("iissii", $MaHD, $MaSP, $TenKH, $dongia, $TyLeKM, $Sl);
            $result_insertcthd = $sql_insertcthd->execute();

            if (!$result_insertcthd) {
                throw new Exception("Lỗi khi thêm chi tiết hóa đơn.");
            }
        }

        // Commit transaction
        mysqli_commit($conn);

        // Đặt hàng thành công, xóa giỏ hàng sau khi đặt hàng thành công
        unset($_SESSION['cart']);
    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi
        mysqli_roll_back($conn);
        echo "Đặt hàng không thành công. Lỗi: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 400px;
        }
        .success-icon {
            width: 100px;
            height: 100px;
            background-image: url('https://cdn.sforum.vn/sforum/wp-content/uploads/2023/01/asus-rog-ces-2023-02.jpg');
            background-size: cover;
            margin: 20px auto;
        }
        h2 {
            color: #333;
        }
        p {
            color: #666;
            margin-bottom: 20px;
        }
        .home-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .home-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon"></div>
        <h2>Đặt hàng thành công!</h2>
        <p>Cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi.</p>
        <a href="home.php" class="home-link">Tiếp tục mua hàng</a>
    </div>
</body>
</html>
