<?php
include "../admin/connect.php";

// Bắt đầu session nếu chưa tồn tại
if (!isset($_SESSION)) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit();
}

// Lấy tên đăng nhập từ session
$tendn = $_SESSION['tendn'];

// Kiểm tra mã hóa đơn
if (!isset($_GET['mahd']) || empty($_GET['mahd'])) {
    die("Mã hóa đơn không hợp lệ.");
}
$mahd = mysqli_real_escape_string($conn, $_GET['mahd']);

// Truy vấn để xác nhận hóa đơn thuộc về khách hàng đăng nhập
$sql_check_hd = "SELECT * FROM hoa_don WHERE MaHD = '$mahd' AND TenDangNhap = '$tendn'";
$result_check_hd = mysqli_query($conn, $sql_check_hd);

if (mysqli_num_rows($result_check_hd) == 0) {
    die("Bạn không có quyền xem chi tiết hóa đơn này.");
}

// Truy vấn chi tiết hóa đơn
$sql_xemhd = "SELECT s.TenSP, s.HinhAnh, c.SoLuongMua, s.DonGia, c.TyLeKM, 
                     (s.DonGia * c.SoLuongMua * (1 - c.TyLeKM / 100)) AS ThanhTien 
              FROM san_pham s 
              JOIN chi_tiet_hoa_don c ON s.MaSP = c.MaSP 
              WHERE c.MaHD = '$mahd'";
$result_hd = mysqli_query($conn, $sql_xemhd);
?>

<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar.php"; ?>

<div class="container mt-5">
    <h4 class="mb-4">Chi tiết đơn hàng: HD<?php echo $mahd; ?></h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Khuyến mãi (%)</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stt = 1;
                $tongtien = 0;
                while ($data = mysqli_fetch_assoc($result_hd)) {
                    $tongtien += $data['ThanhTien'];
                ?>
                    <tr>
                        <td><?php echo $stt++; ?></td>
                        <td><?php echo $data['TenSP']; ?></td>
                        <td><img src="../admin/<?php echo $data['HinhAnh']; ?>" alt="" style="width: 50px;"></td>
                        <td><?php echo $data['SoLuongMua']; ?></td>
                        <td><?php echo number_format($data['DonGia'], 0, '.', ','); ?> đ</td>
                        <td><?php echo $data['TyLeKM']; ?></td>
                        <td><?php echo number_format($data['ThanhTien'], 0, '.', ','); ?> đ</td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="6" class="text-right"><strong>Tổng tiền:</strong></td>
                    <td><strong><?php echo number_format($tongtien, 0, '.', ','); ?> đ</strong></td>
                </tr>
                <?php if (mysqli_num_rows($result_hd) == 0) { ?>
                    <tr>
                        <td colspan="7" class="text-center">Không có sản phẩm nào trong đơn hàng này.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Nút quay lại danh sách đơn hàng -->
    <div class="text-center mt-4">
        <a href="dsdonhang.php" class="btn btn-primary">Quay lại danh sách đơn hàng</a>
    </div>
</div>

<?php include "./inc/footer.php"; ?>
