<?php 
include "./inc/header.php"; 
include "./inc/navbar.php"; 
include '../admin/connect.php';

// Start the session only if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validate database connection
if (!$conn) {
    die("Unable to connect to the database.");
}

// Retrieve product ID from URL and validate
$idsp = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$idsp || !is_numeric($idsp) || $idsp <= 0) {
    header("Location: index.php?error=invalid_id");
    exit;
}

// Fetch product details from database
$sql_chitietsp = "SELECT * FROM san_pham WHERE MaSP = ? AND TrangThai = 1";
$stmt = $conn->prepare($sql_chitietsp);
$stmt->bind_param('i', $idsp);
$stmt->execute();
$result_chitietsp = $stmt->get_result();

if ($result_chitietsp && $result_chitietsp->num_rows > 0) {
    $data = $result_chitietsp->fetch_assoc();
    $madm = $data['MaDM'];

    // Get average star rating and total reviews count
    $sql_danhgia_summary = "SELECT AVG(SoSao) AS Sao, COUNT(SoSao) AS Dem FROM danhgia WHERE MaSP = ?";
    $stmt_summary = $conn->prepare($sql_danhgia_summary);
    $stmt_summary->bind_param('i', $idsp);
    $stmt_summary->execute();
    $result_summary = $stmt_summary->get_result();
    $summary = $result_summary->fetch_assoc();
    $avg_star = $summary['Sao'] ?? 0;
    $total_reviews = $summary['Dem'] ?? 0;
?>             

<!-- Page Header Section -->
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

<!-- Product Details Section -->
<div class="container-fluid py-5">
    <div class="row d-flex justify-content-between">
        <div class="col-lg-5 pb-5 d-flex justify-content-center">
            <!-- Product Image Carousel -->
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src='<?php echo "../admin/" . ($data['HinhAnh'] ?? "default_image.jpg"); ?>' alt="Product Image">
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
            <h3 class="font-weight-semi-bold"><?php echo htmlspecialchars($data['TenSP']); ?></h3>
            <!-- Rating Stars -->
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    <?php for ($i = 0; $i < 5; $i++) {
                        if ($avg_star - $i >= 1) { ?>
                            <small class="fas fa-star"></small>
                        <?php } elseif ($avg_star - $i >= 0.5) { ?>
                            <small class="fas fa-star-half-alt"></small>
                        <?php } else { ?>
                            <small class="far fa-star"></small>
                        <?php } 
                    } ?>
                </div>
                <small class="pt-1">(<?php echo $total_reviews; ?> đánh giá)</small>
            </div>
            <h3 class="font-weight-semi-bold mb-4"><?php echo number_format($data['DonGia'], 0, '.', '.'); ?> vnđ</h3>
            <p class="mb-4">Mô tả: <?php echo ($data['MoTa']); ?></p>
            <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="number" class="form-control bg-secondary text-center" name="quantity" value="1" id="quantity-input-<?php echo $data['MaSP']; ?>" min="1">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <form action="cart.php" method="get" id="cartForm-<?php echo $data['MaSP']; ?>">
                    <input type="hidden" name="id" value="<?php echo $data['MaSP']; ?>">
                    <input type="hidden" name="quantity" value="1" id="quantity-<?php echo $data['MaSP']; ?>">
                    <button type="submit" class="btn btn-primary px-3">
                        <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ hàng
                    </button>
                </form>
            </div>
        </div>
    </div>

<!-- Product Description and Reviews Section -->
<div class="row px-xl-5">
    <div class="col">
        <div class="nav nav-tabs justify-content-center border-secondary mb-4">
            <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô tả</a>
            <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Đánh giá (<?php echo $total_reviews; ?>)</a>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-pane-1">
                <h4 class="mb-3">Mô tả sản phẩm</h4>
                <p><?php echo ($data['MoTa']); ?></p>
            </div>
            <div class="tab-pane fade" id="tab-pane-3">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-4"><?php echo $total_reviews; ?> đánh giá cho <?php echo htmlspecialchars($data['TenSP']); ?></h4>
                        <?php 
                        $sql_xemdg = "SELECT * FROM danhgia WHERE MaSP = ? LIMIT 10";
                        $stmt_reviews = $conn->prepare($sql_xemdg);
                        $stmt_reviews->bind_param('i', $idsp);
                        $stmt_reviews->execute();
                        $result_dg = $stmt_reviews->get_result();

                        if ($result_dg && $result_dg->num_rows > 0) {
                            while ($dg = $result_dg->fetch_assoc()) { ?>
                                <div class="media mb-4">
                                    <img src="img/user.png" alt="User Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6><?php echo htmlspecialchars($dg['TenDangNhap']); ?><small> - <i><?php echo $dg['NgayDG']; ?></i></small></h6>
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
                                        <p><?php echo htmlspecialchars($dg['NoiDung']); ?></p>
                                    </div>
                                </div>
                            <?php } 
                        } else { ?>
                            <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php } else { ?>
    <div class="container text-center"><p class="text-danger">Không tìm thấy sản phẩm.</p></div>
<?php } ?>
<?php include "./inc/footer.php"; ?>
