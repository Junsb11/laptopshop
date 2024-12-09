<?php
// Bắt đầu session và kiểm tra đăng nhập
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit();
}

// Kết nối CSDL
include "../admin/connect.php";
include "./inc/header.php";
include "./inc/navbar.php";

// Lấy thông tin tài khoản đăng nhập
$tendn = $_SESSION['tendn'] ?? '';
$sql_dn = "SELECT * FROM `tai_khoan` WHERE `TenDangNhap` = ?";
$stmt_dn = $conn->prepare($sql_dn);
$stmt_dn->bind_param("s", $tendn);
$stmt_dn->execute();
$result_dn = $stmt_dn->get_result();
$data = $result_dn->fetch_assoc();
$stmt_dn->close();

// Lấy danh sách đơn hàng và sản phẩm liên quan
$sql_orders = "SELECT hd.MaHD, hd.NgayHD, ctdh.MaSP, sp.TenSP
FROM `hoa_don` hd
JOIN `chi_tiet_hoa_don` ctdh ON hd.MaHD = ctdh.MaHD
JOIN `san_pham` sp ON ctdh.MaSP = sp.MaSP
WHERE hd.TenDangNhap = ? AND hd.TrangThai = 2
ORDER BY hd.NgayHD DESC;";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("s", $tendn);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
?>

<!-- Header trang -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Yêu cầu bảo hành</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="index.php">Trang chủ</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Yêu cầu bảo hành</p>
        </div>
    </div>
</div>

<!-- Form yêu cầu bảo hành -->
<form method="post" action="process_warranty.php">
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Thông tin khách hàng -->
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Thông tin khách hàng</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Họ và Tên</label>
                            <input class="form-control" name="txthoten" type="text" 
                                   value='<?php echo htmlspecialchars($data['HoTen'] ?? ""); ?>' readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input class="form-control" name="txtsdt" type="text" 
                                   value='<?php echo htmlspecialchars($data['SDT'] ?? ""); ?>' readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" name="txtemail" type="text" 
                                   value='<?php echo htmlspecialchars($data['Email'] ?? ""); ?>' readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ nhận hàng</label>
                            <input class="form-control" name="txtdiachi" type="text" 
                                   value='<?php echo htmlspecialchars($data['DiaChi'] ?? ""); ?>' readonly>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Thông tin bảo hành</h4>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Chọn sản phẩm từ đơn hàng</label>
                            <select class="form-control" name="txtproduct" required>
                                <option value="">Chọn sản phẩm...</option>
                                <?php
                                if ($result_orders->num_rows > 0) {
                                    while ($row = $result_orders->fetch_assoc()) {
                                        echo "<option value='{$row['MaSP']}'>Đơn hàng: {$row['MaDH']} - Sản phẩm: {$row['TenSP']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>Không có sản phẩm hợp lệ.</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Lý do bảo hành</label>
                            <textarea class="form-control" name="txtreason" placeholder="Mô tả chi tiết lý do bảo hành" required></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Phụ kiện đi kèm (nếu có)</label>
                            <textarea class="form-control" name="txtaccessories" placeholder="Liệt kê các phụ kiện đi kèm với sản phẩm" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chi tiết đơn hàng -->
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Chi tiết đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($result_orders->num_rows > 0) {
                            $stmt_orders->execute(); // Reset pointer
                            echo "<ul>";
                            while ($order = $result_orders->fetch_assoc()) {
                                echo "<li>Đơn hàng: {$order['MaDH']} - Ngày đặt: {$order['NgayHD']}</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>Bạn không có đơn hàng nào hoàn tất để yêu cầu bảo hành.</p>";
                        }
                        ?>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" name="btnsubmit_warranty" <?php echo ($result_orders->num_rows == 0) ? 'disabled' : ''; ?>>Gửi yêu cầu bảo hành</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
$stmt_orders->close();
$conn->close();
include "./inc/footer.php";
?>
