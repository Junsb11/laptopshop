<?php 
if (!isset($_SESSION)) {
    session_start();
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>G3 Laptop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center py-3 px-xl-5">
            <!-- Logo -->
            <div class="col-lg-3 d-none d-lg-block">
                <a href="home.php" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold" style="color:#FF3333">G3 LAPTOP</h1>
                </a>
            </div>
            
            <!-- Search Form -->
            <div class="col-lg-6 col-12 text-left">
                <form action="timkiemsanpham.php" method="get" class="form-inline w-100">
                    <div class="input-group w-100">
                        <input type="text" id="txtsearch" name="txtsearch" class="form-control" placeholder="Tìm Kiếm Sản Phẩm" required aria-label="Tìm kiếm sản phẩm">
                        <div class="input-group-append">
                            <button type="submit" name="btnsearch" class="btn btn-primary" style="border-radius: 0 5px 5px 0;">
                                <i class="fa fa-search"></i> Tìm
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Cart, Notification & Warranty -->
            <div class="col-lg-3 col-6 text-right">
                <!-- Notification Icon -->
                <a href="notifications.php" class="btn border">
                    <i class="fas fa-bell text-primary"></i>
                    <span class="badge">
                        <?php 
                            if(isset($_SESSION['notifications'])) 
                                echo count($_SESSION['notifications']); 
                            else echo '0'; 
                        ?>
                    </span>
                </a>

                <!-- Warranty Request Icon -->
                <a href="yeucaubaohanh.php" class="btn border">
                    <i class="fas fa-tools text-primary"></i>
                    <span class="badge">0</span>
                </a>

                <!-- Cart Icon -->
                <a href="listcart.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">
                        <?php 
                            if(isset($_SESSION['cart'])) 
                                echo count($_SESSION['cart']); 
                            else echo '0'; 
                        ?>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
</body>
</html>
