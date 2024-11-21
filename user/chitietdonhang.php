<?php
include "../admin/connect.php";

// Bắt đầu session nếu chưa tồn tại
if (!isset($_SESSION)) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa, nếu chưa thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit(); // Thoát khỏi script sau khi chuyển hướng
}

// Lấy tên đăng nhập từ session
$tendn = $_SESSION['tendn'];

// Lấy mã hóa đơn từ GET parameter
$mahd = $_GET['mahd'];

// Truy vấn chi tiết hóa đơn
$sql_xemhd = "SELECT s.TenSP, s.HinhAnh, c.SoLuongMua, s.DonGia, c.TyLeKM, s.DonGia * c.SoLuongMua AS ThanhTien 
              FROM san_pham s, danh_muc d, chi_tiet_hoa_don c 
              WHERE s.MaDM = d.MaDM AND s.MaSP = c.MaSP AND c.MaHD = '$mahd'";
$result_hd = mysqli_query($conn, $sql_xemhd);

// Truy vấn để đếm số lượng đơn hàng theo trạng thái
$count_choxacnhan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM hoa_don WHERE TrangThai = 0 AND TenDangNhap = '$tendn'"));
$count_danggiao = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM hoa_don WHERE TrangThai = 1 AND TenDangNhap = '$tendn'"));
$count_dagiao = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM hoa_don WHERE TrangThai = 2 AND TenDangNhap = '$tendn'"));
$count_dahuy = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM hoa_don WHERE TrangThai = 3 AND TenDangNhap = '$tendn'"));
?>

<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar.php"; ?>

<style>
    .fixed-sidebar {
        position: fixed;
        top: 200px; /* Adjust this value based on your header height */
        width: 350px; /* Adjust width as necessary */
        padding: 20px;
    }
    .content {
        margin-left: 350px; /* Adjust this value based on the fixed sidebar width */
        padding: 20px;
		margin-bottom: 180px;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3 fixed-sidebar">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tình trạng đơn hàng</h4>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'choxacnhan') ? 'active' : ''; ?>">
                            <a href="dsdonhang.php?loai=choxacnhan">Đơn hàng chờ xác nhận</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_choxacnhan; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'danggiao') ? 'active' : ''; ?>">
                            <a href="dsdonhang.php?loai=danggiao">Đơn hàng đang giao</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_danggiao; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'dagiao') ? 'active' : ''; ?>">
                            <a href="dsdonhang.php?loai=dagiao">Đơn hàng đã giao</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_dagiao; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'dahuy') ? 'active' : ''; ?>">
                            <a href="dsdonhang.php?loai=dahuy">Đơn hàng đã hủy</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_dahuy; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 content">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Chi tiết HD<?php echo $mahd ?></h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Sản Phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Khuyến mãi</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stt = 1;
                                while ($data = mysqli_fetch_array($result_hd)) {
                                ?>
                                    <tr>
                                        <td><?php echo $stt++; ?></td>
                                        <td><?php echo $data['TenSP']; ?> <img src='<?php echo "../admin/".$data['HinhAnh'] ?>' alt="" style="width: 50px;"></td>
                                        <td><?php echo $data['SoLuongMua']; ?></td>
                                        <td><?php echo number_format($data['DonGia'], 0, '.', '.'); ?></td>
                                        <td><?php echo $data['TyLeKM']; ?>%</td>
                                        <td><?php echo number_format($data['ThanhTien'], 0, '.', '.'); ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (mysqli_num_rows($result_hd) == 0) { ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Không có sản phẩm nào trong đơn hàng này.</td>    
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "./inc/footer.php"; ?>
