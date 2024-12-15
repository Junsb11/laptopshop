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
            $whereClause = "WHERE YEAR(tong_kho.NgayNhap) = $filterValue";
        }
        break;
    case 'month':
        $yearMonth = explode('-', $filterValue);
        if (count($yearMonth) == 2) {
            $whereClause = "WHERE YEAR(tong_kho.NgayNhap) = $yearMonth[0] AND MONTH(tong_kho.NgayNhap) = $yearMonth[1]";
        }
        break;
    case 'day':
        if (!empty($filterValue)) {
            $whereClause = "WHERE san_pham.NgayNhap = '$filterValue'";
        }
        break;
    default:
        $whereClause = '';
}

// Query thống kê số lượng tồn kho
$sql_thongke = "SELECT san_pham.*, SUM(so_luong) as 'TongTonKho', san_pham.TenSP 
                FROM san_pham 
                GROUP BY san_pham.MaSP;";
$result = mysqli_query($conn, $sql_thongke);

// Khởi tạo biến đếm tổng
$totalQuantity = 0;

// Tính tổng số lượng tồn kho
while ($data = mysqli_fetch_array($result)) {
    $totalQuantity += $data['TongTonKho'];
}
mysqli_data_seek($result, 0); // Đặt lại con trỏ kết quả để lấy dữ liệu từ đầu
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Thống kê số lượng tồn kho</h2>
        
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
                <div class="stat-label">Tổng số lượng tồn kho</div>
            </div>
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

<?php
include 'inc/footer.php';
?>
