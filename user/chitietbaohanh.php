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

// Lấy mã bảo hành từ URL (Nếu không có, chuyển hướng về trang lịch sử bảo hành)
$mabh = isset($_GET['mabh']) ? $_GET['mabh'] : null;
if ($mabh === null) {
    header("Location: dsdonhang.php");
    exit();
}

// Truy vấn thông tin chi tiết bảo hành từ cơ sở dữ liệu
$sql_chitiet_baohanh = "
    SELECT 
        s.TenSP, s.HinhAnh, b.MaBH, b.LyDo, b.NgayYeuCau, b.NgayHoanThanh, 
        b.NgayHen, b.TrangThai
    FROM 
        bao_hanh b
    JOIN 
        san_pham s ON b.MaSP = s.MaSP
    WHERE 
        b.MaBH = '$mabh' AND b.TenDangNhap = '$tendn'
";

$result_chitiet = mysqli_query($conn, $sql_chitiet_baohanh);

// Nếu không có dữ liệu, chuyển hướng về trang danh sách bảo hành
if (mysqli_num_rows($result_chitiet) == 0) {
    echo "Không tìm thấy thông tin bảo hành.";
    exit();
}

$data_chitiet = mysqli_fetch_array($result_chitiet);
?>

<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar.php"; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Chi tiết bảo hành</h4>
                    <table class="table table-bordered">
                        <tr>
                            <th>Mã bảo hành</th>
                            <td>BH<?php echo $data_chitiet['MaBH']; ?></td>
                        </tr>
                        <tr>
                            <th>Sản phẩm</th>
                            <td>
                                <?php echo $data_chitiet['TenSP']; ?>
                                <img src="../admin/<?php echo $data_chitiet['HinhAnh']; ?>" alt="Ảnh sản phẩm" style="width: 50px;">
                            </td>
                        </tr>
                        <tr>
                            <th>Lý do bảo hành</th>
                            <td><?php echo $data_chitiet['LyDo']; ?></td>
                        </tr>
                        <tr>
                            <th>Ngày yêu cầu</th>
                            <td><?php echo date('d/m/Y', strtotime($data_chitiet['NgayYeuCau'])); ?></td>
                        </tr>
                        <tr>
                            <th>Ngày hẹn</th>
                            <td><?php echo ($data_chitiet['NgayHen'] !== null) ? date('d/m/Y', strtotime($data_chitiet['NgayHen'])) : 'Chưa xác định'; ?></td>
                        </tr>
                        <tr>
                            <th>Ngày hoàn thành</th></th>
                            <td><?php echo ($data_chitiet['NgayHoanThanh'] !== null) ? date('d/m/Y', strtotime($data_chitiet['NgayHoanThanh'])) : 'Chưa xác định'; ?></td>
                        </tr>
                        <tr>
                            <th>Trạng thái</th>
                            <td>
                                <?php
                                switch ($data_chitiet['TrangThai']) {
                                    case 0:
                                        echo "Chờ xử lý";
                                        break;
                                    case 1:
                                        echo "Đang xử lý";
                                        break;
                                    case 2:
                                        echo "Đã hoàn thành";
                                        break;
                                    case 3:
                                        echo "Đã hủy";
                                        break;
                                    default:
                                        echo "Không xác định";
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <a href="dsdonhang.php" class="btn btn-secondary">Trở lại</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "./inc/footer.php"; ?>
