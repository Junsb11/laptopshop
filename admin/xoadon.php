<?php
	include 'connect.php';
	$idhd=filter_input(INPUT_GET,'id');
	if(isset($idhd))
	{	
		$sql_deletect="DELETE FROM chi_tiet_hoa_don where MaHD=$idhd";
		$sql_deletehd="DELETE FROM hoa_don where MaHD=$idhd";
		$result_deletect=mysqli_query($conn,$sql_deletect);
		$result_deletehd=mysqli_query($conn,$sql_deletehd);
		if($result_deletehd)
		{header("Location: donhangdahuy.php");
		}
		else
		{
			echo " Chuyển trạng thái đơn không thành công";
		}

	}
?>