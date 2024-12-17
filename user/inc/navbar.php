<!-- Navbar Start -->
 <?php
// if(!isset($_SESSION)) 
//     { 
        try {
            // session_start(); 
         } catch (Exception $e) {
             echo "a";
         } 
//     } 
        include '../admin/connect.php';
        $sql_xemdm="SELECT * FROM danh_muc where TrangThai=1";
        $result_dm=mysqli_query($conn,$sql_xemdm);
        ?>
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Danh mục sản phẩm</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                     <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                        <!-- <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown">Dresses <i class="fa fa-angle-down float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                                <a href="" class="dropdown-item">Men's Dresses</a>
                                <a href="" class="dropdown-item">Women's Dresses</a>
                                <a href="" class="dropdown-item">Baby's Dresses</a>
                            </div>
                        </div> -->
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
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">G4</span>Shop</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
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
            </div>
        </div>
    </div>
    <!-- Navbar End -->