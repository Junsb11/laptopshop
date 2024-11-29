<?php 
include "./inc/header.php"; 
if (!isset($_SESSION)) {
    session_start(); 
}
include "./inc/navbar.php"; 
?>

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

// Get product ID
$idsp = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$idsp) {
    echo "ID sản phẩm không hợp lệ.";
    exit;
}

// Query product details and average ratings
$sql_chitietsp = "SELECT *, AVG(SoSao) as Sao, COUNT(d.SoSao) as Dem FROM san_pham s LEFT JOIN danhgia d ON s.MaSP = d.MaSP WHERE s.MaSP = ?";
$stmt = $conn->prepare($sql_chitietsp);
$stmt->bind_param('i', $idsp);
$stmt->execute();
$result_chitietsp = $stmt->get_result();

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
                <form action="cart.php" method="get" id="cartForm" action="cart.php" method="get">
                    <input type="hidden" name="id" value="<?php echo $data['MaSP']; ?>">
                    <input type="hidden" name="quantity" value="1" id="quantity_input">
                    <button type="submit" class="btn btn-primary px-3">
                        <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ hàng
                    </button>
                </form>
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
                // Fetch reviews
                $sql_xemdg = "SELECT * FROM danhgia WHERE MaSP = ?";
                $stmt_reviews = $conn->prepare($sql_xemdg);
                $stmt_reviews->bind_param('i', $idsp);
                $stmt_reviews->execute();
                $result_dg = $stmt_reviews->get_result();
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    }
} else {
    echo "Không tìm thấy sản phẩm.";
}
?>
<!-- JavaScript xử lý tăng giảm số lượng sản phẩm -->
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

    // Submit form sử dụng AJAX
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
                // Cập nhật giỏ hàng nếu cần
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