<?php 
if (!isset($_SESSION)) {
    session_start();
}
include "./inc/header.php"; 
include "./inc/navbar.php"; 
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 150px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Yêu Cầu Bảo Hành</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="home.php">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Yêu cầu bảo hành</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Warranty Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <?php 
            if (isset($_SESSION['warranty']) && count($_SESSION['warranty']) > 0) { ?>
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Lý do bảo hành</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['warranty'] as $item) { ?>
                            <tr>
                                <td class="align-middle">
                                    <img src='<?php echo "../admin/" . $item['hinhanh']; ?>' alt="" style="width: 50px;"> 
                                    <?php echo $item['tensp']; ?>
                                </td>
                                <td class="align-middle"><?php echo htmlspecialchars($item['reason']); ?></td>
                                <td class="align-middle">
                                    <a href="deletewarranty.php?id=<?php echo $item['idsp']; ?>" class="btn btn-sm btn-primary">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p class="text-center">Không có sản phẩm nào trong danh sách bảo hành.</p>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Warranty End -->

<?php include "./inc/footer.php"; ?>
