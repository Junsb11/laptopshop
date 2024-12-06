<?php
include "../admin/connect.php";

// Bắt đầu session nếu chưa tồn tại
if (!isset($_SESSION)) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa, nếu chưa thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
    exit();
}

// Lấy tên đăng nhập từ session
$tendn = $_SESSION['tendn'];

// Lấy tham số "loai" từ URL để lọc danh sách đơn hàng
$loai = isset($_GET['loai']) ? $_GET['loai'] : 'choxacnhan';

switch ($loai) {
    case 'choxacnhan':
        $l = 0;
        $title = "Đơn hàng chờ xác nhận";
        break;
    case 'danggiao':
        $l = 1;
        $title = "Đơn hàng đang giao";
        break;
    case 'dagiao':
        $l = 2;
        $title = "Đơn hàng đã giao";
        break;
    case 'dahuy':
        $l = 3;
        $title = "Đơn hàng đã hủy";
        break;
    default:
        $l = 0;
        $title = "Đơn hàng chờ xác nhận";
        break;
}

// Xử lý hành động xác nhận đơn hàng
if (isset($_GET['action']) && $_GET['action'] === 'xacnhan' && isset($_GET['mahd'])) {
    $mahd = $_GET['mahd'];
    $sql_update = "UPDATE hoa_don SET TrangThai=2 WHERE MaHD='$mahd' AND TenDangNhap='$tendn'";
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Xác nhận đơn hàng thành công!');</script>";
        header("Location: dsdonhang.php?loai=dagiao");
        exit();
    } else {
        echo "<script>alert('Lỗi khi xác nhận đơn hàng!');</script>";
    }
}

// Truy vấn CSDL để lấy danh sách đơn hàng theo trạng thái
$sql_xemdonhang = "SELECT * FROM hoa_don WHERE TrangThai='$l' AND TenDangNhap='$tendn'";
$result_dh = mysqli_query($conn, $sql_xemdonhang);

// Đếm số lượng đơn hàng theo trạng thái
$count_choxacnhan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM hoa_don WHERE TrangThai=0 AND TenDangNhap='$tendn'"));
$count_danggiao = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM hoa_don WHERE TrangThai=1 AND TenDangNhap='$tendn'"));
$count_dagiao = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM hoa_don WHERE TrangThai=2 AND TenDangNhap='$tendn'"));
$count_dahuy = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM hoa_don WHERE TrangThai=3 AND TenDangNhap='$tendn'"));
?>

<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar.php"; ?>

<style>
    .fixed-sidebar {
        position: fixed;
        top: 200px;
        width: 350px;
    }
    .content {
        margin-left: 350px;
        margin-bottom: 180px;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3 fixed-sidebar">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Trạng thái đơn hàng</h4>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'choxacnhan') ? 'active' : ''; ?>">
                            <a href="dsdonhang.php?loai=choxacnhan">Chờ xác nhận</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_choxacnhan; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'danggiao') ? 'active' : ''; ?>">
                            <a href="dsdonhang.php?loai=danggiao">Đang giao</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_danggiao; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'dagiao') ? 'active' : ''; ?>">
                            <a href="dsdonhang.php?loai=dagiao">Đã giao</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_dagiao; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'dahuy') ? 'active' : ''; ?>">
                            <a href="dsdonhang.php?loai=dahuy">Đã hủy</a>
                            <span class="badge badge-primary badge-pill"><?php echo $count_dahuy; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 content">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $title; ?></h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày lập</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stt = 1;
                                while ($data = mysqli_fetch_array($result_dh)) {
                                ?>
                                    <tr>
                                        <td><?php echo $stt++; ?></td>
                                        <td>HD<?php echo $data['MaHD']; ?></td>
                                        <td><?php echo $data['NgayLap']; ?></td>
                                        <td><?php echo number_format($data['TongTien'], 0, ',', '.'); ?> đ</td>
                                        <td>
                                            <?php
                                            switch ($data['TrangThai']) {
                                                case 0: echo "Chờ xác nhận"; break;
                                                case 1: echo "Đang giao"; break;
                                                case 2: echo "Đã giao"; break;
                                                case 3: echo "Đã hủy"; break;
                                                default: echo "Không xác định"; break;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($data['TrangThai'] == 1) { ?>
                                                <a href="dsdonhang.php?action=xacnhan&mahd=<?php echo $data['MaHD']; ?>" class="btn btn-success btn-sm">Xác nhận đã nhận</a>
                                            <?php } ?>
                                            <a href="chitietdonhang.php?mahd=<?php echo $data['MaHD']; ?>" class="btn btn-primary btn-sm">Chi tiết</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php if (mysqli_num_rows($result_dh) == 0) { ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Không có đơn hàng nào.</td>
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
