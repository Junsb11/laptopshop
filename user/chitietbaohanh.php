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

// Truy vấn lịch sử bảo hành của tất cả các sản phẩm của người dùng
$sql_lishsu_baohanh = "
    SELECT 
        s.TenSP, s.HinhAnh, b.MaBH, b.LyDo, b.NgayYeuCau, b.NgayKetThuc, 
        bhct.SoLuongMua, bhct.DonGia
    FROM 
        bao_hanh b
    JOIN 
        chi_tiet_bao_hanh bhct ON b.MaBH = bhct.MaBH
    JOIN 
        san_pham s ON b.MaSP = s.MaSP  -- Liên kết đúng giữa bao_hanh và san_pham qua MaSP
    JOIN 
        hoa_don h ON h.MaHD = bhct.MaHD
    WHERE 
        h.TenDangNhap = '$tendn'
";
$result_baohanh = mysqli_query($conn, $sql_lishsu_baohanh);

// Truy vấn để đếm số lượng đơn hàng theo trạng thái
$count_choxacnhan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai = 0 AND TenDangNhap = '$tendn'"));
$count_danggiao = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai = 1 AND TenDangNhap = '$tendn'"));
$count_dagiao = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai = 2 AND TenDangNhap = '$tendn'"));
$count_dahuy = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai = 3 AND TenDangNhap = '$tendn'"));
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
                            <a href="dsdonhang.php?loai=choxacnhan">Đơn chờ xác nhận</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_choxacnhan; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'danggiao') ? 'active' : ''; ?>">
                            <a href="dsdonhang.php?loai=danggiao">Đơn đang xử lý</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_danggiao; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'dagiao') ? 'active' : ''; ?>">
                            <a href="dsdonhang.php?loai=dagiao">Đơn đã xử lý</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_dagiao; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'dahuy') ? 'active' : ''; ?>">
                            <a href="dsdonhang.php?loai=dahuy">Đơn đã hủy</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_dahuy; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9 content">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Lịch sử bảo hành</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Sản Phẩm</th>
                                    <th>Nội dung bảo hành</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result_baohanh) > 0) {
                                    $stt = 1;
                                    while ($data = mysqli_fetch_array($result_baohanh)) {
                                ?>
                                    <tr>
                                        <td><?php echo $stt++; ?></td>
                                        <td><?php echo $data['TenSP']; ?> <img src='<?php echo "../admin/".$data['HinhAnh'] ?>' alt="" style="width: 50px;"></td>
                                        <td><?php echo $data['LyDo']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($data['NgayYeuCau'])); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($data['NgayKetThuc'])); ?></td>
                                        <td><?php echo ($data['TrangThai'] == 1) ? 'Còn hiệu lực' : 'Hết hạn'; ?></td>
                                    </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>Không có lịch sử bảo hành nào.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "./inc/footer.php"; ?>