<?php 
include 'connect.php';
$madg=filter_input(INPUT_GET, 'id');
$sql_xoa="DELETE FROM danhgia where MaDG='$madg'";
$result_xoa=mysqli_query($conn,$sql_xoa);
if($result_xoa){
    header("Location: xemdanhgia.php");
}
else echo 'Xoá không thành công'
 ?>