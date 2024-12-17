<?php
    if(!isset($_SESSION)) {
     session_start();}
        include '../admin/connect.php';
        $sql_xemdm="SELECT * FROM danh_muc where TrangThai=1";
        $result_dm=mysqli_query($conn,$sql_xemdm);
         
        ?>
        

    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Danh mục sản phẩm</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                        <?php 
                while ($data=mysqli_fetch_array($result_dm)) {                                  
                ?>

                        <a href="sanphamtheodanhmuc.php?madm=<?php echo $data['MaDM'];?>" class="nav-item nav-link"><?php echo $data['TenDM']; ?></a>
                    <?php } ?>    
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="home.php" class="nav-item nav-link">Trang chủ</a>
                            <a href="sanpham.php" class="nav-item nav-link active">Sản Phẩm</a>
                            <a href="listcart.php" class="nav-item nav-link">Giỏ hàng</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Tài khoản</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="thongtintaikhoan.php" class="dropdown-item">Thông tin tài khoản</a>
                                    <a href="thaydoimatkhau.php" class="dropdown-item">Thay đổi mật khẩu</a>
                                </div>
                            </div>
                            <a href="dsdonhang.php" class="nav-item nav-link">Lịch sử đơn hàng</a>
                            <a href="dsbaohanh.php" class="nav-item nav-link">Lịch sử bảo hành`</a>
                        </div>
                        
                        <div class="navbar-nav ml-auto py-0">
                            <?php if(isset($_SESSION['tendn'])){ echo 'xin chào '.$_SESSION['tendn'];
                            echo '<a href="./thoat.php" class="nav-item nav-link">Thoát</a>';}
                            else { echo '
                            <a href="./dangnhap.php" class="nav-item nav-link">Đăng nhập</a>
                            <a href="./dangky.php" class="nav-item nav-link">Đăng ký</a>
                            ';} ?>
                        </div>
                    </div>
                </nav>
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="height: 410px;">
                            <img class="img-fluid" src="./img/banner01.png" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">GIẢM GIÁ 10% CHO ĐƠN HÀNG ĐẦU TIÊN CỦA BẠN</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Laptop Gaming</h3>
                                    <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" style="height: 410px;">
                            <img class="img-fluid" src="./img/banner02.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">GIẢM GIÁ 10% CHO ĐƠN HÀNG ĐẦU TIÊN CỦA BẠN</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Giá cả hợp lí</h3>
                                    <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
 </div>
                
      </div>
        </div>
    </div>

                
