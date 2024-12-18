<?php
include '../admin/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idsp = $_POST['MaSP'];
    $rating = $_POST['rating'];
    $comment = htmlspecialchars($_POST['comment']);

    $sql_insert_review = "INSERT INTO danhgia (MaSP, SoSao, NoiDung, TenDangNhap, NgayDG) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql_insert_review);
    $stmt->bind_param('iiss', $idsp, $rating, $comment, $_SESSION['username']);
    $stmt->execute();

    header("Location: chitietsp.php?id=$idsp");
    exit;
}
?>
