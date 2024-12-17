<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar.php"; ?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h2 align="center" style="padding: 30px 0;">
            <?php
            $key = isset($_GET['txtsearch']) ? mysqli_real_escape_string($conn, $_GET['txtsearch']) : '';
            echo !empty($key) ? "Tìm kiếm sản phẩm '" . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . "'" : "Tìm kiếm sản phẩm";
            ?>
        </h2>
    </div>
</div>
<!-- Page Header End -->

<?php
include '../admin/connect.php';

$price_conditions = [];
if (isset($_GET['price-1'])) $price_conditions[] = "DonGia < 5000000";
if (isset($_GET['price-2'])) $price_conditions[] = "DonGia BETWEEN 5000000 AND 10000000";
if (isset($_GET['price-3'])) $price_conditions[] = "DonGia BETWEEN 10000000 AND 20000000";
if (isset($_GET['price-4'])) $price_conditions[] = "DonGia BETWEEN 20000000 AND 30000000";
if (isset($_GET['price-5'])) $price_conditions[] = "DonGia > 30000000";

$sql_xemsp = "SELECT * FROM san_pham WHERE TenSP LIKE '%$key%'";
if (!empty($price_conditions)) {
    $sql_xemsp .= " AND (" . implode(" OR ", $price_conditions) . ")";
}

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'MaSP';
switch ($sort) {
    case 'TenSP':
        $sql_xemsp .= " ORDER BY TenSP ASC";
        break;
    case 'DonGia':
        $sql_xemsp .= " ORDER BY DonGia ASC";
        break;
    case 'MaSP':
    default:
        $sql_xemsp .= " ORDER BY MaSP DESC";
        break;
}

$count_query = "SELECT COUNT(*) AS total FROM san_pham WHERE TenSP LIKE '%$key%'";
if (!empty($price_conditions)) {
    $count_query .= " AND (" . implode(" OR ", $price_conditions) . ")";
}

$count_result = mysqli_query($conn, $count_query);
$row = mysqli_fetch_assoc($count_result);
$number_of_result = $row['total'];

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
                    <input type="hidden" name="txtsearch" value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort, ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price-all" id="price-all" checked>
                        <label class="custom-control-label" for="price-all">Tất cả</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" name="price-1" id="price-1">
                        <label class="custom-control-label" for="price-1">Dưới 5.000.000</label>
                    </div>
                    <!-- Add other price range checkboxes similarly -->
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
                                <input type="text" class="form-control" name="txtsearch" placeholder="Tìm kiếm theo tên" value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort, ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit" name="btnsearch"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                Sắp xếp theo
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="timkiemsanpham.php?sort=TenSP&page=1&txtsearch=<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>">Tên sản phẩm</a>
                                <a class="dropdown-item" href="timkiemsanpham.php?sort=DonGia&page=1&txtsearch=<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>">Đơn giá</a>
                                <a class="dropdown-item" href="timkiemsanpham.php?sort=MaSP&page=1&txtsearch=<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>">Mới nhất</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php while ($data = mysqli_fetch_array($result)) { ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100" src='<?php echo "../admin/".$data['HinhAnh'] ?>' alt="">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3"><?php echo $data['TenSP']; ?></h6>
                                <div class="d-flex justify-content-center">
                                    <h6><?php echo number_format($data['DonGia'], 0, '.', '.'); ?> vnđ</h6>
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
                <?php } ?>
                <div class="col-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php
                            for ($page = 1; $page <= $number_of_page; $page++) {
                                echo '<li class="page-item"><a class="page-link" href="sanpham.php?page=' . $page . '&sort=' . $sort . '&txtsearch=' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '">' . $page . '</a></li>';
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on('click', '.btn-plus', function(e) {
        e.preventDefault();
        var input = $(this).closest('.input-group').find('input[name="quantity"]');
        var quantity = parseInt(input.val());
        var so_luong = parseInt($(this).data('so-luong'));

        if (quantity < so_luong && so_luong >= 1) {
            input.val(quantity + 1);
            updateCartFormQuantity($(this), quantity + 1);
        } else {
            alert('Số lượng sản phẩm hiện có trong kho là: ' + so_luong);
        }
    });

    $(document).on('click', '.btn-minus', function(e) {
        e.preventDefault();
        var input = $(this).closest('.input-group').find('input[name="quantity"]');
        var quantity = parseInt(input.val());

        if (quantity > 1) {
            input.val(quantity - 1);
            updateCartFormQuantity($(this), quantity - 1);
        }
    });

    function updateCartFormQuantity(button, quantity) {
        var form = button.closest('.card-footer').find('form');
        form.find('input[name="quantity"]').val(quantity);
    }

    $('#cartForm-<?php echo $data['MaSP']; ?>').submit(function(e) {
        e.preventDefault();
        var quantity = $('#quantity-<?php echo $data['MaSP']; ?>').val();
        var product_id = $(this).find('input[name="id"]').val();

        $.ajax({
            type: "GET",
            url: "cart.php",
            data: { id: product_id, quantity: quantity },
            success: function(response) {
                alert('Sản phẩm đã được thêm vào giỏ hàng!');
            },
            error: function() {
                alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
            }
        });
    });
});
</script>

<?php include "./chatbot/chatbot.php"; ?>
<?php include "./inc/footer.php"; ?>
