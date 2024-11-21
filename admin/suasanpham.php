<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Product</h2>
        <?php
		include 'connect.php';
        $idsp=filter_input(INPUT_GET, 'id');
		$sql_xemdm="SELECT * FROM danh_muc";
		$result_dm=mysqli_query($conn,$sql_xemdm);
        $sql_suasp="SELECT * FROM san_pham where MaSP='$idsp'";
		$result_suasp=mysqli_query($conn,$sql_suasp);
		?>
        <div class="block">               
         <form action="suasanpham.php" method="POST" enctype="multipart/form-data">
            <table class="form" action="themmoisanpham.php" method="get" enctype="multipart/form-data" >
            <?php
		 		if ($result_suasp){
		 			while($data=mysqli_fetch_array($result_suasp)){

		 		 ?>		
                <tr>
                    <td>
                        <label>Tên sản phẩm</label>
                    </td>
                    <td>
                        <input type="hidden" name="txtmasp" value='<?php echo $data['MaSP']; ?>'/>
                        <input type="text" name="txttensp" placeholder="Tên Sản Phẩm..." class="medium" value='<?php echo $data['TenSP']; ?>' />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Đơn giá</label>
                    </td>
                    <td>
                        <input type="text" name="txtdongia" placeholder="Đơn Giá..." class="medium" value='<?php echo $data['DonGia']; ?>' />
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <label>Hình Ảnh</label>
                    </td>
                    <td>
                    <img src='<?php echo $data['HinhAnh']?>' alt="" width="200px">
                    <input type="hidden" name="pathhinh" value='<?php echo $data['HinhAnh']; ?>' />
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
				
				while ($data1=mysqli_fetch_array($result_dm)) {									
				?>
                            
                            <option value='<?php echo $data1['MaDM'];?>' <?php if($data1['MaDM']==$data['MaDM']) echo 'selected' ?> ><?php echo $data1['TenDM']; ?></option>                            
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
                    <input type="radio" id="mo" name="trangthai" value="1" <?php if($data['TrangThai']==1) echo 'checked' ?>>
                <label for="mo">Mở</label>
                <input type="radio" id="khoa" name="trangthai" value="0" <?php if($data['TrangThai']==0) echo 'checked' ?> >
                <label for="khoa">Khóa</label>
                    </td>
                </tr>
				
				 <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Mô tả</label>
                    </td>
                    <td>
                        <textarea name="txtmota" class="tinymce" value='<?php echo $data['MoTa']; ?>' > <?php echo $data['MoTa']; ?></textarea>
                    </td>
                </tr>
				
				

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="btnluu" Value="Lưu" />
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

 if(isset($_POST['btnluu'])){
    $masp =$_POST['txtmasp'];
    $tensp =$_POST['txttensp'];
    $dongia =$_POST['txtdongia'];
    $trangthai =$_POST['trangthai'];
    $mota =$_POST['txtmota'];
    $madm=$_POST['madm'];
    if($_FILES['hinhanh']['tmp_name']){
    $file = $_FILES['hinhanh']['tmp_name'];
    $path = "upload/".$_FILES['hinhanh']['name'];}
    else $path=$_POST['pathhinh'];
    if(move_uploaded_file($file, $path)){
        echo "Tải tập tin thành công";
    }else{
        echo "Tải tập tin thất bại";
    }

    $sql_update="UPDATE san_pham set TenSP='$tensp',DonGia='$dongia' ,TrangThai=$trangthai,HinhAnh='$path' ,MoTa='$mota', MaDM='$madm' where MaSP='$masp' ";
            $result_update=mysqli_query($conn,$sql_update);
            if($result_update)
            {
                echo "<script> window.location.href='xemsanpham.php'; </script>";
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


