<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar_slide.php"; ?>
<?php
include '../admin/connect.php';

function displayProducts($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_array($result)) {
            ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src='<?php echo "../admin/" . htmlspecialchars($data['HinhAnh']); ?>' alt="Image">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo htmlspecialchars($data['TenSP']); ?></h6>
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
            <?php
        }
    } else {
        echo "<p>Không có sản phẩm nào được tìm thấy.</p>";
    }
}

// Truy vấn sản phẩm mới
$sql_xemsp = "SELECT * FROM san_pham WHERE TrangThai=1 AND so_luong >= 1 LIMIT 0,8";
$result_sp = mysqli_query($conn, $sql_xemsp);

// Kiểm tra kết quả truy vấn sản phẩm mới
if (!$result_sp) {
    echo "Lỗi khi truy vấn dữ liệu: " . mysqli_error($conn);
    exit();
}

// Truy vấn sản phẩm bán chạy
$sql_xemsp_banchay = "SELECT * FROM san_pham WHERE TrangThai=1 AND so_luong >= 1 LIMIT 0,8";
$result_sp_banchay = mysqli_query($conn, $sql_xemsp_banchay);

// Kiểm tra kết quả truy vấn sản phẩm bán chạy
if (!$result_sp_banchay) {
    echo "Lỗi khi truy vấn dữ liệu: " . mysqli_error($conn);
    exit();
}
?>

<!-- Hiển thị sản phẩm mới -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Sản phẩm mới</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        <?php displayProducts($result_sp); ?>
    </div>
</div>

<!-- Hiển thị sản phẩm bán chạy -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Sản phẩm bán chạy</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        <?php displayProducts($result_sp_banchay); ?>
    </div>
</div>

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