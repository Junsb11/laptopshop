<?php
include "./inc/header.php";
include "./inc/navbar.php";

// Kết nối CSDL
include '../admin/connect.php';

// Lấy mã danh mục từ URL
$madm = $_GET['madm'] ?? null;

// Thiết lập phân trang
$page = $_GET['page'] ?? 1;
$results_per_page = 9;
$page_first_result = ($page - 1) * $results_per_page;

// Bắt đầu câu truy vấn sản phẩm
$sql_xemsp = "SELECT * FROM san_pham WHERE TrangThai = 1 AND so_luong >= 1 AND MaDM = '$madm'";

// Lọc theo giá
if (isset($_GET['price_range']) && !empty($_GET['price_range'])) {
    $price_ranges = $_GET['price_range'];
    $where_clauses = [];

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

// Tìm kiếm sản phẩm theo tên
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $_GET['search'];
    $sql_xemsp .= " AND TenSP LIKE '%$search_term%'";
}

// Sắp xếp sản phẩm
if (isset($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'TenSP':
            $sql_xemsp .= ' ORDER BY TenSP';
            break;
        case 'DonGia':
            $sql_xemsp .= ' ORDER BY DonGia';
            break;
        case 'MaSP':
            $sql_xemsp .= ' ORDER BY MaSP DESC'; // Sắp xếp theo mã sản phẩm mới nhất
            break;
        default:
            break;
    }
}

// Lấy tổng số sản phẩm
$sql_count = "SELECT COUNT(*) AS total FROM san_pham WHERE TrangThai = 1 AND so_luong >= 1 AND MaDM = '$madm'";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $results_per_page);

// Lấy dữ liệu sản phẩm với phân trang
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
                            value="all" <?php echo (empty($_GET['price_range']) || in_array('all', $_GET['price_range'])) ? 'checked' : ''; ?> />
                        <label class="custom-control-label" for="price-all">Tất cả</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price_range[]" id="price-1" value="1"
                            <?php echo (isset($_GET['price_range']) && in_array('1', $_GET['price_range'])) ? 'checked' : ''; ?> />
                        <label class="custom-control-label" for="price-1">Dưới 5.000.000 VNĐ</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price_range[]" id="price-2" value="2"
                            <?php echo (isset($_GET['price_range']) && in_array('2', $_GET['price_range'])) ? 'checked' : ''; ?> />
                        <label class="custom-control-label" for="price-2">5.000.000 - 10.000.000 VNĐ</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price_range[]" id="price-3" value="3"
                            <?php echo (isset($_GET['price_range']) && in_array('3', $_GET['price_range'])) ? 'checked' : ''; ?> />
                        <label class="custom-control-label" for="price-3">10.000.000 - 20.000.000 VNĐ</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price_range[]" id="price-4" value="4"
                            <?php echo (isset($_GET['price_range']) && in_array('4', $_GET['price_range'])) ? 'checked' : ''; ?> />
                        <label class="custom-control-label" for="price-4">20.000.000 - 30.000.000 VNĐ</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-control-input" name="price_range[]" id="price-5" value="5"
                            <?php echo (isset($_GET['price_range']) && in_array('5', $_GET['price_range'])) ? 'checked' : ''; ?> />
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
                                    href="<?php echo $_SERVER['PHP_SELF'] . '?madm=' . $madm . '&sort=TenSP&page=1'; ?>">Tên sản phẩm</a>
                                <a class="dropdown-item"
                                    href="<?php echo $_SERVER['PHP_SELF'] . '?madm=' . $madm . '&sort=DonGia&page=1'; ?>">Giá</a>
                                <a class="dropdown-item"
                                    href="<?php echo $_SERVER['PHP_SELF'] . '?madm=' . $madm . '&sort=MaSP&page=1'; ?>">Mã sản phẩm</a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php while ($data2 = mysqli_fetch_assoc($result_sp)) { ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card border-0 shadow-sm mb-3">
                    <img class="img-fluid w-100" src="<?php echo "../admin/" . $data2['HinhAnh']; ?>" alt="">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $data2['TenSP']; ?></h5>
                            <p class="card-text"><?php echo number_format($data2['DonGia'], 0, ',', '.') . " VNĐ"; ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="chitietsp.php?id=<?php echo $data2['MaSP']; ?>" class="btn btn-sm text-dark p-0">
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
                                    <button class="btn btn-primary btn-plus" data-so-luong="<?php echo $data2['so_luong']; ?>">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <form action="cart.php" method="get" id="cartForm-<?php echo $data2['MaSP']; ?>">
                                <input type="hidden" name="id" value="<?php echo $data2['MaSP']; ?>">
                                <input type="hidden" name="quantity" value="1" id="quantity-<?php echo $data2['MaSP']; ?>">
                                <button type="submit" class="btn btn-sm text-dark p-0">
                                    <i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ hàng
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Pagination -->
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                            <li class="page-item"><a class="page-link" href="?madm=<?php echo $madm; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "./inc/footer.php"; ?>
