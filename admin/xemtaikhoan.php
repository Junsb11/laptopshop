<?php include 'inc/header.php';
include 'inc/sidebar.php'?>

<?php
		include 'connect.php';
		$sql_xemtk="SELECT tai_khoan.*, loai_tk.TenLoai FROM tai_khoan inner join loai_tk on tai_khoan.MaLoai = loai_tk.MaLoai";
		$result_dm=mysqli_query($conn,$sql_xemtk);
?>
<div class="grid_10">
            <div class="box round first grid">
				<form action="xemtaikhoan.php" method="get">
                <h2>Danh sách tài khoản</h2>
                <div class="block">        
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên đăng nhập</th>
							<th>Trạng thái</th>
							<th>Họ tên</th>
							<th>Giới tính</th>
							<th>SDT</th>
							<th>Email</th>
							<th>Địa chỉ</th>
							<th>Loại tài khoản</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$stt=1;
				while ($data=mysqli_fetch_array($result_dm)) {									
				?>
						<tr class="odd gradeX">
							<td><?php echo $stt++;?></td>
							<td><?php echo $data['TenDangNhap'];?></td>
							<td><?php if ($data['TrangThai']) echo 'Mở'; else echo 'Khóa';?></td>
                            <td><?php echo $data['HoTen'];?></td>
                            <td><?php if ($data['GioiTinh']) echo 'Nam'; else echo 'Nữ';?></td>
                            <td><?php echo $data['SDT'];?></td>
                            <td><?php echo $data['Email'];?></td>
                            <td><?php echo $data['DiaChi'];?></td>
                            <td><?php echo $data['TenLoai'];?></td>
							<td><a href="khoataikhoan.php?id=<?php echo $data['TenDangNhap']?>"><?php if ($data['TrangThai']) echo 'Lock'; else echo 'Unlock';?></a> || <a href="xoataikhoan.php?id=<?php echo $data['TenDangNhap']?>" onclick="return comfirm('Ban co muon xoa khong?')">Delete</a></td>
						</tr>
						<?php
				}
				?>
     
					</tbody>
				</table>
               </div>
			   </form>
            </div>
        </div>
<script type="text/javascript">
	$(document).ready(function () {
	    setupLeftMenu();

	    $('.datatable').dataTable();
	    setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php';?>