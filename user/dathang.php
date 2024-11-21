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
$sql_dn = "SELECT * FROM tai_khoan where TenDangNhap='$tendn'";
$result_dn = mysqli_query($conn, $sql_dn);
$data = mysqli_fetch_array($result_dn);
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Đặt hàng</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Trang chủ</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Đặt hàng</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Checkout Start -->
<form method="post" action="thanhtoan.php">
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Thông tin người đặt hàng</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Họ và Tên</label>
                            <input class="form-control" name="txthoten" type="text" placeholder="John" value='<?php echo $data['HoTen']; ?>'>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input class="form-control" name="txtsdt" type="text" placeholder="" value='<?php echo $data['SDT']; ?>'>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" name="txtemail" type="text" placeholder="example@email.com" value='<?php echo $data['Email']; ?>'>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ</label>
                            <input class="form-control" name="txtdiachi" type="text" placeholder="" value='<?php echo $data['DiaChi']; ?>'>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ghi chú</label>
                            <input class="form-control" name="txtghichu" type="text" placeholder="">
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto">
                                <label class="custom-control-label" for="shipto" data-toggle="collapse" data-target="#shipping-address">Gửi hàng đến địa chỉ khác.</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse mb-4" id="shipping-address">
                    <h4 class="font-weight-semi-bold mb-4">Địa chỉ giao hàng</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Họ và tên đệm</label>
                            <input class="form-control" type="text" placeholder="Dương Văn">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tên</label>
                            <input class="form-control" type="text" placeholder="Hữu">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input class="form-control" type="text" placeholder="+84 123456789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ</label>
                            <input class="form-control" type="text" placeholder="18 Ông Ích Khiêm">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ chi tiết (Tầng/Số căn hộ)</label>
                            <input class="form-control" type="text" placeholder="Tầng 3">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Quốc gia</label>
                            <select class="custom-select">
                                <option selected>Việt Nam</option>
                                <option>Afghanistan</option>
                                <option>Albania</option>
                                <option>Germany</option>
                                <option>United States</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tỉnh/Thành Phố</label>
                            <input class="form-control" type="text" placeholder="Đà Nẵng">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Quận/Huyện</label>
                            <input class="form-control" type="text" placeholder="Thanh Khê">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mã bưu chính</label>
                            <input class="form-control" type="text" placeholder="123">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Tổng hóa đơn</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Sản phẩm</h5>
                        <?php $tong = 0; foreach ($_SESSION['cart'] as $ds) { ?>
                            <div class="d-flex justify-content-between">
                                <p><?php echo $ds['tensp'] . ' x ' . $ds['sl']; ?></p>
                                <p><?php echo number_format($ds['dongia'], 0, '.', '.'); ?></p>
                            </div>
                            <?php $tong = $tong + $ds['dongia'] * $ds['sl']; ?>
                        <?php } ?>
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Thành tiền</h6>
                            <h6 class="font-weight-medium"><?php echo number_format($tong, 0, '.', '.'); ?> vnđ</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Phí vận chuyển</h6>
                            <h6 class="font-weight-medium"><?php $ship = ($tong == 0) ? 0 : 30000; echo number_format($ship, 0, '.', '.'); ?> vnđ</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Tổng cộng</h5>
                            <h5 class="font-weight-bold"><?php echo number_format($tong + $ship, 0, '.', '.'); ?>vnđ</h5>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" name="btnthanhtoan">Đặt hàng</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Checkout End -->

<?php include "./inc/footer.php"; ?>

<script>
    // JavaScript for handling shipping address toggle
    $(document).ready(function() {
        $('#shipto').change(function() {
            if ($(this).is(':checked')) {
                $('#shipping-address').collapse('show');
            } else {
                $('#shipping-address').collapse('hide');
            }
        });
    });
</script>
