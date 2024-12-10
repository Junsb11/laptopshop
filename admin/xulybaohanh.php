<?php
	include 'connect.php';
	$idhd=filter_input(INPUT_GET,'id');
	if(isset($idhd))
	{	
		$sql_update="UPDATE bao_hanh set TrangThai=1 where MaBH=$idhd";
		$result_update=mysqli_query($conn,$sql_update);
		if($result_update)
		{header("Location: baohanhchoxuly.php");
		}
		else
		{
			echo " Chuyển trạng thái đơn không thành công";
		}

	}
?>