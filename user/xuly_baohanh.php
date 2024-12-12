<?php
session_start();

if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit();
}

include "../admin/connect.php";

// Form data
$txtproduct = $_POST['txtproduct'] ?? '';
$txtreason = $_POST['txtreason'] ?? '';
$txtaccessories = $_POST['txtaccessories'] ?? '';
$txtngayyeucau = date('Y-m-d H:i:s');  // Current date and time for Request Date

// Validate input
if (!empty($txtproduct) && !empty($txtreason)) {
    // Prepare and bind
    $stmt_insert = $conn->prepare("INSERT INTO bao_hanh (TenDangNhap, MaSP, LyDo, TrangThai, GhiChu, NgayHen, NgayHoanThanh, MaNV) VALUES (?, ?, ?, 0, ?, '', '', '')");
    $stmt_insert->bind_param("ssss", $_SESSION['tendn'], $txtproduct, $txtreason, $txtaccessories);
    

    if ($stmt_insert->execute()) {
        $message = "Yêu cầu bảo hành của bạn đã được gửi thành công!";
        $type = "success";
    } else {
        $message = "Có lỗi xảy ra, vui lòng thử lại!";
        $type = "error";
    }

    $stmt_insert->close();
} else {
    $message = "Vui lòng điền đầy đủ thông tin!";
    $type = "error";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #f4f4f9, #c1d3fe);
            animation: gradientBackground 10s infinite alternate;
        }

        @keyframes gradientBackground {
            0% {
                background: linear-gradient(135deg, #f4f4f9, #c1d3fe);
            }
            100% {
                background: linear-gradient(135deg, #dfe9f3, #a1c4fd);
            }
        }

        .notification {
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            transform: scale(1);
            transition: transform 0.3s ease;
        }

        .notification:hover {
            transform: scale(1.05);
        }

        .notification.success {
            background-color: #e6ffed;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .notification.error {
            background-color: #ffeeef;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .notification p {
            font-size: 18px;
            margin: 0 0 15px;
        }

        .notification button {
            margin-top: 15px;
            padding: 12px 30px;
            font-size: 16px;
            color: #fff;
            background-color: #0066ff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .notification button:hover {
            background-color: #0052cc;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="notification <?php echo $type; ?>">
        <p><?php echo $message; ?></p>
        <button onclick="window.location.href='home.php'">Quay lại trang chủ</button>
    </div>
</body>
</html>
