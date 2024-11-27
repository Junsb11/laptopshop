<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar_slide.php"; ?>
    <?php
        include '../admin/connect.php';
        $sql_xemsp="SELECT * FROM san_pham where  TrangThai=1 LIMIT 0,8";
        $result_sp=mysqli_query($conn,$sql_xemsp);
        ?>
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm mới</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php 
                    $stt=1;
                while ($data1=mysqli_fetch_array($result_sp)) {                                  
                ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src='<?php echo "../admin/".$data1['HinhAnh'] ?>' alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo $data1['TenSP']; ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php echo number_format($data1['DonGia'],0,'.','.');    ?> vnđ</h6><h6 class="text-muted ml-2"></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="chitietsp.php?id=<?php echo $data1['MaSP']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                        <a href="cart.php?id=<?php echo $data1['MaSP']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>
            <?php } ?>
           
        </div>
    </div>

    <?php
        include '../admin/connect.php';
        $sql_xemsp_banchay="SELECT * FROM san_pham where TrangThai=1 LIMIT 0,8";
        $result_sp_banchay=mysqli_query($conn,$sql_xemsp_banchay);
        ?>
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm bán chạy</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">

            <?php 
                while ($data2=mysqli_fetch_array($result_sp_banchay)) {                                  
                ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src='<?php echo "../admin/".$data2['HinhAnh'] ?>' alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo $data2['TenSP']; ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php echo number_format($data2['DonGia'],0,'.','.'); ?> vnđ</h6><h6 class="text-muted ml-2"></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="chitietsp.php?id=<?php echo $data2['MaSP']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                        <a href="cart.php?id=<?php echo $data2['MaSP']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>
        <?php } ?>
            

        </div>
    </div>
    


<?php include "./inc/footer.php"; ?>