<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['tendn'])) {
    header("Location: dangnhap.php");
} else { 
    $tendn = $_SESSION['tendn'];
?>

<?php include "./inc/header.php"; ?>
<?php include "./inc/navbar.php"; ?>
<?php 
include '../admin/connect.php';
$sql_tk = "SELECT * FROM tai_khoan WHERE TenDangNhap='$tendn'";
$result_tk = mysqli_query($conn, $sql_tk);
$data = mysqli_fetch_array($result_tk);

// Tách địa chỉ thành các phần riêng biệt
$diachi_parts = explode(', ', $data['DiaChi']);
$duongthon = isset($diachi_parts[0]) ? $diachi_parts[0] : '';
$phuongxa = isset($diachi_parts[1]) ? $diachi_parts[1] : '';
$quanhuyen = isset($diachi_parts[2]) ? $diachi_parts[2] : '';
$tinhtp = isset($diachi_parts[3]) ? $diachi_parts[3] : '';
?>

<div class="container">
    <div class="account-info">
        <h2>Thông Tin Tài Khoản</h2>
        <form id="accountForm" method="post" action="thongtintaikhoan.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="username">Tài Khoản</label>
                <input type="text" id="username" value='<?php echo $data['TenDangNhap']; ?>' disabled>
            </div>
            <div class="form-group">
                <label for="txthoten">Họ Tên</label>
                <input type="text" id="txthoten" name="txthoten" value='<?php echo $data['HoTen']; ?>' required>
            </div>
            <div class="form-group">
                <label>Giới tính</label>
                <div class="gender">
                    <label for="nam">
                        <input type="radio" id="nam" name="gt" value="1" <?php if($data['GioiTinh'] == 1) echo 'checked'; ?>> Nam
                    </label>
                    <label for="nu">
                        <input type="radio" id="nu" name="gt" value="0" <?php if($data['GioiTinh'] == 0) echo 'checked'; ?>> Nữ
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="txtsdt">Số Điện Thoại</label>
                <input type="text" id="txtsdt" name="txtsdt" value='<?php echo $data['SDT']; ?>' required>
            </div>
            <div class="form-group">
                <label for="txtemail">E-mail</label>
                <input type="text" id="txtemail" name="txtemail" value='<?php echo $data['Email']; ?>' required>
            </div>
            <div class="form-group">
                <label for="txtduongthon">Đường/Thôn</label>
                <input type="text" id="txtduongthon" name="txtduongthon" value='<?php echo $duongthon; ?>' required>
            </div>
            <div class="form-group">
                <label for="txtphuongxa">Phường/Xã</label>
                <input type="text" id="txtphuongxa" name="txtphuongxa" value='<?php echo $phuongxa; ?>' required>
            </div>
            <div class="form-group">
                <label for="txtquanhuyen">Quận/Huyện</label>
                <input type="text" id="txtquanhuyen" name="txtquanhuyen" value='<?php echo $quanhuyen; ?>' required>
            </div>
            <div class="form-group">
                <label for="txttinhtp">Tỉnh/Thành Phố</label>
                <input type="text" id="txttinhtp" name="txttinhtp" value='<?php echo $tinhtp; ?>' required>
            </div>
            <div class="form-group">
                <input type="submit" id="btnluu" name="btnluu" value="Cập nhật">
            </div>
        </form>
    </div>
</div>

<?php 
if (isset($_POST['btnluu'])) {
    $hoten = $_POST['txthoten'];
    $gt = $_POST['gt'];
    $sdt = $_POST['txtsdt'];
    $email = $_POST['txtemail'];
    $duongthon = $_POST['txtduongthon'];
    $phuongxa = $_POST['txtphuongxa'];
    $quanhuyen = $_POST['txtquanhuyen'];
    $tinhtp = $_POST['txttinhtp'];
    $diachi = $duongthon . ', ' . $phuongxa . ', ' . $quanhuyen . ', ' . $tinhtp;

    // Validate server-side
    if(strlen($sdt) != 10 || !preg_match('/^[0-9]{10}$/', $sdt)) {
        echo "<script>alert('Số điện thoại không hợp lệ hoặc không đúng 10 số.');</script>";
        return;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email không hợp lệ.');</script>";
        return;
    }

    $sql_update = "UPDATE tai_khoan SET HoTen='$hoten', GioiTinh=$gt, SDT='$sdt', Email='$email', DiaChi='$diachi' WHERE TenDangNhap='$tendn'";
    $result_update = mysqli_query($conn, $sql_update);
    if ($result_update) {
        echo "<script>alert('Cập nhật thành công'); window.location.href='thongtintaikhoan.php';</script>";
    } else {
        echo "Cập nhật thất bại";
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

.form-group input[type="text"],
.form-group input[type="submit"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.gender {
    display: flex;
    gap: 10px;
}

.gender label {
    display: flex;
    align-items: center;
    gap: 5px;
}
</style>

<script>
function validateForm() {
    var sdt = document.getElementById("txtsdt").value;
    var email = document.getElementById("txtemail").value;

    // Check if phone number is valid
    var phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(sdt)) {
        alert("Số điện thoại không hợp lệ hoặc không đúng 10 số.");
        return false;
    }

    // Check if email is valid
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Email không hợp lệ.");
        return false;
    }

    return true;
}

document.getElementById('accountForm').addEventListener('submit', function(event) {
    const initialValues = {
        hoTen: '<?php echo $data['HoTen']; ?>',
        gioiTinh: '<?php echo $data['GioiTinh']; ?>',
        sdt: '<?php echo $data['SDT']; ?>',
        email: '<?php echo $data['Email']; ?>',
        diaChi: '<?php echo $data['DiaChi']; ?>'
    };

    const currentValues = {
        hoTen: document.getElementById('txthoten').value,
        gioiTinh: document.querySelector('input[name="gt"]:checked').value,
        sdt: document.getElementById('txtsdt').value,
        email: document.getElementById('txtemail').value,
        diaChi: document.getElementById('txtduongthon').value + ', ' +
                document.getElementById('txtphuongxa').value + ', ' +
                document.getElementById('txtquanhuyen').value + ', ' +
                document.getElementById('txttinhtp').value
    };

    if (JSON.stringify(initialValues) === JSON.stringify(currentValues)) {
        event.preventDefault();
        alert('Vui lòng thay đổi thông tin để được cập nhật');
    }
});
</script>
<?php include "./inc/footer.php"; ?>
