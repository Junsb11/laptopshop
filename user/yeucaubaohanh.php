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

$tendn = $_SESSION['tendn'];
$sql_dn = "SELECT * FROM tai_khoan WHERE TenDangNhap='$tendn'";
$result_dn = mysqli_query($conn, $sql_dn);
$data = mysqli_fetch_array($result_dn);

// Kiểm tra đơn hàng của khách hàng
$order_details = ""; // Lấy các chi tiết đơn hàng từ giỏ hàng nếu cần
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $item) {
        $order_details .= $item['tensp'] . " x " . $item['sl'] . " | ";
    }
}
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Yêu cầu bảo hành</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Trang chủ</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Yêu cầu bảo hành</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Warranty Request Start -->
<form method="post" action="process_warranty.php">
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
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
                            <label>Tên dòng máy</label>
                            <input class="form-control" name="txtproduct" type="text" placeholder="Tên dòng máy" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Mã đơn hàng</label>
                            <input class="form-control" name="txtorder" type="text" value="<?php echo uniqid('ORD'); ?>" readonly>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Lý do bảo hành</label>
                            <textarea class="form-control" name="txtreason" placeholder="Vui lòng mô tả lý do bảo hành" required></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Ngày yêu cầu bảo hành</label>
                            <input class="form-control" name="txtdate" type="date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Chi tiết đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Sản phẩm đã mua</h5>
                        <?php foreach ($_SESSION['cart'] as $ds) { ?>
                            <div class="d-flex justify-content-between">
                                <p><?php echo $ds['tensp'] . ' x ' . $ds['sl']; ?></p>
                                <p><?php echo number_format($ds['dongia'], 0, '.', '.'); ?></p>
                            </div>
                        <?php } ?>
                        <hr class="mt-0">
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" name="btnsubmit_warranty">Gửi yêu cầu bảo hành</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Warranty Request End -->

<?php include "./inc/footer.php"; ?>

<script>
    // JavaScript for handling form validation or other dynamic features can be added here
</script>
