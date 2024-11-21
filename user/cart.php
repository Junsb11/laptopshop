<?php 
if (!isset($_SESSION)) {
    session_start();
}
include '../admin/connect.php';
$masp = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$quantity = filter_input(INPUT_GET, 'quantity', FILTER_SANITIZE_NUMBER_INT);
$thanhtien = 0;

if (isset($masp) && isset($quantity) && $quantity > 0) {
    $sql_sp = "SELECT * FROM san_pham WHERE MaSP='$masp'";
    $result_sp = mysqli_query($conn, $sql_sp);
    $row_sp = mysqli_fetch_array($result_sp);

    if (!empty($_SESSION['cart'][$masp])) {
        $_SESSION['cart'][$masp]['sl'] += $quantity;
    } else {
        $_SESSION['cart'][$masp] = array(
            "idsp" => $row_sp['MaSP'],
            "tensp" => $row_sp['TenSP'],
            "sl" => $quantity,
            "dongia" => $row_sp['DonGia'],
            "hinhanh" => $row_sp['HinhAnh']
        );
    }
    header("Location: listcart.php");
} else {
    header("Location: chitietsp.php?id=$masp&error=invalid_quantity");
}
if(isset($masp))
{
    $sql_sp="SELECT * from san_pham where MaSP='$masp'";
    
    $result_sp=mysqli_query($conn,$sql_sp);
    $row_sp=mysqli_fetch_array($result_sp);
    if(!empty($_SESSION['cart']))
    {

          $_SESSION['cart'][$masp]=array("idsp"=>$row_sp['MaSP'],"tensp"=>$row_sp['TenSP'],"sl"=>$_SESSION['cart'][$masp]['sl'],"dongia"=>$row_sp['DonGia'],"hinhanh"=>$row_sp['HinhAnh']);

    }
    else
    {
          $_SESSION['cart'][$masp]=array("idsp"=>$row_sp['MaSP'],"tensp"=>$row_sp['TenSP'],"sl"=>1,"dongia"=>$row_sp['DonGia'],"hinhanh"=>$row_sp['HinhAnh']);
    }

    header ("Location: listcart.php");
}
?>