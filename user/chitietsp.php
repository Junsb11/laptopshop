<!-- chitietsp.php -->
<?php include "./inc/header.php"; 
if (!isset($_SESSION)) {
    session_start();
}
include "./inc/navbar.php"; ?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Chi tiết sản phẩm</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="index.php">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Chi tiết sản phẩm</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<?php 
include '../admin/connect.php';
$idsp = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$idsp) {
    echo "ID sản phẩm không hợp lệ.";
    exit;
}
$sql_chitietsp = "SELECT *, AVG(SoSao) as Sao, COUNT(d.SoSao) as Dem FROM san_pham s LEFT JOIN danhgia d ON s.MaSP = d.MaSP WHERE s.MaSP = '$idsp'";
$result_chitietsp = mysqli_query($conn, $sql_chitietsp);
if (!$result_chitietsp) {
    echo "Lỗi truy vấn cơ sở dữ liệu.";
    exit;
}

if ($result_chitietsp && mysqli_num_rows($result_chitietsp) > 0) {
    while ($data = mysqli_fetch_array($result_chitietsp)) {
        $madm = $data['MaDM'];
?>             
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src='<?php echo "../admin/" . $data['HinhAnh'] ?>' alt="Image">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold"><?php echo $data['TenSP']; ?></h3>
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    <?php for ($i = 0; $i < 5; $i++) {
                        if ($data['Sao'] - $i >= 1) { ?>
                            <small class="fas fa-star"></small>
                        <?php } elseif ($data['Sao'] - $i >= 0.5) { ?>
                            <small class="fas fa-star-half-alt"></small>
                        <?php } else { ?>
                            <small class="far fa-star"></small>
                        <?php } 
                    } ?>
                </div>
                <small class="pt-1">(<?php echo $data['Dem']; ?> đánh giá)</small>
            </div>
            <h3 class="font-weight-semi-bold mb-4"><?php echo number_format($data['DonGia'], 0, '.', '.'); ?> vnđ</h3>
            <p class="mb-4">Mô tả: <?php echo $data['MoTa']; ?></p>
            <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control bg-secondary text-center" name="quantity" value="1" form="cartForm">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <form id="cartForm" action="cart.php" method="get">
                    <input type="hidden" name="id" value="<?php echo $data['MaSP']; ?>">
                    <button type="submit" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ hàng</button>
                </form>
            </div>
            <div class="d-flex pt-2">
                <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                <div class="d-inline-flex">
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô tả</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Đánh giá (<?php echo $data['Dem']; ?>)</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Mô tả sản phẩm</h4>
                    <p> <?php echo $data['MoTa'] ?></p>
                </div>
                <?php       
                    $sql_xemdg = "SELECT * FROM danhgia WHERE MaSP = '$idsp'";
                    $result_dg = mysqli_query($conn, $sql_xemdg);
                ?>
                <div class="tab-pane fade" id="tab-pane-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4"><?php echo $data['Dem']; ?> đánh giá cho <?php echo $data['TenSP']; ?></h4>
                            <?php 
                            if ($result_dg && mysqli_num_rows($result_dg) > 0) {
                                while ($dg = mysqli_fetch_array($result_dg)) {                                  
                            ?>
                            <div class="media mb-4">
                                <img src="img/user.png" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                <div class="media-body">
                                    <h6><?php echo $dg['TenDangNhap']; ?><small> - <i><?php echo $dg['NgayDG']; ?></i></small></h6>
                                    <div class="text-primary mb-2">
                                        <?php for ($i = 0; $i < 5; $i++) {
                                            if ($dg['SoSao'] - $i >= 1) { ?>
                                                <small class="fas fa-star"></small>
                                            <?php } elseif ($dg['SoSao'] - $i >= 0.5) { ?>
                                                <small class="fas fa-star-half-alt"></small>
                                            <?php } else { ?>
                                                <small class="far fa-star"></small>
                                            <?php } 
                                        } ?>
                                    </div>
                                    <p><?php echo $dg['NoiDung']; ?></p>
                                </div>
                            </div>
                            <?php } } else { ?>
                                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">
                            <form method="post" action="chitietsp.php?id=<?php echo $idsp; ?>">
                                <h4 class="mb-4">ĐÁNH GIÁ</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Số sao * :</p>
                                    <div class="text-primary">
                                        <select name="txtsosao" required>
                                            <option value="1">1 Sao</option>
                                            <option value="2">2 Sao</option>
                                            <option value="3">3 Sao</option>
                                            <option value="4">4 Sao</option>
                                            <option value="5">5 Sao</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txtnoidung">Nội dung đánh giá *</label>
                                    <textarea id="txtnoidung" name="txtnoidung" cols="30" rows="5" class="form-control" required></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <?php if (isset($_SESSION['tendn'])) { ?>
                                    <input type="submit" value="Gửi đánh giá" class="btn btn-primary px-3">
                                    <?php } else { ?>
                                    <p>Bạn cần đăng nhập để đánh giá sản phẩm. <a href="dangnhap.php">Đăng nhập</a></p>
                                    <?php } ?>
                                </div>
                            </form>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['txtnoidung']) && isset($_POST['txtsosao']) && isset($_SESSION['tendn'])) {
                                    $tendn = $_SESSION['tendn'];
                                    $noidung = mysqli_real_escape_string($conn, $_POST['txtnoidung']);
                                    $sosao = (int) $_POST['txtsosao'];
                                    $today = date("Y-m-d H:i:s");
                                    $sql_them = "INSERT INTO danhgia (MaSP, TenDangNhap, SoSao, NoiDung, NgayDG, TrangThai) 
                                                 VALUES ('$idsp', '$tendn', '$sosao', '$noidung', '$today', 1)";
                                    $result_them = mysqli_query($conn, $sql_them);
                                    if ($result_them) {
                                        echo "<script>
                                            alert('Đánh giá của bạn đã được gửi.');
                                            window.location.href='chitietsp.php?id=$idsp&tab=3';
                                        </script>";
                                    } else {
                                        echo "Lỗi: " . $sql_them . "<br>" . mysqli_error($conn);
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }
} else {
    echo "Không tìm thấy sản phẩm.";
} ?>
<!-- Shop Detail End -->

<?php include "./inc/footer.php"; ?>

<script>
$(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has('tab')) {
        var tabIndex = urlParams.get('tab');
        $('.nav-tabs a[href="#tab-pane-' + tabIndex + '"]').tab('show');
    }
});
</script>