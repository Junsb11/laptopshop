<?php 
include 'connect.php';
$iddm=filter_input(INPUT_GET, 'id');
$sql_xoadm="DELETE FROM danh_muc where MaDM='$iddm'";
$result_xoadm=mysqli_query($conn,$sql_xoadm);
if($result_xoadm){
    header("Location: xemdanhmuc.php");
}
else echo 'Xoa khong thanh cong'
 ?>