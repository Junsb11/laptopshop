<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
        <div class="grid_10">
            <div class="box round first grid">
              
                <h2>THÊM MỚI DANH MỤC</h2>
               <div class="block copyblock"> 
                 <form action="themmoidanhmuc.php" method="get">
                    <table class="form">					
                        
                        <tr>
                        <td>
                                Tên Danh Mục :<input type="text" placeholder="Nhập Tên Danh Mục..." class="medium" name="txttendm" />
                        </td>
                        </tr>
                        <tr>
                        <td>
				<input type="radio" id="mo" name="trangthai" value="1" checked="1">
				<label for="mo">Mở</label>
				<input type="radio" id="khoa" name="trangthai" value="0" >
				<label for="khoa">Khóa</label></td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="btnLuu" Value="Lưu" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
        <?php 
		include 'connect.php';
		 $a=filter_input(INPUT_GET,'btnHuy');
		 $b=filter_input(INPUT_GET,'btnLuu');
		 if(isset($a))
		 {}
			if(isset($b))
		 {
		 	
		 	$tendm=filter_input(INPUT_GET,'txttendm');		 	
		 	$trangthai=filter_input(INPUT_GET,'trangthai');
		 	$sql_check="SELECT * FROM danh_muc where MaDM='$madm'";
		 	$number_of_rows = mysqli_num_rows(mysqli_query($conn,$sql_check));
		 	

		 	$sql_insert="INSERT INTO danh_muc(TenDM,TrangThai) values ('$tendm',$trangthai)";
		 	$result_insert=mysqli_query($conn,$sql_insert);
			if($result_insert)
			{
				echo "<script> window.location.href='xemdanhmuc.php'; </script>";
                
			}
			else
			{
				echo 'Them khong thanh cong';
			}
		 			  
		 
		 }

		 ?>
<?php include 'inc/footer.php';?>
