<?php include 'inc/header.php';
include 'inc/sidebar.php'?>

<?php
		include 'connect.php';
		$sql_xemdg="SELECT danhgia.*, san_pham.TenSP FROM danhgia inner join san_pham on danhgia.MaSP = san_pham.MaSP where danhgia.TrangThai = 1";
		$result_dg=mysqli_query($conn,$sql_xemdg);
?>

<div class="grid_10">
            <div class="box round first grid">
				<form action="xemtaikhoan.php" method="get">
                <h2>Danh sách đánh giá</h2>
                <div class="block">        
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên tài khoản</th>
							<th>Tên sản phẩm</th>
							<th>Số sao</th>
							<th>Nội dung</th>
							<th>Ngày đánh giá</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$stt=1;
				while ($data=mysqli_fetch_array($result_dg)) {									
				?>
						<tr class="odd gradeX">
							<td><?php echo $stt++;?></td>
							<td><?php echo $data['TenDangNhap'];?></td>
							<td><?php echo $data['TenSP'];?></td>
                            <td><?php echo $data['SoSao'];?></td>
                            <td><?php echo $data['NoiDung'];?></td>
                            <td><?php echo $data['NgayDG'];?></td>
                            <td><a href="xoadanhgia.php?id=<?php echo $data['MaDG']?>" onclick="return comfirm('Ban co muon xoa khong?')">Delete</a></td>
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