<?php

$conn=mysqli_connect('localhost','root','','laptop',3306);
mysqli_set_charset($conn,'utf8');
if(mysqli_connect_errno())
{
	echo "kết nối không thành công";
}
?>