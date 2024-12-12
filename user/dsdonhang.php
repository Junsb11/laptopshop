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

// Xử lý biến loại để lấy danh sách đơn hàng tương ứng
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

// Truy vấn CSDL để lấy danh sách đơn hàng
$sql_xemhd = "SELECT * FROM hoa_don WHERE TrangThai='$l' AND TenDangNhap='$tendn'";
$result_hd = mysqli_query($conn, $sql_xemhd);

// Truy vấn để đếm số lượng đơn hàng theo trạng thái
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

    .btn-xacnhan {
        background-color: #28a745;
        color: white;
        border-radius: 5px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-xacnhan:hover {
        background-color: #218838;
        transform: scale(1.05);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-xacnhan:active {
        background-color: #1e7e34;
        transform: scale(1);
    }

    .btn-xacnhan i {
        margin-right: 5px;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg- fixed-sidebar">
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
        <div class="col-lg-9 content">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $title; ?></h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Số hóa đơn</th>
                                    <th>Họ tên</th>
                                    <th>SĐT</th>
                                    <th>Địa chỉ nhận hàng</th>
                                    <th>Ngày lập</th>
                                    <th>Tình trạng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stt = 1;
                                while ($data = mysqli_fetch_array($result_hd)) { ?>
                                    <tr>
                                        <td><?php echo $stt++; ?></td>
                                        <td>HD<?php echo $data['MaHD']; ?></td>
                                        <td><?php echo $data['HoTenNN']; ?></td>
                                        <td><?php echo $data['SDT']; ?></td>
                                        <td><?php echo $data['DiaChi']; ?></td>
                                        <td><?php echo $data['NgayHD']; ?></td>
                                        <td>
                                            <?php
                                            switch ($data['TrangThai']) {
                                                case 0:
                                                    echo "Chờ xác nhận";
                                                    break;
                                                case 1:
                                                    echo "Đang giao";
                                                    break;
                                                case 2:
                                                    echo "Đã giao";
                                                    break;
                                                case 3:
                                                    echo "Đã hủy";
                                                    break;
                                                default:
                                                    echo "Không xác định";
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($data['TrangThai'] == 1) { ?>
                                                <a href="xacnhandonhang.php?mahd=<?php echo $data['MaHD']; ?>" class="btn btn-xacnhan">
                                                    <i class="fas fa-check-circle"></i> Xác nhận
                                                </a>
                                            <?php } ?>
                                            <a href="chitietdonhang.php?mahd=<?php echo $data['MaHD']; ?>" class="btn btn-primary btn-sm btn-block">Chi tiết</a>
                                            <?php if ($data['TrangThai'] == 0) { ?>
                                                <a href="huydonhang.php?mabh=<?php echo $data['MaHD']; ?>" class="btn btn-danger btn-sm btn-block" onclick="return confirm('Bạn có chắc chắn muốn hủy yêu cầu này không?');">Hủy</a>
                                            <?php } elseif ($data['TrangThai'] == 2) { ?>
                                                <a href="xoadonhang.php?mabh=<?php echo $data['MaHD']; ?>" class="btn btn-danger btn-sm btn-block" onclick="return confirm('Bạn có chắc chắn muốn xóa yêu cầu này không?');">Xóa</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if (mysqli_num_rows($result_hd) == 0) { ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Không có đơn hàng nào.</td>
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
