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

    // Xử lý biến loại để lọc danh sách yêu cầu bảo hành theo trạng thái
    $loai = isset($_GET['loai']) ? $_GET['loai'] : 'choxuly';

    switch ($loai) {
        case 'choxuly':
            $l = 0;
            $title = "Yêu cầu bảo hành chờ xử lý";
            break;
        case 'dangxuly':
            $l = 1;
            $title = "Yêu cầu bảo hành đang xử lý";
            break;
        case 'hoanthanh':
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

    // Truy vấn CSDL để lấy danh sách yêu cầu bảo hành
    $sql_xembaohanh = "SELECT * FROM bao_hanh WHERE TrangThai='$l' AND TenDangNhap='$tendn'";
    $result_bh = mysqli_query($conn, $sql_xembaohanh);

    // Truy vấn để đếm số lượng yêu cầu bảo hành theo trạng thái
    $count_choxuly = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai=0 AND TenDangNhap='$tendn'"));
    $count_dangxuly = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai=1 AND TenDangNhap='$tendn'"));
    $count_hoanthanh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai=2 AND TenDangNhap='$tendn'"));
    $count_dahuy = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bao_hanh WHERE TrangThai=3 AND TenDangNhap='$tendn'"));
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
                        <h4 class="card-title">Tình trạng bảo hành</h4>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'choxuly') ? 'active' : ''; ?>">
                                <a href="dsbaohanh.php?loai=choxuly">Chờ xử lý</a>
                                <span class="badge badge-primary badge-pill"><?php echo $count_choxuly; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'dangxuly') ? 'active' : ''; ?>">
                                <a href="dsbaohanh.php?loai=dangxuly">Đang xử lý</a>
                                <span class="badge badge-primary badge-pill"><?php echo $count_dangxuly; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'hoanthanh') ? 'active' : ''; ?>">
                                <a href="dsbaohanh.php?loai=hoanthanh">Hoàn thành</a>
                                <span class="badge badge-primary badge-pill"><?php echo $count_hoanthanh; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($loai == 'dahuy') ? 'active' : ''; ?>">
                                <a href="dsbaohanh.php?loai=dahuy">Đã hủy</a>
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
                                        <th>Mã bảo hành</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Ngày yêu cầu</th>
                                        <th>Tình trạng</th>
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
                                            <td><?php echo $data['TenSanPham']; ?></td>
                                            <td><?php echo $data['NgayYeuCau']; ?></td>
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
                                                        echo "Hoàn thành";
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
                                            <td><a href="chitietbaohanh.php?mabh=<?php echo $data['MaBH']; ?>" class="btn btn-primary btn-sm">Chi tiết</a></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <?php if (mysqli_num_rows($result_bh) == 0) { ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Không có yêu cầu bảo hành nào.</td>
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
