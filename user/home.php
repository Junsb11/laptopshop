<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar_slide.php"; ?>
<?php
    include '../admin/connect.php';

    // Hàm lấy danh sách sản phẩm
    function getProducts($conn, $limit = 8) {
        $stmt = $conn->prepare("SELECT MaSP, TenSP, DonGia, HinhAnh FROM san_pham WHERE TrangThai = 1 LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Lấy danh sách sản phẩm mới
    $products_new = getProducts($conn);

    // Lấy danh sách sản phẩm bán chạy
    $products_bestsellers = getProducts($conn);
?>
<div class="container-fluid pt-5">
    <!-- Sản phẩm mới -->
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Sản phẩm mới</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        <?php while ($product = $products_new->fetch_assoc()) { ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src='<?php echo "../admin/" . $product['HinhAnh']; ?>' alt="Product Image">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo $product['TenSP']; ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php echo number_format($product['DonGia'], 0, '.', '.'); ?> vnđ</h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="chitietsp.php?id=<?php echo $product['MaSP']; ?>" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết
                        </a>
                        <a href="cart.php?id=<?php echo $product['MaSP']; ?>" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ hàng
                        </a>
                        <a href="warranty_request.php?id=<?php echo $product['MaSP']; ?>" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-tools text-primary mr-1"></i>Yêu cầu bảo hành
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div class="container-fluid pt-5">
    <!-- Sản phẩm bán chạy -->
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Sản phẩm bán chạy</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        <?php while ($product = $products_bestsellers->fetch_assoc()) { ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src='<?php echo "../admin/" . $product['HinhAnh']; ?>' alt="Product Image">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo $product['TenSP']; ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php echo number_format($product['DonGia'], 0, '.', '.'); ?> vnđ</h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="chitietsp.php?id=<?php echo $product['MaSP']; ?>" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết
                        </a>
                        <a href="cart.php?id=<?php echo $product['MaSP']; ?>" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ hàng
                        </a>
                        <a href="yeucaubaohanh.php?id=<?php echo $product['MaSP']; ?>" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-tools text-primary mr-1"></i>Yêu cầu bảo hành
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include "./inc/footer.php"; ?>
