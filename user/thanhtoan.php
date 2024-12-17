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

    // Kiểm tra đầu vào
    if (empty($TenKH) || empty($SoDienThoai) || empty($DiaChi)) {
        echo "Vui lòng điền đầy đủ thông tin đặt hàng.";
        exit;
    }
    if (!preg_match('/^[0-9]{10}$/', $SoDienThoai)) {
        echo "Số điện thoại không hợp lệ.";
        exit;
    }
    if (empty($_SESSION['cart'])) {
        echo "Giỏ hàng trống, không thể thực hiện đặt hàng.";
        exit;
    }

    // Bắt đầu transaction
    mysqli_autocommit($conn, false);

    try {
        // Thêm thông tin vào bảng hoa_don
        $sql_inserthd = $conn->prepare(
            "INSERT INTO hoa_don (TenDangNhap, NgayHD, TrangThai, GhiChu, HoTenNN, SDT, DiaChi) 
             VALUES (?, ?, 0, ?, ?, ?, ?)"
        );
        $sql_inserthd->bind_param("ssssss", $tendangnhap, $NgayHD, $GhiChu, $TenKH, $SoDienThoai, $DiaChi);
        $result_inserthd = $sql_inserthd->execute();

        if (!$result_inserthd) {
            throw new Exception("Lỗi khi thêm hóa đơn.");
        }

        // Lấy mã hóa đơn vừa được tạo
        $MaHD = $conn->insert_id;

        // Thêm chi tiết hóa đơn từ giỏ hàng vào bảng chi_tiet_hoa_don và cập nhật tồn kho
        foreach ($_SESSION['cart'] as $ds) {
            $MaSP = $ds['idsp'];
            $dongia = $ds['dongia'];
            $Sl = $ds['sl'];

            // Kiểm tra tồn kho trước khi thêm vào hóa đơn
            $sql_checkstock = $conn->prepare("SELECT so_luong FROM san_pham WHERE MaSP = ?");
            $sql_checkstock->bind_param("i", $MaSP);
            $sql_checkstock->execute();
            $result_checkstock = $sql_checkstock->get_result();
            $product = $result_checkstock->fetch_assoc();

            if (!$product || $product['so_luong'] < $Sl) {
                throw new Exception("Số lượng sản phẩm không đủ trong kho để thực hiện đơn hàng.");
            }

            // Trừ số lượng sản phẩm trong kho
            $sql_updatestock = $conn->prepare("UPDATE san_pham SET so_luong = so_luong - ? WHERE MaSP = ?");
            $sql_updatestock->bind_param("ii", $Sl, $MaSP);
            $result_updatestock = $sql_updatestock->execute();

            if (!$result_updatestock) {
                throw new Exception("Lỗi khi cập nhật số lượng tồn kho.");
            }

            // Thêm vào chi_tiet_hoa_don
            $sql_insertcthd = $conn->prepare(
                "INSERT INTO chi_tiet_hoa_don (MaHD, MaSP, TenKH, GiaGoc, TyLeKM, SoLuongMua) 
                 VALUES (?, ?, ?, ?, 0, ?)"
            );
            $sql_insertcthd->bind_param("iissi", $MaHD, $MaSP, $TenKH, $dongia, $Sl);
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
        mysqli_rollback($conn);
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
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            animation: fadeIn 0.5s ease-in-out;
        }

        .success-icon {
            width: 120px;
            height: 120px;
            background-image: url('https://cdn.sforum.vn/sforum/wp-content/uploads/2023/01/asus-rog-ces-2023-02.jpg');
            background-size: cover;
            background-position: center;
            border-radius: 50%;
            margin: 0 auto 20px auto;
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .home-link {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            text-decoration: none;
            border-radius: 30px;
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
