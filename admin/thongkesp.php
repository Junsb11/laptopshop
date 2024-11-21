<?php 
include 'inc/header.php';
include 'inc/sidebar.php';

include 'connect.php';

// Xử lý dữ liệu từ form
$filterType = isset($_POST['filterType']) ? $_POST['filterType'] : 'all';
$filterValue = isset($_POST['filterValue']) ? $_POST['filterValue'] : '';

$whereClause = '';
switch ($filterType) {
    case 'year':
        if (!empty($filterValue)) {
            $whereClause = "WHERE YEAR(hoa_don.NgayHD) = $filterValue";
        }
        break;
    case 'month':
        $yearMonth = explode('-', $filterValue);
        if (count($yearMonth) == 2) {
            $whereClause = "WHERE YEAR(hoa_don.NgayHD) = $yearMonth[0] AND MONTH(hoa_don.NgayHD) = $yearMonth[1]";
        }
        break;
    case 'day':
        if (!empty($filterValue)) {
            $whereClause = "WHERE hoa_don.NgayHD = '$filterValue'";
        }
        break;
    default:
        $whereClause = '';
}

// Query thống kê sản phẩm
$sql_thongke = "SELECT chi_tiet_hoa_don.*, SUM(SoLuongMua) as 'TongBanRa', SUM(SoLuongMua * DonGia) as 'TongDoanhThu', san_pham.TenSP 
                FROM chi_tiet_hoa_don 
                INNER JOIN san_pham ON chi_tiet_hoa_don.MaSP = san_pham.MaSP 
                INNER JOIN hoa_don ON chi_tiet_hoa_don.MaHD = hoa_don.MaHD 
                $whereClause
                GROUP BY chi_tiet_hoa_don.MaSP;";
$result = mysqli_query($conn, $sql_thongke);

// Khởi tạo biến đếm tổng
$totalQuantity = 0;
$totalRevenue = 0;

// Tính tổng số lượng đã bán và tổng doanh thu
while ($data = mysqli_fetch_array($result)) {
    $totalQuantity += $data['TongBanRa'];
    $totalRevenue += $data['TongDoanhThu'];
}
mysqli_data_seek($result, 0); // Đặt lại con trỏ kết quả để lấy dữ liệu từ đầu
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Thống kê sản phẩm</h2>
        
        <!-- Form bộ lọc -->
        <form method="post" action="" class="filter-form">
            <div class="filter-group">
                <label for="filterType">Chọn loại bộ lọc:</label>
                <select name="filterType" id="filterType" onchange="toggleFilterInput(this.value)">
                    <option value="all" <?php if ($filterType == 'all') echo 'selected'; ?>>Tất cả</option>
                    <option value="year" <?php if ($filterType == 'year') echo 'selected'; ?>>Theo năm</option>
                    <option value="month" <?php if ($filterType == 'month') echo 'selected'; ?>>Theo tháng</option>
                    <option value="day" <?php if ($filterType == 'day') echo 'selected'; ?>>Theo ngày</option>
                </select>
            </div>

            <div class="filter-group" id="filterInput" style="display: <?php echo ($filterType == 'all') ? 'none' : 'inline-block'; ?>;">
                <?php if ($filterType == 'year'): ?>
                    <label for="filterValueYear">Năm:</label>
                    <input type="number" name="filterValue" id="filterValueYear" placeholder="YYYY" value="<?php echo $filterValue; ?>">
                <?php elseif ($filterType == 'month'): ?>
                    <label for="filterValueMonth">Tháng:</label>
                    <input type="month" name="filterValue" id="filterValueMonth" value="<?php echo $filterValue; ?>">
                <?php elseif ($filterType == 'day'): ?>
                    <label for="filterValueDay">Ngày:</label>
                    <input type="date" name="filterValue" id="filterValueDay" value="<?php echo $filterValue; ?>">
                <?php endif; ?>
            </div>

            <input type="submit" value="Lọc" class="filter-submit">
        </form>

        <div class="stats-container">
            <div class="stat-box">
                <div class="stat-number"><?php echo $totalQuantity; ?></div>
                <div class="stat-label">Tổng số lượng đã bán</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?php echo number_format($totalRevenue, 0, ',', '.'); ?> VND</div>
                <div class="stat-label">Tổng doanh thu</div>
            </div>
        </div>
        <div class="chart-container chart-container--size-2">
            <canvas id="chartVerticalBar"></canvas>
        </div>
    </div>
</div>

<style>
    /* CSS cho form lọc */
    .filter-form {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }

    .filter-group {
        display: inline-block;
        margin-right: 20px;
    }

    .filter-group label {
        font-weight: bold;
        margin-right: 5px;
    }

    .filter-group select,
    .filter-group input[type="number"],
    .filter-group input[type="month"],
    .filter-group input[type="date"] {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .filter-submit {
        padding: 8px 15px;
        font-size: 14px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .filter-submit:hover {
        background-color: #45a049;
    }

    /* Các phần còn lại giữ nguyên */
    .stats-container {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
    }
    .stat-box {
        background: #f9f9f9;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        flex: 1;
        margin: 0 10px;
    }
    .stat-number {
        font-size: 2em;
        color: #333;
    }
    .stat-label {
        font-size: 1.2em;
        color: #888;
    }
    .chart-container {
        margin-top: 20px;
    }
</style>

<script type="text/javascript">
window.addEventListener('load', function () {
    var ctx = document.getElementById('chartVerticalBar').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php
                while ($data = mysqli_fetch_array($result)) {
                    echo '"' . $data['TenSP'] . '",';
                }
                mysqli_data_seek($result, 0); // Đặt lại con trỏ kết quả để lấy dữ liệu lại
                ?>
            ],
            datasets: [{
                label: "Số lượng đã bán",
                backgroundColor: 'rgba(245,34,34,.5)',
                borderColor: 'rgba(245,34,34,1)',
                data: [
                    <?php
                    while ($data = mysqli_fetch_array($result)) {
                        echo '"' . $data['TongBanRa'] . '",';
                    }
                    mysqli_data_seek($result, 0); // Đặt lại con trỏ kết quả để lấy dữ liệu lại
                    ?>
                ],
            },
            {
                label: "Doanh thu",
                backgroundColor: 'rgba(34,245,34,.5)',
                borderColor: 'rgba(34,245,34,1)',
                data: [
                    <?php
                    while ($data = mysqli_fetch_array($result)) {
                        echo '"' . $data['TongDoanhThu'] . '",';
                    }
                    ?>
                ],
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Các sản phẩm bán chạy nhất'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true,
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Sản phẩm'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Số lượng'
                    }
                }]
            }
        }
    });
});
</script>

<?php
include 'inc/footer.php';