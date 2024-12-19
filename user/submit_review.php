<?php
include '../admin/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $review = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_STRING);
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

    if ($username && $rating && $review && $product_id) {
        $sql = "INSERT INTO danhgia (TenDangNhap, MaSP, SoSao, NoiDung, NgayDG) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('siis', $username, $product_id, $rating, $review);

        if ($stmt->execute()) {
            header("Location: chitietsp.php?id=$product_id&success=1");
            exit;
        } else {
            header("Location: chitietsp.php?id=$product_id&error=1");
            exit;
        }
    } else {
        header("Location: chitietsp.php?id=$product_id&error=invalid_input");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
