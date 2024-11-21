<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Product</h2>
        <?php
		include 'connect.php';
		$sql_xemdm="SELECT * FROM danh_muc";
		$result_dm=mysqli_query($conn,$sql_xemdm);
		?>
        <div class="block">               
         <form action="themmoisanpham.php" method="POST" enctype="multipart/form-data">
            <table class="form" action="themmoisanpham.php" method="get" enctype="multipart/form-data" >
               
                <tr>
                    <td>
                        <label>Tên sản phẩm</label>
                    </td>
                    <td>
                        <input type="text" name="txttensp" placeholder="Tên Sản Phẩm..." class="medium" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Đơn giá</label>
                    </td>
                    <td>
                        <input type="text" name="txtdongia" placeholder="Đơn Giá..." class="medium" />
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <label>Hình Ảnh</label>
                    </td>
                    <td>
                        <input type="file" name="hinhanh" />
                    </td>
                </tr>

				<tr>
                    <td>
                        <label>Danh mục</label>
                    </td>
                    <td>
                        <select id="select" name="madm">
                        <option>Chọn Danh Mục</option>
                        <?php 
				
				while ($data=mysqli_fetch_array($result_dm)) {									
				?>
                            
                            <option value='<?php echo $data['MaDM'];?>'><?php echo $data['TenDM']; ?></option>                            
                            <?php
				}
				?>
                        </select>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Trạng thái</label>
                    </td>
                    <td>
                    <input type="radio" id="mo" name="trangthai" value="1" checked="1">
				<label for="mo">Mở</label>
				<input type="radio" id="khoa" name="trangthai" value="0" >
				<label for="khoa">Khóa</label>
                    </td>
                </tr>
				
				 <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Mô tả</label>
                    </td>
                    <td>
                        <textarea name="txtmota" class="tinymce"></textarea>
                    </td>
                </tr>
				
				

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Save" />
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>
<?php

 if(isset($_POST['submit'])){
    $tensp =$_POST['txttensp'];
    $dongia =$_POST['txtdongia'];
    $trangthai =$_POST['trangthai'];
    $mota =$_POST['txtmota'];
    $madm=$_POST['madm'];
    $file = $_FILES['hinhanh']['tmp_name'];
    $path = "upload/".$_FILES['hinhanh']['name'];
    if(move_uploaded_file($file, $path)){
        echo "Tải tập tin thành công";
    }else{
        echo "Tải tập tin thất bại";
    }

    $sql_insert="INSERT INTO san_pham(TenSP,DonGia,HinhAnh,MaDM,TrangThai,MoTa) values ('$tensp','$dongia','$path','$madm','$trangthai','$mota')";
		 	$result_insert=mysqli_query($conn,$sql_insert);
			if($result_insert)
			{
				echo "<script> window.location.href='xemsanpham.php'; </script>";
                
			}
			else
			{
				echo 'Them khong thanh cong';
			}
		 			  

}
?>

<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>


