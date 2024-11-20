<?php 

$idsp=filter_input(INPUT_GET,'id');

	session_start();
	 foreach ($_SESSION['cart'] as $ds) {
	 	if($ds['idsp']==$idsp);
	 	unset($_SESSION['cart'][$idsp]);
	 		
}
header("Location: listcart.php");

?>