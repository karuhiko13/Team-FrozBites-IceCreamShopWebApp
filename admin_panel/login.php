<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $pass = sha1($_POST['password']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    // Corrected SQL query with proper quote around the table name
    $select_seller = $conn->prepare("SELECT * FROM `seller` WHERE email = ? AND password = ?");
    $select_seller->execute([$email, $pass]);
    $row = $select_seller->fetch(PDO::FETCH_ASSOC);

    if ($select_seller->rowCount() > 0) {
        setcookie('seller_id', $row['id'], time() + 60 * 60 * 24 * 30, '/'); 
        header('location:dashboard.php');
    } else {
        $warning_msg[] = 'Invalid email or password';
    }    
}
?>





<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>FrozBites - Seller Login</title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
</head>
<body class="login-page">

    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3>SELLER LOGIN</h3>

            <div class="input-field">
                <p>Email <span>*</span></p>                       
                <input type="email" name="email" placeholder="Enter your email" maxlength="100" required class="box">
            </div>
            <div class="input-field">
                <p>Password<span>*</span></p>
                <input type="password" name="password" placeholder="Enter your password" maxlength="255" required class="box">
            </div>

            <p class="link">Don't have an account? <a href="register.php">Join us now</a> </p>
            <input type="submit" name="submit" value="Login Now" class="btn">
        </form>
    </div>

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom js link -->
    <script src="../js/script.js"></script>
    <?php include '../components/alert.php'; ?>

</body>
</html>