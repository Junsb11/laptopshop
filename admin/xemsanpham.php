<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    include 'connect.php';
    $sql_xemsp = "SELECT *, s.so_luong FROM danh_muc d, san_pham s WHERE s.MaDM = d.MaDM ORDER BY MaSP";
    $result_sp = mysqli_query($conn, $sql_xemsp);
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Post List</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Hình</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Mô tả</th>
                    <th>Số lượng</th> <!-- Cột mới -->
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $stt = 1;
                while ($data = mysqli_fetch_array($result_sp)) {                                    
                ?>
                <tr class="odd gradeX">
                    <td><?php echo $stt++;?></td>
                    <td><?php echo $data['TenSP'];?></td>
                    <td><?php echo $data['DonGia'];?></td>
                    <td class="center"> 
                        <img src='<?php echo $data['HinhAnh']?>' alt="" width="50px">
                    </td>
                    <td><?php echo $data['TenDM'];?></td>
                    <td><?php if ($data['TrangThai'] == 1) echo 'Mở'; else echo 'Khóa';?></td>
                    <td><?php echo $data['MoTa'];?></td>
                    <td><?php echo $data['so_luong']; ?></td> <!-- Hiển thị số lượng -->
                    <td>
                        <a href="suasanpham.php?id=<?php echo $data['MaSP']?>">Edit</a> || 
                        <a href="xoasanpham.php?id=<?php echo $data['MaSP']?>">Delete</a>
                    </td>
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
