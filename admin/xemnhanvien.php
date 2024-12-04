<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    include 'connect.php';
    $sql_xemnv = "SELECT * FROM nhan_vien ORDER BY MaNV";
    $result_nv = mysqli_query($conn, $sql_xemnv);
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Employee List</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên nhân viên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Chức vụ</th>
                    <th>Lương cơ bản</th>
                    <th>Chấm công</th>
                    <th>Trạng thái</th>
                    <th>Lương Thực Tế</th>
                    <th>Ghi chú</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $stt = 1;
                while ($data = mysqli_fetch_array($result_nv)) {                                  
                ?>
                <tr class="odd gradeX">
                    <td><?php echo $stt++;?></td>
                    <td><?php echo $data['TenNV'];?></td>
                    <td><?php echo $data['Email'];?></td>
                    <td><?php echo $data['SoDienThoai'];?></td>
                    <td><?php echo $data['ChucVu'];?></td>
                    <td><?php echo number_format($data['LuongCoBan'], 0, ',', '.');?> VND</td>
                    <td><?php echo $data['ChamCong'];?> ngày</td>
                    <td><?php echo $data['TrangThai'] == 1 ? 'Hoạt động' : 'Ngừng hoạt động';?></td>
                    <td><?php 
                        $luongThucTe = $data['LuongCoBan'] * $data['ChamCong'] / 30; 
                        echo number_format($luongThucTe, 0, ',', '.');?> VND
                    </td>
                    <td><?php echo $data['GhiChu'];?></td>
                    <td>
                        <a href="suanhanvien.php?id=<?php echo $data['MaNV']?>">Edit</a> || 
                        <a href="xoanhanvien.php?id=<?php echo $data['MaNV']?>">Delete</a>
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
