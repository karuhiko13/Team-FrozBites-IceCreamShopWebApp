<?php
include '../components/connect.php'; // Including database connection

if (isset($_POST['submit'])) { // Checking if form is submitted
    $id = unique_id(); // Generating unique ID for the seller
    $name = $_POST['name']; // Getting seller's name from form
    $name = filter_var($name, FILTER_SANITIZE_STRING); // Sanitizing seller's name

    $email = $_POST['email']; // Getting seller's email from form
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitizing seller's email

    $pass = sha1($_POST['password']); // Hashing the password using SHA1 encryption
    $pass = filter_var($pass, FILTER_SANITIZE_STRING); // Sanitizing password

    $cpass = sha1($_POST['confirm_password']); // Hashing the confirm password using SHA1 encryption
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING); // Sanitizing confirm password

    $image = $_FILES['image']['name']; // Getting name of the uploaded image
    $image = filter_var($image, FILTER_SANITIZE_STRING); // Sanitizing image name
    $ext = pathinfo($image, PATHINFO_EXTENSION); // Getting extension of the image
    $rename = unique_id() . '.' . $ext; // Generating unique file name for the image
    $image_size = $_FILES['image']['size']; // Getting size of the uploaded image
    $image_tmp_name = $_FILES['image']['tmp_name']; // Getting temporary path of the uploaded image
    $image_folder = '../uploaded_files/' . $rename; // Setting destination folder for the image

    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; // Array of allowed image extensions
    
    // Ensure the uploaded file is an image and within size limits
    if (!in_array($ext, $allowed_extensions)) { // If uploaded file is not of allowed extensions
        $warning_msg[] = 'Invalid image format!'; // Adding warning message
    } elseif ($image_size > 2000000) { // If image size exceeds 2MB
        $warning_msg[] = 'Image size is too large!'; // Adding warning message
    } else {
        $select_seller = $conn->prepare("SELECT * FROM `seller` WHERE email = ?"); // Prepare SQL statement to check if email already exists
        $select_seller->execute([$email]); // Executing the prepared statement
        
        if ($select_seller->rowCount() > 0) { // If email already exists in database
            $warning_msg[] = 'Email already exists!'; // Adding warning message
        } else {
            if ($pass !== $cpass) { // If password and confirm password do not match
                $warning_msg[] = 'Password does not match, try again!'; // Adding warning message
            } else {
                $insert_seller = $conn->prepare("INSERT INTO `seller` (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)"); // Prepare SQL statement to insert seller data into database
                $insert_seller->execute([$id, $name, $email, $pass, $rename]); // Executing the prepared statement to insert seller data
                move_uploaded_file($image_tmp_name, $image_folder); // Moving uploaded image to destination folder
                $success_msg[] = 'Seller registration successful!'; // Adding success message
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
	<title>FrozBites - Seller Sign Up</title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
</head>
<body class="registration-page">

    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>SELLER REGISTRATION</h3>
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
            <input type="submit" name="submit" value="register now" class="btn">
        </form>
    </div>

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom js link -->
    <script src="../js/script.js"></script>
    <?php include '../components/alert.php'; ?>

</body>
</html>