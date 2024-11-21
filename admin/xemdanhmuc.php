<?php include 'inc/header.php';
include 'inc/sidebar.php'?>
		<?php
		include 'connect.php';
		$sql_xemdm="SELECT * FROM danh_muc";
		$result_dm=mysqli_query($conn,$sql_xemdm);
		?>

        <div class="grid_10">
            <div class="box round first grid">
				<form action="xemdanhmuc.php" method="get">
                <h2>Danh sách danh mục</h2>
                <div class="block">        
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên danh mục</th>
							<th>Trạng thái</th>
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
							<td><?php echo $data['TenDM'];?></td>
							<td><?php if ($data['TrangThai']) echo 'Mở'; else echo 'Khóa';?></td>
							<td><a href="suadanhmuc.php?id=<?php echo $data['MaDM']?>">Edit</a> || <a href="xoadanhmuc.php?id=<?php echo $data['MaDM']?>" onclick="return comfirm('Ban co muon xoa khong?')">Delete</a></td>
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

