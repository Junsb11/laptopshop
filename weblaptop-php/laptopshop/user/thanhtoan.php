<?php
session_start();
include '../admin/connect.php';

// Kiểm tra nút thanh toán đã được nhấn hay chưa
$bttt = filter_input(INPUT_POST, 'btnthanhtoan');
if (isset($bttt)) {
    // Lấy thông tin từ form
    $tendangnhap = $_SESSION['tendn'];
    $TenKH = filter_input(INPUT_POST, 'txthoten');
    $SoDienThoai = filter_input(INPUT_POST, 'txtsdt');
    $DiaChi = filter_input(INPUT_POST, 'txtdiachi');
    $GhiChu = filter_input(INPUT_POST, 'txtghichu');
    $NgayHD = date("Y-m-d");

    // Thêm thông tin vào bảng hoa_don
    $sql_inserthd = "INSERT INTO hoa_don (TenDangNhap, NgayHD, TrangThai, GhiChu, HoTenNN, SDT, DiaChi) VALUES ('$tendangnhap', '$NgayHD', 0, '$GhiChu', '$TenKH', '$SoDienThoai', '$DiaChi')";
    $result_inserthd = mysqli_query($conn, $sql_inserthd);

    if ($result_inserthd) {
        // Lấy mã hóa đơn vừa được tạo
        $qrcthd = "SELECT MaHD FROM hoa_don ORDER BY MaHD DESC LIMIT 1";
        $kq = mysqli_query($conn, $qrcthd);
        $row = mysqli_fetch_array($kq);
        $MaHD = $row['MaHD'];

        // Thêm chi tiết hóa đơn từ giỏ hàng vào bảng chi_tiet_hoa_don
        foreach ($_SESSION['cart'] as $ds) {
            $MaSP = $ds['idsp'];
            $dongia = $ds['dongia'];
            $TyLeKM = 0; // Khuyến mãi = 0 (có thể thay đổi tùy theo logic của bạn)
            $Sl = $ds['sl'];
            $sql_insertcthd = "INSERT INTO chi_tiet_hoa_don (MaHD, MaSP, TenKH, GiaGoc, TyLeKM, SoLuongMua) VALUES ('$MaHD', '$MaSP', '$TenKH', '$dongia', '$TyLeKM', '$Sl')";
            $result_insertcthd = mysqli_query($conn, $sql_insertcthd);

            if (!$result_insertcthd) {
                echo "Đặt hàng không thành công";
                exit; // Thoát khỏi vòng lặp nếu thất bại
            }
        }

        // Đặt hàng thành công, hiển thị thông báo
        // Xóa giỏ hàng sau khi đặt hàng thành công
        unset($_SESSION['cart']);
    } else {
        echo "Đặt hàng không thành công";
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
