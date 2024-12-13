<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chấm công</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Chấm công nhân viên</h2>
    <form action="checkin.php" method="post">
        <button type="submit" name="action" value="checkIn">Check-in</button>
    </form>
    <form action="checkout.php" method="post">
        <button type="submit" name="action" value="checkOut">Check-out</button>
    </form>
    <p id="statusMessage"></p>
</body>
</html>
