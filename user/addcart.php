<?php 
session_start();
include "./inc/header.php"; 
include "./inc/navbar.php"; 
include "../admin/connect.php";

if (isset($_GET['maCode'])) {
    $maCode = $_GET['maCode'];
    $sql = "SELECT * FROM chi_tiet_khuyen_mai cm 
            JOIN khuyen_mai km ON cm.MaCode = km.MaCode 
            WHERE km.MaCode = ? 
              AND km.TuNgay <= CURDATE() 
              AND km.DenNgay >= CURDATE()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maCode);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<pre>";
    var_dump($result); // Kiểm tra kết quả truy vấn
    echo "</pre>";

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $giamGia = $tong * $row['TyLeKM'] / 100;
    } else {
        $giamGia = 0; // Nếu mã giảm giá không hợp lệ hoặc không còn hiệu lực
    }
}
?>

<!-- Page Header Start -->
<!-- ... -->

<?php 
if (isset($_GET['btnthanhtoan'])) {
    echo "<script> window.location.href='dathang.php'; </script>";
}
?>
