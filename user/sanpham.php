<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar.php"; ?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h2 align="center" style="padding: 30px 0;">SẢN PHẨM CỦA CỬA HÀNG</h2>
    </div>
</div>
<!-- Page Header End -->

<?php
include '../admin/connect.php';

$sql_xemsp = "SELECT * FROM san_pham WHERE so_luong >= 1";

// Xử lý lọc theo giá
$price_conditions = [];

if (isset($_GET['price-1'])) {
    $price_conditions[] = "DonGia < 5000000";
}
if (isset($_GET['price-2'])) {
    $price_conditions[] = "DonGia >= 5000000 AND DonGia <= 10000000";
}
if (isset($_GET['price-3'])) {
    $price_conditions[] = "DonGia >= 10000000 AND DonGia <= 20000000";
}
if (isset($_GET['price-4'])) {
    $price_conditions[] = "DonGia >= 20000000 AND DonGia <= 30000000";
}
if (isset($_GET['price-5'])) {
    $price_conditions[] = "DonGia > 30000000";
}

// Nếu có điều kiện lọc giá, thêm vào câu truy vấn SQL
if (!empty($price_conditions)) {
    $sql_xemsp .= " AND (" . implode(" OR ", $price_conditions) . ")";
}

// Xử lý tìm kiếm theo tên sản phẩm
if (isset($_GET['search'])) {
    $search_keyword = mysqli_real_escape_string($conn, $_GET['search']);
    $sql_xemsp .= " AND TenSP LIKE '%$search_keyword%'";
}

// Xử lý sắp xếp
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'MaSP'; // Mặc định sắp xếp theo MaSP nếu không có sắp xếp khác

switch ($sort) {
    case 'TenSP':
        $sql_xemsp .= " ORDER BY TenSP ASC";
        break;
    case 'DonGia':
        $sql_xemsp .= " ORDER BY DonGia ASC";
        break;
    case 'MaSP':
    default:
        $sql_xemsp .= " ORDER BY MaSP DESC"; // Mặc định sắp xếp theo MaSP giảm dần
        break;
}

// Thực hiện câu truy vấn để lấy số lượng sản phẩm thỏa mãn điều kiện
$count_query = "SELECT COUNT(*) AS total FROM san_pham WHERE so_luong >= 1";

if (!empty($price_conditions)) {
    $count_query .= " AND (" . implode(" OR ", $price_conditions) . ")";
}

if (isset($_GET['search'])) {
    $search_keyword = mysqli_real_escape_string($conn, $_GET['search']);
    $count_query .= " AND TenSP LIKE '%$search_keyword%'";
}

// Thực thi câu truy vấn và lấy số lượng kết quả
$count_result = mysqli_query($conn, $count_query);
$row = mysqli_fetch_assoc($count_result);
$number_of_result = $row['total'];

// Phân trang
$results_per_page = 9;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page_first_result = ($page - 1) * $results_per_page;
$query = $sql_xemsp . " LIMIT $page_first_result, $results_per_page";
$result = mysqli_query($conn, $query);
$number_of_page = ceil($number_of_result / $results_per_page);
?>

<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Price Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Lọc theo giá</h5>
                <form method="get">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price-all" id="price-all" checked>
                        <label class="custom-control-label" for="price-all">Tất cả</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price-1" id="price-1">
                        <label class="custom-control-label" for="price-1">Dưới 5.000.000</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price-2" id="price-2">
                        <label class="custom-control-label" for="price-2">5.000.000-10.000.000</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price-3" id="price-3">
                        <label class="custom-control-label" for="price-3">10.000.000-20.000.000</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price-4" id="price-4">
                        <label class="custom-control-label" for="price-4">20.000.000-30.000.000</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-control-input" name="price-5" id="price-5">
                        <label class="custom-control-label" for="price-5">Trên 30.000.000</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Lọc</button>
                </form>
            </div>
            <!-- Price End -->
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-12">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <form action="" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm theo tên">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>  
                        </form>
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                Sắp xếp theo
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="sanpham.php?sort=TenSP&page=1">Tên sản phẩm</a>
                                <a class="dropdown-item" href="sanpham.php?sort=DonGia&page=1">Đơn giá</a>
                                <a class="dropdown-item" href="sanpham.php?sort=MaSP&page=1">Mới nhất</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php while ($data2 = mysqli_fetch_array($result)) { ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100" src='<?php echo "../admin/".$data2['HinhAnh'] ?>' alt="">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3"><?php echo $data2['TenSP']; ?></h6>
                                <div class="d-flex justify-content-center">
                                    <h6><?php echo number_format($data2['DonGia'], 0, '.', '.'); ?> vnđ</h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="chitietsp.php?id=<?php echo $data2['MaSP']; ?>" class="btn btn-sm text-dark p-0">
                                    <i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết
                                </a>
                                <div class="input-group quantity mr-3" style="width: 130px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-minus" type="button" onclick="decreaseQuantity(<?php echo $data2['MaSP']; ?>)">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control bg-secondary text-center" name="quantity" id="quantity-<?php echo $data2['MaSP']; ?>" value="1" readonly>
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-plus" type="button" onclick="increaseQuantity(<?php echo $data2['MaSP']; ?>)">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <form action="cart.php" method="get" id="cartForm-<?php echo $data2['MaSP']; ?>">
                                    <input type="hidden" name="id" value="<?php echo $data2['MaSP']; ?>">
                                    <input type="hidden" name="quantity" id="hidden-quantity-<?php echo $data2['MaSP']; ?>" value="1">
                                    <button type="submit" class="btn btn-sm text-dark p-0">
                                        <i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ hàng
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Pagination Start -->
            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php for ($page = 1; $page <= $number_of_page; $page++) { ?>
                            <li class="page-item"><a class="page-link" href="sanpham.php?page=<?php echo $page; ?>"><?php echo $page; ?></a></li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
            <!-- Pagination End -->
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->

<script>
    // JavaScript functions for increasing and decreasing the quantity
    function increaseQuantity(productId) {
        let quantityInput = document.getElementById('quantity-' + productId);
        let hiddenQuantityInput = document.getElementById('hidden-quantity-' + productId);
        let currentQuantity = parseInt(quantityInput.value);
        quantityInput.value = currentQuantity + 1;
        hiddenQuantityInput.value = currentQuantity + 1;  // Update hidden input for form submission
    }

    function decreaseQuantity(productId) {
        let quantityInput = document.getElementById('quantity-' + productId);
        let hiddenQuantityInput = document.getElementById('hidden-quantity-' + productId);
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > 1) {
            quantityInput.value = currentQuantity - 1;
            hiddenQuantityInput.value = currentQuantity - 1;  // Update hidden input for form submission
        }
    }
</script>
<?php include "./chatbot/chatbot.php"; ?>
<?php include "./inc/footer.php"; ?>
