<?php
include 'connect.php';
session_start();

// Kiểm tra nếu đã đăng nhập thì chuyển hướng đến trang phù hợp
if (isset($_SESSION['TenDangNhap'])) {
    if ($_SESSION['role'] == 2) {
        header("Location: admin_dashboard.php");
    } elseif ($_SESSION['role'] == 3) {
        header("Location: quanly_dashboard.php");
    } elseif ($_SESSION['role'] == 4) {
        header("Location: kythuat_dashboard.php");
    } else {
        header("Location: ../user/home.php");
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin từ form
    $username = $_POST['adminUser'];
    $password = $_POST['adminPass'];

    // Kiểm tra thông tin đăng nhập
    if (!empty($username) && !empty($password)) {
        // Bảo mật: Sử dụng prepared statements
        $sql = "SELECT * FROM tai_khoan WHERE TenDangNhap = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Kiểm tra mật khẩu
            if (password_verify($password, $user['MatKhau'])) {
                // Đăng nhập thành công
                $_SESSION['TenDangNhap'] = $user['TenDangNhap'];
                $_SESSION['role'] = $user['MaLoai'];

                // Điều hướng dựa trên vai trò
                if ($user['MaLoai'] == 2) {
                    header("Location: admin_dashboard.php");
                } elseif ($user['MaLoai'] == 3) {
                    header("Location: quanly_dashboard.php");
                } elseif ($user['MaLoai'] == 4) {
                    header("Location: kythuat_dashboard.php");
                } else {
                    header("Location: ../user/home.php");
                }
                exit();
            } else {
                $error_message = "Mật khẩu không chính xác.";
            }
        } else {
            $error_message = "Tên đăng nhập không tồn tại.";
        }
    } else {
        $error_message = "Vui lòng nhập tên đăng nhập và mật khẩu.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
    <section id="content">
        <form action="login.php" method="post">
            <h1>Login</h1>

            <?php if (isset($error_message)): ?>
                <div class="error-message" style="color: red;"><?= $error_message; ?></div>
            <?php endif; ?>

            <div>
                <input type="text" placeholder="Username" required="" name="adminUser" />
            </div>
            <div>
                <input type="password" placeholder="Password" required="" name="adminPass" />
            </div>
            <div>
                <input type="submit" value="Log in" />
            </div>
        </form><!-- form -->

        <div class="button">
            <a href="#">Training with live project</a>
        </div><!-- button -->
    </section><!-- content -->
</div><!-- container -->
</body>
</html>
