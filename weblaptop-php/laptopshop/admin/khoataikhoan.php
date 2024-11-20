<?php 
include 'connect.php';
$tendangnhap=filter_input(INPUT_GET, 'id');
$sql_ten_trang_thai = mysqli_query($conn,"SELECT TrangThai from tai_khoan where TenDangNhap='$tendangnhap'");
$ten_trang_thai =  mysqli_fetch_array($sql_ten_trang_thai);
$trangthai = $ten_trang_thai["TrangThai"];
if($trangthai ==0 ) {
    $trangthai = 1;
} else {
    $trangthai = 0;
}
echo $trangthai;
$sql_khoatk="UPDATE tai_khoan set TrangThai = b'$trangthai' where TenDangNhap='$tendangnhap'";
$result_khoatk=mysqli_query($conn,$sql_khoatk);
if($result_khoatk){
    header("Location: xemtaikhoan.php");
}
else echo 'Khoá không thành công'
?>