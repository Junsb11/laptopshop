<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
} else { ?>

<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar.php"; ?>
<?php 
include '../admin/connect.php';
$tendn = $_SESSION['tendn'];
$sql_tk = "SELECT * FROM tai_khoan WHERE TenDangNhap='$tendn'";
$result_tk = mysqli_query($conn, $sql_tk);
$mk = '';
while ($data = mysqli_fetch_array($result_tk)) {
    $mk = $data['MatKhau'];
}                                    
?>
<div class="container">
    <div class="account-info">
        <h2>Thay đổi mật khẩu</h2>
        <form id="changePasswordForm" method="post" action="thaydoimatkhau.php">
            <div class="form-group">
                <label for="txtmkc">Mật khẩu cũ</label>
                <input type="password" id="txtmkc" name="txtmkc" placeholder="Nhập mật khẩu cũ..." class="medium">
            </div>
            <div class="form-group">
                <label for="txtmkm">Mật khẩu mới</label>
                <input type="password" id="txtmkm" name="txtmkm" placeholder="Nhập mật khẩu mới..." class="medium">
            </div>
            <div class="form-group">
                <label for="txtmkm_confirm">Nhập lại mật khẩu mới</label>
                <input type="password" id="txtmkm_confirm" name="txtmkm_confirm" placeholder="Nhập lại mật khẩu mới..." class="medium">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Thay đổi mật khẩu">
            </div>
        </form>
    </div>
</div>

<?php 
if (isset($_POST['submit'])) {
    if (empty($_POST['txtmkc'])) {
        echo "<script>alert('Vui lòng nhập mật khẩu cũ');</script>";
    } elseif ($_POST['txtmkc'] == $mk) {
        if (empty($_POST['txtmkm']) || empty($_POST['txtmkm_confirm'])) {
            echo "<script>alert('Vui lòng nhập mật khẩu mới và xác nhận mật khẩu');</script>";
        } elseif ($_POST['txtmkm'] != $_POST['txtmkm_confirm']) {
            echo "<script>alert('Mật khẩu mới và xác nhận mật khẩu không khớp');</script>";
        } else {
            $mkm = $_POST['txtmkm'];
            $sql_thaymk = "UPDATE tai_khoan SET MatKhau='$mkm' WHERE TenDangNhap='$tendn'";
            $result_thaymk = mysqli_query($conn, $sql_thaymk);
            if ($result_thaymk) {
                echo "<script>alert('Thay đổi mật khẩu thành công'); window.location.href='thaydoimatkhau.php';</script>";
            } else {
                echo "<script>alert('Thay đổi mật khẩu thất bại');</script>";
            }
        }
    } else {
        echo "<script>alert('Sai mật khẩu cũ');</script>";
    }
}
?>
<?php include "./inc/footer.php"; } ?>

<style>
.container {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    background: #fff;
}

.account-info h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.form-group input[type="password"],
.form-group input[type="submit"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-group input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
    border: none;
}

.form-group input[type="submit"]:hover {
    background-color: #45a049;
}
</style>

<script>
document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
    const oldPassword = document.getElementById('txtmkc').value;
    const newPassword = document.getElementById('txtmkm').value;
    const confirmPassword = document.getElementById('txtmkm_confirm').value;

    if (oldPassword === "") {
        event.preventDefault();
        alert('Vui lòng nhập mật khẩu cũ');
    } else if (newPassword === "" || confirmPassword === "") {
        event.preventDefault();
        alert('Vui lòng nhập mật khẩu mới và xác nhận mật khẩu');
    } else if (newPassword !== confirmPassword) {
        event.preventDefault();
        alert('Mật khẩu mới và xác nhận mật khẩu không khớp');
    }
});
</script>
