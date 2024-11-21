<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
		include 'connect.php';
		$sql_xemsp="SELECT * FROM hoa_don where TrangThai=1 ORDER BY NgayHD ASC";
		$result_sp=mysqli_query($conn,$sql_xemsp);
		?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Đơn hàng đang giao</h2>
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
					<td>Đang giao</td>
					<td><a href="dathanhtoan.php?id=<?php echo $data['MaHD'] ?>"> Đã thanh toán</a> || <a href="velaidonmoi.php?id=<?php echo $data['MaHD'] ?>">Về lại đơn mới</a> || <a href="huydon.php?id=<?php echo $data['MaHD'] ?>" onclick="return confirm('Bạn có muốn hủy hóa đơn này không?')"> Hủy</a></td>
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
