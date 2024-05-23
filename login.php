<?php

    // Include file to connect to the database
    include 'components/connect.php';

    // Check if the user ID cookie is set
    if (isset($_COOKIE['user_id'])) { 
        // Assign the user ID from the cookie to a variable
        $user_id = $_COOKIE['user_id'];
    } else {
        // If the user ID cookie is not set, set the user ID to empty string
        $user_id = '';
    }

    // Check if the 'submit' form is submitted
    if (isset($_POST['submit'])) {

        // Sanitize and retrieve the email
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Sanitize and hash the password
        $pass = sha1($_POST['password']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        // Prepare and execute an SQL query to select the user from the database
        $select_user = $conn->prepare("SELECT * FROM `user` WHERE email = ? AND password = ?");
        $select_user->execute([$email, $pass]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists
        if ($select_user->rowCount() > 0) {
            // If the user exists, set the user ID cookie for 30 days and redirect to the home page
            setcookie('user_id', $row['id'], time() + 60 * 60 * 24 * 30, '/'); 
            header('location:home.php');
        } else {
            // If the user doesn't exist, add a warning message
            $warning_msg[] = 'Invalid email or password';
        }    
    }
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - User Login</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body class="user-login">

    <?php include 'components/user_header.php'; ?>

    <div class="form-container">

        <div class="detail">
            <h1> User Login</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Login </span>
        </div>

        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3>LOGIN</h3>

            <div class="input-field">
                <p>Email <span>*</span></p>                       
                <input type="email" name="email" placeholder="Enter your email" maxlength="100" required class="box">
            </div>
            <div class="input-field">
                <p>Password<span>*</span></p>
                <input type="password" name="password" placeholder="Enter your password" maxlength="255" required class="box">
            </div>

            <p class="link">Don't have an account? <a href="register.php">Sign up now</a> </p>
            <input type="submit" name="submit" value="Login Now" class="btn">
        </form>

    </div>

    



    <?php include 'components/footer.php'; ?>    

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>

</body>