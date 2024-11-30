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

// Kiểm tra ID sản phẩm
$idsp = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$idsp) {
    echo "<div class='container text-center'><p class='text-danger'>ID sản phẩm không hợp lệ.</p></div>";
    exit;
}

// Truy vấn chi tiết sản phẩm
$sql_chitietsp = "SELECT *, AVG(SoSao) as Sao, COUNT(d.SoSao) as Dem FROM san_pham s LEFT JOIN danhgia d ON s.MaSP = d.MaSP WHERE s.MaSP = ?";
$stmt = $conn->prepare($sql_chitietsp);
$stmt->bind_param('i', $idsp);
$stmt->execute();
$result_chitietsp = $stmt->get_result();

if ($result_chitietsp && $result_chitietsp->num_rows > 0) {
    $data = $result_chitietsp->fetch_assoc();
?>

<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <div class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src='<?php echo "../admin/" . $data['HinhAnh']; ?>' alt="Image">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold"><?php echo htmlspecialchars($data['TenSP']); ?></h3>
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    <?php for ($i = 0; $i < 5; $i++) {
                        echo ($data['Sao'] - $i >= 1) ? '<small class="fas fa-star"></small>' : 
                             (($data['Sao'] - $i >= 0.5) ? '<small class="fas fa-star-half-alt"></small>' : '<small class="far fa-star"></small>');
                    } ?>
                </div>
                <small class="pt-1">(<?php echo $data['Dem']; ?> đánh giá)</small>
            </div>
            <h3 class="font-weight-semi-bold mb-4"><?php echo number_format($data['DonGia'], 0, '.', '.'); ?> vnđ</h3>
            <p class="mb-4"><?php echo htmlspecialchars($data['MoTa']); ?></p>
            
            <!-- Form thêm vào giỏ hàng -->
            <form action="cart.php" method="get" id="cartForm-<?php echo $data['MaSP']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['MaSP']; ?>">
                <div class="d-flex align-items-center mb-4">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <button class="btn btn-primary btn-minus" type="button">-</button>
                        <input type="number" class="form-control bg-secondary text-center" name="quantity" value="1" min="1">
                        <button class="btn btn-primary btn-plus" type="button">+</button>
                    </div>
                    <button type="submit" class="btn btn-primary px-3">
                        <i class="fa fa-shopping-cart mr-1"></i> Thêm vào giỏ hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Tăng giảm số lượng
    $('.btn-plus').click(function() {
        let input = $(this).siblings('input[name="quantity"]');
        input.val(parseInt(input.val()) + 1);
    });
    $('.btn-minus').click(function() {
        let input = $(this).siblings('input[name="quantity"]');
        if (parseInt(input.val()) > 1) {
            input.val(parseInt(input.val()) - 1);
        }
    });
});
</script>

<?php
} else {
    echo "<div class='container text-center'><p class='text-danger'>Không tìm thấy sản phẩm.</p></div>";
}
?>

<?php include "./chatbot/chatbot.php"; ?>
<?php include "./inc/footer.php"; ?>
