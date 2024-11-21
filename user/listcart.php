<?php 
if (!isset($_SESSION))
{
    session_start();
}
include "./inc/header.php"; ?>
<?php include "./inc/navbar.php"; ?>


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 150px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Giỏ Hàng</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Giỏ hàng</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
            	<form method="get" action="updatecart.php">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Xóa</th>
                        </tr>
                        <?php 
$tong=0;
if (isset($_SESSION['cart']))
{
    
    
    
 ?>
                    </thead>
                    <tbody class="align-middle">
                    
                    <?php foreach ($_SESSION['cart'] as $ds) { ?>
                    	
                 
                        <tr>
                            <td class="align-middle"><img src='<?php echo "../admin/".$ds['hinhanh'] ?>' alt="" style="width: 50px;"> <?php echo $ds['tensp'] ?></td>
                            <td class="align-middle"><?php echo number_format($ds['dongia'],0,'.','.'); ?></td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" name="btngiam">
                                        <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary text-center" value='<?php echo $ds['sl'] ;?>' name='<?php echo $ds['idsp'];?>'>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus" name="btntang">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    
                                </div>
                            </td>
                            <td class="align-middle"><?php echo number_format($ds['dongia']*$ds['sl'],0,'.','.'); ?></td>
                            <td class="align-middle"><a href="deletecart.php?id=<?php echo $ds['idsp']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></a></td>
                        </tr>
                    <?php $tong=$tong+$ds['dongia']*$ds['sl']; } ?>
                    <tr>
                    	<td></td>
                    	<td></td>
                    	<td><button name="btnUpdate" >Cập nhật</button></td>
                    	<td></td>
                    	<td></td>
                    </tr>                     
                    </tbody>
                </table>
                </form>
            </div>

        <?php } ?>
            <div class="col-lg-4">
                <form class="mb-5" method="get" action="listcart.php">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Mã giảm giá">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Áp dụng mã</button>
                        </div>
                    </div>
                
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Tóm tắt giỏ hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Tổng tiền</h6>
                            <h6 class="font-weight-medium"><?php echo number_format($tong,0,'.','.'); ?> vnđ</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Phí vận chuyển</h6>
                            <h6 class="font-weight-medium"><?php if($tong==0) $ship=0;else $ship=30000;echo number_format($ship,0,'.','.'); ?> vnđ</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Tổng cộng</h5>
                            <h5 class="font-weight-bold"><?php echo number_format($tong+$ship,0,'.','.'); ?>vnđ</h5>
                        </div>
                        <button name="btnthanhtoan" class="btn btn-block btn-primary my-3 py-3">Thanh Toán</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Cart End -->
    <?php 
    if(isset($_GET['btnthanhtoan'])) echo "<script> window.location.href='dathang.php'; </script>";
                      ?>

<?php include "./inc/footer.php"; ?>