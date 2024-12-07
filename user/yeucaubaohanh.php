<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit();
}

include "./inc/header.php";
include "./inc/navbar.php";
include '../admin/connect.php';

// Lấy thông tin tài khoản
$tendn = $_SESSION['tendn'];
$sql_dn = "SELECT * FROM tai_khoan WHERE TenDangNhap='$tendn'";
$result_dn = mysqli_query($conn, $sql_dn);
$data = mysqli_fetch_array($result_dn);

// Lấy danh sách đơn hàng của khách hàng
$sql_orders = "SELECT * FROM hoa_don WHERE TenDangNhap = '{$data['TenDangNhap']}' AND TrangThai = 3";
$result_orders = mysqli_query($conn, $sql_orders);
?>

<!-- Page Header -->
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

<!-- Warranty Form -->
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
                            <input class="form-control" name="txthoten" type="text" value='<?php echo $data['HoTen']; ?>' readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input class="form-control" name="txtsdt" type="text" value='<?php echo $data['SDT']; ?>' readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" name="txtemail" type="text" value='<?php echo $data['Email']; ?>' readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ giao hàng</label>
                            <input class="form-control" name="txtdiachi" type="text" value='<?php echo $data['DiaChi']; ?>' readonly>
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
                                while ($order = mysqli_fetch_array($result_orders)) {
                                    $order_id = $order['MaDH'];
                                    $sql_products = "SELECT * FROM chi_tiet_don_hang WHERE MaDH = '$order_id'";
                                    $result_products = mysqli_query($conn, $sql_products);
                                    while ($product = mysqli_fetch_array($result_products)) {
                                        echo "<option value='{$product['TenSP']}'>Đơn hàng: {$order_id} - Sản phẩm: {$product['TenSP']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Lý do bảo hành</label>
                            <textarea class="form-control" name="txtreason" placeholder="Mô tả chi tiết lý do bảo hành" required></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ngày lập phiếu bảo hành</label>
                            <input class="form-control" name="txtdate" type="date" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ngày hẹn trả sản phẩm</label>
                            <input class="form-control" name="txtreturn_date" type="date" placeholder="Chọn ngày nhận lại sản phẩm" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Phụ kiện đi kèm (nếu có)</label>
                            <textarea class="form-control" name="txtaccessories" placeholder="Liệt kê các phụ kiện đi kèm với sản phẩm, nếu có" rows="2"></textarea>
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
                        if (mysqli_num_rows($result_orders) > 0) {
                            echo "<ul>";
                            mysqli_data_seek($result_orders, 0); // Reset pointer
                            while ($order = mysqli_fetch_array($result_orders)) {
                                echo "<li>Đơn hàng: {$order['MaDH']} - Ngày đặt: {$order['NgayDat']}</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>Bạn không có đơn hàng nào hoàn tất để yêu cầu bảo hành.</p>";
                        }
                        ?>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" name="btnsubmit_warranty" <?php echo (mysqli_num_rows($result_orders) == 0) ? 'disabled' : ''; ?>>Gửi yêu cầu bảo hành</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "./inc/footer.php"; ?>
