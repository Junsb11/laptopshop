<?php include "./inc/header.php"; ?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap');
    * {box-sizing: border-box}
    body {
        /*font-family: 'Noto Sans JP', sans-serif;*/
    }
    .a, label {
        color: DodgerBlue;
    }
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        resize: vertical;
        padding: 15px;
        border-radius: 15px;
        border: 0;
        box-shadow: 4px 4px 10px rgba(0,0,0,0.2);
    }
    input[type=text]:focus, input[type=password]:focus {
        outline: none;
    }
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }
    button {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }
    button:hover {
        opacity: 1;
    }
    .cancelbtn {
        padding: 14px 20px;
        background-color: #f44336;
    }
    .signupbtn {
        float: left;
        width: 100%;
        border-radius: 15px;
        border: 0;
        box-shadow: 4px 4px 10px rgba(0,0,0,0.2);
    }
    .container {
        padding: 16px;
    }
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }
    .error {
        color: red;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
    }
</style>
<?php include "./inc/navbar.php"; ?>

<div>
    <form action="dangky.php" method="post" onsubmit="return validateForm()">
        <div class="container">
            <h1 class="a">ĐĂNG KÝ</h1>
            <hr>
            <label for="TenDN"><b>Tên Đăng nhập</b></label>
            <input type="text" placeholder="Nhập tên đăng nhập..." name="TenDN" id="TenDN" minlength="3" maxlength="8" required>

            <label for="HoTen"><b>Họ Tên</b></label>
            <input type="text" placeholder="Nhập họ tên" name="HoTen" required>

            <label for="SDT"><b>SĐT</b></label>
            <input type="text" placeholder="Nhập SĐT..." name="SDT" id="SDT" required>

            <label for="DiaChi"><b>Địa chỉ</b></label>
            <input type="text" placeholder="Nhập địa chỉ đầy đủ (Đường/Thôn, Phường/Xã, Quận/Huyện, Tỉnh/Thành Phố)" name="DiaChi" id="DiaChi" required>

            <label for="Email"><b>Email</b></label>
            <input type="text" placeholder="Nhập Email..." name="Email" id="Email" required>

            <label for="gt"><b>Giới Tính</b></label> <br>
            <input type="radio" name="gt" value="0" checked>Nam    
            <input type="radio" name="gt" value="1">Nữ
            <br><br>

            <label for="MatKhau"><b>Mật khẩu</b></label>
            <input type="password" placeholder="Nhập Mật Khẩu" name="MatKhau" id="MatKhau" minlength="8" required>
            <label for="NhapLaiMK"><b>Nhập Lại Mật Khẩu</b></label>
            <input type="password" placeholder="Nhập Lại Mật Khẩu" name="NhapLaiMK" id="NhapLaiMK" minlength="8" required>
            <label>
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Nhớ Đăng Nhập
            </label>
            <div class="clearfix">
                <button type="submit" class="signupbtn" name="btn_dangky">Đăng ký</button>
            </div>
            <div id="error-message" class="error"></div>
        </div>
    </form>
</div>

<script>
function validateForm() {
    var sdt = document.getElementById("SDT").value;
    var email = document.getElementById("Email").value;
    var mk = document.getElementById("MatKhau").value;
    var nhaplaimk = document.getElementById("NhapLaiMK").value;

    // Check if phone number is valid
    var phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(sdt)) {
        alert("Số điện thoại không hợp lệ hoặc không đúng 10 số.");
        return false;
    }

    // Check if passwords match
    if (mk !== nhaplaimk) {
        alert("Mật khẩu không trùng khớp.");
        return false;
    }

    // Check if email is valid
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Email không hợp lệ.");
        return false;
    }

    // Check if password meets the criteria
    var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    if (!passwordPattern.test(mk)) {
        alert("Mật khẩu phải ít nhất 8 kí tự, bao gồm ít nhất một chữ thường, một chữ in hoa, một ký tự đặc biệt và một số.");
        return false;
    }

    return true;
}

function displayErrorMessage(message) {
    document.getElementById("error-message").innerText = message;
}
</script>

<?php
include "../admin/connect.php";

if(isset($_POST['btn_dangky'])){
    $tendn = $_POST['TenDN'];
    $hoten = $_POST['HoTen'];
    $sdt = $_POST['SDT'];
    $email = $_POST['Email'];
    $diachi = $_POST['DiaChi']; // Lấy từ form HTML
    $gt = $_POST['gt'];
    $mk = $_POST['MatKhau'];
    $nhaplaimk = $_POST['NhapLaiMK'];

    // Validate Địa chỉ (nếu cần)
    if(empty($diachi)) {
        echo "<script>displayErrorMessage('Vui lòng nhập địa chỉ đầy đủ.');</script>";
        return;
    }

    // Các bước kiểm tra khác (tên đăng nhập, số điện thoại, email, v.v.)
    if(strlen($tendn) < 3 || strlen($tendn) > 8) {
        echo "<script>displayErrorMessage('Tên đăng nhập phải từ 3 đến 8 kí tự.');</script>";
        return;
    }

    if(strlen($sdt) != 10 || !preg_match('/^[0-9]{10}$/', $sdt)) {
        echo "<script>displayErrorMessage('Số điện thoại không hợp lệ hoặc không đúng 10 số.');</script>";
        return;
    }

    if($mk !== $nhaplaimk) {
        echo "<script>displayErrorMessage('Mật khẩu không trùng khớp.');</script>";
        return;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>displayErrorMessage('Email không hợp lệ.');</script>";
        return;
    }

    $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
    if(!preg_match($passwordPattern, $mk)) {
        echo "<script>displayErrorMessage('Mật khẩu phải ít nhất 8 kí tự, bao gồm ít nhất một chữ thường, một chữ in hoa, một ký tự đặc biệt và một số.');</script>";
        return;
    }

    // Check if username already exists
    $sql_dn = "SELECT * FROM tai_khoan WHERE TenDangNhap='$tendn'";
    $result_dn = mysqli_query($conn, $sql_dn);
    if(mysqli_num_rows($result_dn) > 0) {
        echo "<script>displayErrorMessage('Tên đăng nhập đã tồn tại.');</script>";
        return;
    }

    // Check if phone number already exists
    $sql_sdt = "SELECT * FROM tai_khoan WHERE SDT='$sdt'";
    $result_sdt = mysqli_query($conn, $sql_sdt);
    if(mysqli_num_rows($result_sdt) > 0) {
        echo "<script>displayErrorMessage('Số điện thoại đã tồn tại.');</script>";
        return;
    }

    // Check if email already exists
    $sql_email = "SELECT * FROM tai_khoan WHERE Email='$email'";
    $result_email = mysqli_query($conn, $sql_email);
    if(mysqli_num_rows($result_email) > 0) {
        echo "<script>displayErrorMessage('Email đã tồn tại.');</script>";
        return;
    }

    $sql_insert = "INSERT INTO tai_khoan (TenDangNhap, MatKhau, HoTen, GioiTinh, SDT, Email, DiaChi, MaLoai, TrangThai)
                   VALUES ('$tendn', '$mk', '$hoten', '$gt', '$sdt', '$email', '$diachi', 1, 1)";
    $result_insert = mysqli_query($conn, $sql_insert);

    if($result_insert) {
        echo "<script>alert('Đăng kí thành công.');</script>";
        echo "<script>window.location.href='dangnhap.php';</script>";
    } else {
        echo "<script>displayErrorMessage('Có lỗi xảy ra. Vui lòng thử lại.');</script>";
    }
}
?>

<?php include "./inc/footer.php"; ?>
