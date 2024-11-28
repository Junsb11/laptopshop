<?php
include "./inc/header.php";
include "./inc/navbar.php";

// Xử lý lấy danh mục từ URL
$madm = $_GET['madm'] ?? null;

// Kết nối CSDL
include '../admin/connect.php';

// Thiết lập các tham số phân trang
$page = $_GET['page'] ?? 1;
$results_per_page = 9;
$page_first_result = ($page - 1) * $results_per_page;

// Xử lý lấy sản phẩm từ CSDL với điều kiện phân trang
$sql_xemsp = "SELECT * FROM san_pham WHERE TrangThai = 1 AND so_luong >=1 AND MaDM = '$madm'";

// Xử lý lọc theo giá
if (isset($_GET['price_range']) && !empty($_GET['price_range'])) {
    $price_ranges = $_GET['price_range'];
    $where_clauses = [];

    // Kiểm tra nếu 'all' được chọn, bỏ qua việc thêm điều kiện lọc giá
    if (!in_array('all', $price_ranges)) {
        foreach ($price_ranges as $range) {
            switch ($range) {
                case '1':
                    $where_clauses[] = "DonGia < 5000000";
                    break;
                case '2':
                    $where_clauses[] = "DonGia BETWEEN 5000000 AND 10000000";
                    break;
                case '3':
                    $where_clauses[] = "DonGia BETWEEN 10000000 AND 20000000";
                    break;
                case '4':
                    $where_clauses[] = "DonGia BETWEEN 20000000 AND 30000000";
                    break;
                case '5':
                    $where_clauses[] = "DonGia > 30000000";
                    break;
                default:
                    break;
            }
        }
        $sql_xemsp .= " AND (" . implode(' OR ', $where_clauses) . ")";
    }
}

// Xử lý tìm kiếm theo tên sản phẩm
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $_GET['search'];
    // Thêm điều kiện tìm kiếm vào câu truy vấn
    $sql_xemsp .= " AND TenSP LIKE '%$search_term%'";
}

// Xử lý sắp xếp
if (isset($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'TenSP':
            $sql_xemsp .= ' ORDER BY TenSP';
            break;
        case 'DonGia':
            $sql_xemsp .= ' ORDER BY DonGia';
            break;
        case 'MaSP':
            $sql_xemsp .= ' ORDER BY MaSP DESC'; // Sắp xếp theo Mã sản phẩm mới nhất
            break;
        default:
            break;
    }
}

// Số lượng sản phẩm
$sql_count = "SELECT COUNT(*) AS total FROM san_pham WHERE TrangThai = 1 AND so_luong >=1 AND MaDM = '$madm'";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $results_per_page);

// Lấy dữ liệu sản phẩm với limit và offset
$sql_xemsp .= " LIMIT $page_first_result, $results_per_page";
$result_sp = mysqli_query($conn, $sql_xemsp);

?>

<!-- Page Header -->
<div class="container-fluid bg-secondary mb-5">
    <h2 align="center" style="padding: 30px 0;">
        <?php
        // Lấy tên danh mục từ database để hiển thị
        $sql_danhmuc = "SELECT TenDM FROM danh_muc WHERE MaDM = '$madm'";
        $result_danhmuc = mysqli_query($conn, $sql_danhmuc);
        $row_danhmuc = mysqli_fetch_assoc($result_danhmuc);
        echo $row_danhmuc['TenDM'];
        ?>
    </h2>
</div>

<!-- Product Listing -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-12">
            <!-- Price Filter -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Lọc theo giá</h5>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                    <input type="hidden" name="madm" value="<?php echo $madm; ?>">
                    <input type="hidden" name="search" value="<?php echo $_GET['search'] ?? ''; ?>">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price_range[]" id="price-all"
                            value="all" <?php echo (empty($_GET['price_range']) || in_array('all', $_GET['price_range'])) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="price-all">Tất cả</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price_range[]" id="price-1" value="1"
                            <?php echo (isset($_GET['price_range']) && in_array('1', $_GET['price_range'])) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="price-1">Dưới 5.000.000 VNĐ</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price_range[]" id="price-2" value="2"
                            <?php echo (isset($_GET['price_range']) && in_array('2', $_GET['price_range'])) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="price-2">5.000.000 - 10.000.000 VNĐ</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price_range[]" id="price-3" value="3"
                            <?php echo (isset($_GET['price_range']) && in_array('3', $_GET['price_range'])) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="price-3">10.000.000 - 20.000.000 VNĐ</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price_range[]" id="price-4" value="4"
                            <?php echo (isset($_GET['price_range']) && in_array('4', $_GET['price_range'])) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="price-4">20.000.000 - 30.000.000 VNĐ</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-control-input" name="price_range[]" id="price-5" value="5"
                            <?php echo (isset($_GET['price_range']) && in_array('5', $_GET['price_range'])) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="price-5">Trên 30.000.000 VNĐ</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Lọc</button>
                </form>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Product Listing -->
        <div class="col-lg-9 col-md-12">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" class="form-inline mt-3 mb-3">
                            <input type="hidden" name="madm" value="<?php echo $madm; ?>">
                            <div class="form-group mr-2">
                                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm sản phẩm">
                            </div>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </form>

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="sortDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sắp xếp
                            </button>
                            <div class="dropdown-menu" aria-labelledby="sortDropdown">
                                <a class="dropdown-item"
                                    href="<?php echo $_SERVER['PHP_SELF'] . '?madm=' . $madm . '&sort=TenSP&page=1'; ?>">Tên
                                    sản phẩm</a>
                                <a class="dropdown-item"
                                    href="<?php echo $_SERVER['PHP_SELF'] . '?madm=' . $madm . '&sort=DonGia&page=1'; ?>">Đơn
                                    giá</a>
                                <a class="dropdown-item"
                                    href="<?php echo $_SERVER['PHP_SELF'] . '?madm=' . $madm . '&sort=MaSP&page=1'; ?>">Mới
                                    nhất</a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php while ($data2 = mysqli_fetch_array($result_sp)): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div
                                class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100" src="<?php echo "../admin/" . $data2['HinhAnh']; ?>" alt="">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3"><?php echo $data2['TenSP']; ?></h6>
                                <div class="d-flex justify-content-center">
                                    <h6><?php echo number_format($data2['DonGia'], 0, '.', '.'); ?> vnđ</h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="chitietsp.php?id=<?php echo $data['MaSP']; ?>" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết
                        </a>
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary text-center" name="quantity" value="1" readonly>
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus" data-so-luong="<?php echo $data['so_luong']; ?>">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <form action="cart.php" method="get" id="cartForm-<?php echo $data['MaSP']; ?>">
                            <input type="hidden" name="id" value="<?php echo $data['MaSP']; ?>">
                            <input type="hidden" name="quantity" value="1" id="quantity-<?php echo $data['MaSP']; ?>">
                            <button type="submit" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ hàng
                            </button>
                        </form>
                    </div>
                        </div>
                    </div>
                <?php endwhile; ?>

                <!-- Pagination Start -->
                <div class="col-12 pb-1">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-3">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="<?php echo $_SERVER['PHP_SELF'] . '?madm=' . $madm . '&' . http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>"
                                        aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                    <a class="page-link"
                                        href="<?php echo $_SERVER['PHP_SELF'] . '?madm=' . $madm . '&' . http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="<?php echo $_SERVER['PHP_SELF'] . '?madm=' . $madm . '&' . http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>"
                                        aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <!-- Pagination End -->

            </div>
        </div>
        <!-- End Product Listing -->
    </div>
</div>
<!-- End Product -->

<?php include "./inc/footer.php"; ?>
