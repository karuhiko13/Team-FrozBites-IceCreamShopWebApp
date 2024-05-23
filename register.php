<?php

    include 'components/connect.php'; // Including database connection file

    if (isset($_COOKIE['user_id'])) { // Checking if user_id cookie is set
        $user_id = $_COOKIE['user_id']; // Assigning user_id cookie value to $user_id variable if set
    } else {
        $user_id = ''; // Assigning an empty string to $user_id variable if user_id cookie is not set
    }

    if (isset($_POST['submit'])) { // Checking if the form is submitted
        $id = unique_id(); // Generating a unique ID for the user
        
        // Sanitizing and filtering the input data received from the form fields
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $pass = sha1($_POST['password']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $cpass = sha1($_POST['confirm_password']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id() . '.' . $ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_files/' . $rename;

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; // Allowed image extensions
        
        // Ensure the uploaded file is an image and within size limits
        if (!in_array($ext, $allowed_extensions)) {
            $warning_msg[] = 'Invalid image format!';
        } elseif ($image_size > 10000000) { // Example size limit: 10MB
            $warning_msg[] = 'Image size is too large!';
        } else {
            // Checking if email already exists in the database
            $select_seller = $conn->prepare("SELECT * FROM `user` WHERE email = ?");
            $select_seller->execute([$email]);
            
            if ($select_seller->rowCount() > 0) { // If email exists, add warning message
                $warning_msg[] = 'Email already exists!';
            } else {
                if ($pass !== $cpass) { // If passwords don't match, add warning message
                    $warning_msg[] = 'Password does not match, try again!';
                } else {
                    // Inserting user data into the database
                    $insert_seller = $conn->prepare("INSERT INTO `user` (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)");
                    $insert_seller->execute([$id, $name, $email, $pass, $rename]);
                    
                    // Moving uploaded image to server
                    move_uploaded_file($image_tmp_name, $image_folder);
                    
                    // Adding success message
                    $success_msg[] = 'Registration successful!';
                }
            }
        }
    }
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - User Registration</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body class="user-register">

    <?php include 'components/user_header.php'; ?>
<!--
    <div class="banner">
        <div class="detail">
            <h1>Register</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br> tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            </p>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>about us </span>
        </div>
    </div>

-->

    <div class="form-container">

        <div class="detail">
            <h1>User Registration</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Register </span>
        </div>

        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>Sign Up</h3>
            <div class="flex">

                <div class="col">
                    <div class="input-field">
                        <p>Full Name <span>*</span></p>
                        <input type="text" name="name" placeholder="Enter your full name" maxlength="50" required class="box">
                    </div>

                    <div class="input-field">
                        <p>Email <span>*</span></p>                       
                        <input type="email" name="email" placeholder="Enter your email" maxlength="100" required class="box">
                    </div>
                </div>

                <div class="col">
                    <div class="input-field">
                        <p>Password<span>*</span></p>
                        <input type="password" name="password" placeholder="Enter your password" maxlength="255" required class="box">
                    </div>

                    <div class="input-field">
                        <p>Confirm Password <span>*</span></p>
                        <input type="password" name="confirm_password" placeholder="Re-enter your password" maxlength="255" required class="box">
                    </div>
                </div>
            </div>
            <div class="input-field">
                <p>Profile Picture <span>*</span></p>
                <input type="file" name="image" accept="image/*" required class="box">
            </div>
            <p class="link">Already have an account? <a href="login.php">Login now</a> </p>
            <input type="submit" name="submit" value="Sign up now" class="btn">
        </form>
    </div>

    



    <?php include 'components/footer.php'; ?>    

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>

</body>