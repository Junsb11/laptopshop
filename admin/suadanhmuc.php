<?php include 'inc/header.php';
include 'inc/sidebar.php';?>

        <div class="grid_10">
            <div class="box round first grid">
            <?php 
		include 'connect.php';
		$iddm=filter_input(INPUT_GET, 'id');
		$sql_suadm="SELECT * FROM danh_muc where MaDM='$iddm'";
		$result_suadm=mysqli_query($conn,$sql_suadm);
		 ?>
                <h2>SỬA DANH MỤC</h2>
               <div class="block copyblock"> 
                 <form action="suadanhmuc.php" method="get">
                    <table class="form">	
                    <?php
		 		if ($result_suadm){
		 			while($data=mysqli_fetch_array($result_suadm)){

		 		 ?>				
                        <tr>
                            <td>
                                 <input type="hidden" placeholder="Nhập Mã Danh Mục..." class="medium" name="txtmadm" value='<?php echo $data['MaDM']; ?>' />
                            </td>                           
                        </tr>
                        <tr>
                        <td>
                                Tên Danh Mục :<input type="text" placeholder="Nhập Tên Danh Mục..." class="medium" name="txttendm" value='<?php echo $data['TenDM']; ?>' />
                        </td>
                        </tr>
                        <tr>
                        <td>
				<input type="radio" id="mo" name="trangthai" value="1" <?php if($data['TrangThai']) echo 'checked' ?>>
				<label for="mo">Mở</label>
				<input type="radio" id="khoa" name="trangthai" value="0" <?php if($data['TrangThai']==0) echo 'checked' ?> >
				<label for="khoa">Khóa</label></td>
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
           
            $madm=filter_input(INPUT_GET,'txtmadm');
            $tendm=filter_input(INPUT_GET,'txttendm');		 	
            $trangthai=filter_input(INPUT_GET,'trangthai');
            $sql_update="UPDATE danh_muc set TenDM='$tendm' ,TrangThai=$trangthai where MaDM='$madm'";
            $result_update=mysqli_query($conn,$sql_update);
            if($result_update)
            {
                echo "<script> window.location.href='xemdanhmuc.php'; </script>";
            }           
         }

		 ?>
<?php include 'inc/footer.php';?>