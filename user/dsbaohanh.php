<?php
include "../admin/connect.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

// Xử lý biến loại để lấy danh sách bảo hành tương ứng
$loai = isset($_GET['loai']) ? $_GET['loai'] : 'choxuly';

// Quyết định trạng thái và tiêu đề dựa vào tham số 'loai'
switch ($loai) {
    case 'choxuly':
        $l = 0;
        $title = "Yêu cầu bảo hành chờ xử lý";
        break;
    case 'dangxuly':
        $l = 1;
        $title = "Yêu cầu bảo hành đang xử lý";
        break;
    case 'dahoanthanh':
        $l = 2;
        $title = "Yêu cầu bảo hành đã hoàn thành";
        break;
    case 'dahuy':
        $l = 3;
        $title = "Yêu cầu bảo hành đã hủy";
        break;
    default:
        $l = 0;
        $title = "Yêu cầu bảo hành chờ xử lý";
        break;
}

// Truy vấn CSDL để lấy danh sách yêu cầu bảo hành từ bảng `bao_hanh`
$sql_xembh = "SELECT * FROM bao_hanh WHERE TrangThai='$l' AND TenDangNhap='$tendn' ORDER BY NgayYeuCau DESC";
$result_bh = mysqli_query($conn, $sql_xembh);

// Truy vấn để đếm số lượng yêu cầu bảo hành theo trạng thái
$count_choxuly = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai=0 AND TenDangNhap='$tendn'"));
$count_dangxuly = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai=1 AND TenDangNhap='$tendn'"));
$count_dahoanthanh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai=2 AND TenDangNhap='$tendn'"));
$count_dahuy = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai=3 AND TenDangNhap='$tendn'"));
?>

<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar.php"; ?>

<div class="container mt-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 fixed-sidebar">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tình trạng bảo hành</h4>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'choxuly') ? 'active' : ''; ?>">
                            <a href="dsbaohanh.php?loai=choxuly">Chờ xử lý</a>
                            <span class="badge badge-primary"><?php echo $count_choxuly; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'dangxuly') ? 'active' : ''; ?>">
                            <a href="dsbaohanh.php?loai=dangxuly">Đang xử lý</a>
                            <span class="badge badge-primary"><?php echo $count_dangxuly; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'dahoanthanh') ? 'active' : ''; ?>">
                            <a href="dsbaohanh.php?loai=dahoanthanh">Đã hoàn thành</a>
                            <span class="badge badge-primary"><?php echo $count_dahoanthanh; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'dahuy') ? 'active' : ''; ?>">
                            <a href="dsbaohanh.php?loai=dahuy">Đã hủy</a>
                            <span class="badge badge-primary"><?php echo $count_dahuy; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Nội dung chính -->
        <div class="col-lg-9 content">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $title; ?></h4>
                    <?php if (isset($_GET['msg'])) { ?>
                        <div class="alert alert-info text-center"><?php echo htmlspecialchars($_GET['msg']); ?></div>
                    <?php } ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Mã bảo hành</th>
                                    <th>Sản phẩm</th>
                                    <th>Nội dung</th>
                                    <th>Ngày yêu cầu</th>
                                    <th>Ngày hẹn</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stt = 1;
                                while ($data = mysqli_fetch_array($result_bh)) {
                                ?>
                                    <tr>
                                        <td><?php echo $stt++; ?></td>
                                        <td>BH<?php echo $data['MaBH']; ?></td>
                                        <td><?php echo $data['MaSP']; ?></td>
                                        <td><?php echo $data['LyDo']; ?></td>
                                        <td><?php echo $data['NgayYeuCau']; ?></td>
                                        <td><?php echo $data['NgayHen'] ?? 'Chưa xác định'; ?></td>
                                        <td>
                                            <?php
                                            switch ($data['TrangThai']) {
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
                                        <td>
                                            <a href="chitietbaohanh.php?mabh=<?php echo $data['MaBH']; ?>" class="btn btn-primary btn-sm btn-block">Chi tiết</a>
                                        <?php if ($data['TrangThai'] == 0) { ?>
                                                <a href="huybaohanh.php?mabh=<?php echo $data['MaBH']; ?>" class="btn btn-danger btn-sm btn-block" onclick="return confirm('Bạn có chắc chắn muốn hủy yêu cầu này không?');">Hủy</a>
                                        <?php } elseif ($data['TrangThai'] == 2) { ?>
                                                <a href="xoabaohanh.php?mabh=<?php echo $data['MaBH']; ?>" class="btn btn-danger btn-sm btn-block" onclick="return confirm('Bạn có chắc chắn muốn xóa yêu cầu này không?');">Xóa</a>
                                        <?php } elseif ($data['TrangThai'] == 3) { ?>
                                            <a href="khoiphucbaohanh.php?mabh=<?php echo $data['MaBH']; ?>" class="btn btn-success btn-sm btn-block" onclick="return confirm('Bạn có chắc chắn muốn khôi phục yêu cầu này không?');">Khôi phục</a>
                                        <?php } ?>
                                        </td>
   </tr>
                                <?php } ?>
                                <?php if (mysqli_num_rows($result_bh) == 0) { ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Không có yêu cầu bảo hành nào.</td>
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