<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include 'connect.php';

$sql_xemkm = "SELECT km.MaKM, km.TenKM, km.TuNgay, km.DenNgay, km.TrangThai, 
                     ctkm.MaSP, ctkm.TyLeKM, ctkm.GhiChu, ctkm.SoLuong
              FROM khuyen_mai km
              LEFT JOIN chi_tiet_khuyen_mai ctkm ON km.MaKM = ctkm.MaKM";

$result_dm = mysqli_query($conn, $sql_xemkm);

?>
<div class="grid_10">
    <div class="box round first grid">
        <form action="xemkhuyenmai.php" method="get">
            <h2>Danh sách khuyến mãi</h2>
            <div class="block">        
                <table class="data display datatable" id="example">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên khuyến mãi</th>
                            <th>Từ ngày</th>
                            <th>Đến ngày</th>
                            <th>Trạng thái</th>
                            <th>Mã sản phẩm</th>
                            <th>Tỷ lệ khuyến mãi</th>
                            <th>Ghi chú</th>
                            <th>Số lượng</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $stt = 1;
                        while ($data = mysqli_fetch_array($result_dm)) {										
                    ?>
                        <tr class="odd gradeX">
                            <td><?php echo $stt++;?></td>
                            <td><?php echo $data['TenKM'];?></td>
                            <td><?php echo $data['TuNgay'];?></td>
                            <td><?php echo $data['DenNgay'];?></td>
                            <td><?php if ($data['TrangThai']) echo 'Đang hoạt động'; else echo 'Ngừng hoạt động';?></td>
                            <td><?php echo $data['MaSP'];?></td>
                            <td><?php echo $data['TyLeKM'];?></td>
                            <td><?php echo $data['GhiChu'];?></td>
                            <td><?php echo $data['SoLuong'];?></td>
                            <td>
                                <a href="suakhuyenmai.php?id=<?php echo $data['MaKM']?>">Edit</a> || 
                                <a href="xoakhuyenmai.php?id=<?php echo $data['MaKM']?>" onclick="return confirm('Bạn có muốn xóa không?')">Delete</a>
                            </td>
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
