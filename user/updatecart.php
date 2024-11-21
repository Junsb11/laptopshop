<?php 

$a=filter_input(INPUT_GET,'btnUpdate');
$b=filter_input(INPUT_GET,'btntang');
$c=filter_input(INPUT_GET,'btngiam');
if(isset($a) || isset($b)|| isset($c) )
{
	session_start();
	 foreach ($_SESSION['cart'] as $ds) {
	 	$_SESSION['cart'][$ds['idsp']]['sl']= $_GET[$ds['idsp']];
	 		
}
header("Location: listcart.php");
}
?>