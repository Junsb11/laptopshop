<?php
    include 'connect.php';
    $id = $_GET['id'];
    $sql_xoavien = "DELETE FROM nhan_vien WHERE MaNV = $id";

    if (mysqli_query($conn, $sql_xoavien)) {
        echo "<script>alert('Xóa nhân viên thành công'); window.location='xemnhanvien.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa nhân viên'); window.location='xemnhanvien.php';</script>";
    }
?>
