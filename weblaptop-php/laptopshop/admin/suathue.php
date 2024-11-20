<?php include 'inc/header.php';
include 'inc/sidebar.php';?>

        <div class="grid_10">
            <div class="box round first grid">
            <?php 
		include 'connect.php';
		$idthue=filter_input(INPUT_GET, 'id');
		$sql_suathue="SELECT * FROM thue where MaThue='$idthue'";
		$result_suathue=mysqli_query($conn,$sql_suathue);
		 ?>
                <h2>SỬA THUẾ</h2>
               <div class="block copyblock"> 
                 <form action="suathue.php" method="get">
                    <table class="form">	
                    <?php
		 		if ($result_suathue){
		 			while($data=mysqli_fetch_array($result_suathue)){

		 		 ?>				
                        <tr>
                            <td>
                                 <input type="hidden" placeholder="Nhập Mã thuế..." class="medium" name="txtmathue" value='<?php echo $data['MaThue']; ?>' />
                            </td>                           
                        </tr>
                        <tr>
                        <td>
                                Tên Thuế :<input type="text" placeholder="Nhập Tên Danh Mục..." class="medium" name="txttenthue" value='<?php echo $data['TenThue']; ?>' />
                        </td>
                        </tr>
                        <tr>
                        <td>
                                Tỷ lệ thuế :<input type="text" placeholder="Nhập Tỷ Lệ..." class="medium" name="txttylethue" value='<?php echo $data['TyLeThue']; ?>' />

				        </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="btnLuu" Value="Lưu" />
                            </td>
                        </tr>
                        <?php } 
		 }?>
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
           
            $mathue=filter_input(INPUT_GET,'txtmathue');
            $tenthue=filter_input(INPUT_GET,'txttenthue');		 	
            $tylethue=filter_input(INPUT_GET,'txttylethue');
            $sql_update="UPDATE thue set TenThue='$tenthue' ,TyLeThue='$tylethue' where MaThue='$mathue'";
            $result_update=mysqli_query($conn,$sql_update);
            if($result_update)
            {
                echo "<script> window.location.href='xemdanhsachthue.php'; </script>";
            }           
         }

		 ?>
<?php include 'inc/footer.php';?>