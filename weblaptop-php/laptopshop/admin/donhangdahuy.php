<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
		include 'connect.php';
		$sql_xemsp="SELECT * FROM hoa_don where TrangThai=3 ORDER BY NgayHD ASC";
		$result_sp=mysqli_query($conn,$sql_xemsp);
		?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Đơn hàng đã hủy</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>STT</th>
					<th>Khách hàng</th>
					<th>Ngày lập</th>
					<th>Ghi chú</th>					
                    <th>Địa chỉ</th>
					<th>SĐT</th>
					<th>Trạng thái</th>
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
					<td><?php echo $data['HoTenNN'];?></td>
					<td><?php echo $data['NgayHD'];?></td>
					
                    <td><?php echo $data['GhiChu'];?></td>
                    <td><?php echo $data['DiaChi'];?></td>
                    <td><?php echo $data['SDT'];?></td>
					<td>Đã hủy</td>
					<td><a href="xoadon.php?id=<?php echo $data['MaHD'] ?>">Xóa đơn</a> </td>
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
