<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
		include 'connect.php';
		$mahd=filter_input(INPUT_GET, 'mahd');
		$sql_xemsp="SELECT * FROM chi_tiet_hoa_don ct,san_pham s where ct.MaSP=s.MaSP and MaHD='$mahd'";
		$result_sp=mysqli_query($conn,$sql_xemsp);
		?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Chi tiết hóa đơn số <?php echo $mahd; ?></h2>
        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>STT</th>
					<!-- <th>Khách hàng</th>			 -->
					<th>Sản phẩm</th>							
                    <th>Giá gốc</th>
					<th>Khuyến mãi</th>
					<th>Số lượng</th>
                    <th>Thao tác</th>
				</tr>
			</thead>
			<tbody>
            <?php 
					$stt=1;
				while ($data=mysqli_fetch_array($result_sp)) {									
				?>
				<tr class="odd gradeX">
					<td><?php echo $stt++;?></td>
					<!-- <td><?php echo $data['TenKH'];?></td> -->
					<td><?php echo $data['TenSP'];?></td>					                
                    <td><?php echo $data['GiaGoc'];?></td>
                    <td><?php echo $data['TyLeKM'];?></td>
					<td><?php echo $data['SoLuongMua'];?></td>
					<td><a href="">Xem chi tiết</a> || <a href="">Delete</a></td>
				</tr>
                <?php
				}
				?>
     
				
			</tbody>
		</table>

       </div>
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
