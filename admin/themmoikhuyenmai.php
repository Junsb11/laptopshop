<?php
session_start();
ob_start(); // Bắt đầu output buffering

// Kết nối tập tin cần thiết
include 'inc/header.php';
include 'inc/sidebar.php';
include 'connect.php';

// Sinh token CSRF cho form
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Thông báo từ session
$notification = "";
if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    unset($_SESSION['notification']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra token CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Yêu cầu không hợp lệ.");
    }

    // Lấy dữ liệu từ form
    $tenkm = trim($_POST['tenkm']);
    $tungay = trim($_POST['tungay']);
    $denngay = trim($_POST['denngay']);
    $trangthai = isset($_POST['trangthai']) ? intval($_POST['trangthai']) : 0;

    // Kiểm tra dữ liệu nhập vào
    if (empty($tenkm) || empty($tungay) || empty($denngay)) {
        $_SESSION['notification'] = "<p class='error'>Vui lòng nhập đầy đủ các trường!</p>";
        header("Location: themmoikhuyenmai.php");
        exit;
    } elseif ($tungay > $denngay) {
        $_SESSION['notification'] = "<p class='error'>Ngày bắt đầu không được sau ngày kết thúc!</p>";
        header("Location: themmoikhuyenmai.php");
        exit;
    } else {
        // Chèn dữ liệu vào bảng khuyến mãi
        try {
            $stmt = $conn->prepare("INSERT INTO khuyen_mai (TenKM, TuNgay, DenNgay, TrangThai) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $tenkm, $tungay, $denngay, $trangthai);

            if ($stmt->execute()) {
                $_SESSION['notification'] = "<p class='success'>Thêm mới khuyến mãi thành công!</p>";
            } else {
                throw new Exception("Lỗi khi thêm khuyến mãi: " . $stmt->error);
            }

            $stmt->close();
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['notification'] = "<p class='error'>Lỗi khi thêm khuyến mãi. Vui lòng thử lại sau!</p>";
        }
        
        header("Location: themmoikhuyenmai.php");
        exit;
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Thêm mới khuyến mãi</h2>
        <div class="block">               

            <?php echo $notification; ?>

            <form action="" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <table class="form">
                    <tr>
                        <td><label for="tenkm">Tên khuyến mãi:</label></td>
                        <td><input type="text" name="tenkm" id="tenkm" placeholder="Nhập tên khuyến mãi" required /></td>
                    </tr>
                    <tr>
                        <td><label for="tungay">Từ ngày:</label></td>
                        <td><input type="date" name="tungay" id="tungay" required /></td>
                    </tr>
                    <tr>
                        <td><label for="denngay">Đến ngày:</label></td>
                        <td><input type="date" name="denngay" id="denngay" required /></td>
                    </tr>
                    <tr>
                        <td><label for="trangthai">Trạng thái:</label></td>
                        <td>
                            <select name="trangthai" id="trangthai" required>
                                <option value="1">Đang hoạt động</option>
                                <option value="0">Ngừng hoạt động</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Thêm mới" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<style>
    .form {
        width: 100%;
        border-collapse: collapse;
    }
    .form td {
        padding: 10px;
        vertical-align: top;
    }
    .form label {
        display: block;
        margin-bottom: 5px;
    }
    .form input, .form select {
        width: 100%;
        padding: 5px;
    }
    .box {
        background-color: #f9f9f9;
        padding: 20px;
    }
    .grid_10 {
        width: 100%;
    }
    .block {
        margin-top: 20px;
    }
    .success {
        color: green;
    }
    .error {
        color: red;
    }
</style>

<?php include 'inc/footer.php'; ?>
<?php ob_end_flush(); ?>
