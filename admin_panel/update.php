<?php
    include '../components/connect.php'; // Including database connection

    if (isset($_COOKIE['seller_id'])) { // Checking if seller is logged in
        $seller_id = $_COOKIE['seller_id']; // Assigning seller's ID
        
        // Fetch profile details once
        $select_profile = $conn->prepare("SELECT * FROM seller WHERE id = ?"); // Prepare SQL statement to fetch seller profile
        $select_profile->execute([$seller_id]); // Executing the prepared statement
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC); // Fetching seller profile

    } else { // Redirect to login page if seller is not logged in
        header('location:login.php'); // Redirecting to login page
        exit(); // Exiting the script
    }

    if (isset($_POST['submit'])) { // Processing form submission
        $select_seller = $conn->prepare("SELECT * FROM `seller` WHERE id = ? LIMIT 1"); // Prepare SQL statement to select seller
        $select_seller->execute([$seller_id]); // Executing the prepared statement
        $fetch_seller = $select_seller->fetch(PDO::FETCH_ASSOC); // Fetching seller details

        $prev_pass = $fetch_seller['password']; // Storing previous password
        $prev_image = $fetch_seller['image']; // Storing previous image

        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING); // Sanitizing name
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitizing email

        // Update name
        if (!empty($name)) { // Checking if name is provided
            $update_name = $conn->prepare("UPDATE `seller` SET `name` = ? WHERE `id` = ?"); // Prepare SQL statement to update name
            $update_name->execute([$name, $seller_id]); // Executing the prepared statement
            $success_msg[] = 'Name updated successfully!'; // Adding success message
        }

        // Update email
        if (!empty($email)) { // Checking if email is provided
            $select_email = $conn->prepare("SELECT * FROM `seller` WHERE `email` = ? AND `id` != ?"); // Prepare SQL statement to select email
            $select_email->execute([$email, $seller_id]); // Executing the prepared statement
            if ($select_email->rowCount() > 0) { // If email already exists
                $warning_msg[] = 'Email already exists!'; // Adding warning message
            } else {
                $update_email = $conn->prepare("UPDATE `seller` SET `email` = ? WHERE `id` = ?"); // Prepare SQL statement to update email
                $update_email->execute([$email, $seller_id]); // Executing the prepared statement
                $success_msg[] = 'Email updated successfully!'; // Adding success message
            }
        }

        // Update profile picture
        if (!empty($_FILES['image']['name'])) { // Checking if image is uploaded
            $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING); // Sanitizing image name
            $ext = pathinfo($image, PATHINFO_EXTENSION); // Getting file extension
            $rename = unique_id() . '.' . $ext; // Generating unique file name
            $image_size = $_FILES['image']['size']; // Getting image size
            $image_tmp_name = $_FILES['image']['tmp_name']; // Getting temporary image path
            $image_folder = '../uploaded_files/' . $rename; // Destination folder
            
            if ($image_size > 2000000) { // If image size exceeds 2MB
                $warning_msg[] = 'Image size is too large'; // Adding warning message
            } else {
                $update_image = $conn->prepare("UPDATE `seller` SET `image` = ? WHERE `id` = ?"); // Prepare SQL statement to update image
                $update_image->execute([$rename, $seller_id]); // Executing the prepared statement
                move_uploaded_file($image_tmp_name, $image_folder); // Moving uploaded image to destination folder

                if ($prev_image != '' && $prev_image != $rename) { // If previous image exists and is different
                    unlink('../uploaded_files/' . $prev_image); // Deleting previous image
                }
                $success_msg[] = 'Profile picture updated successfully!'; // Adding success message
            }
        }

        // Update password
        $old_pass = filter_var($_POST['old_pass'], FILTER_SANITIZE_STRING); // Sanitizing old password
        $new_pass = filter_var($_POST['new_pass'], FILTER_SANITIZE_STRING); // Sanitizing new password
        $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING); // Sanitizing confirm password

        if (!empty($old_pass)) { // Checking if old password is provided
            $old_pass_hashed = sha1($old_pass); // Hashing old password
            if ($old_pass_hashed != $prev_pass) { // If old password does not match
                $warning_msg[] = 'Old password does not match'; // Adding warning message
            } elseif ($new_pass != $cpass) { // If new password and confirm password do not match
                $warning_msg[] = 'Passwords do not match'; // Adding warning message
            } elseif (!empty($new_pass)) { // If new password is provided
                $new_pass_hashed = sha1($new_pass); // Hashing new password
                $update_pass = $conn->prepare("UPDATE `seller` SET `password` = ? WHERE `id` = ?"); // Prepare SQL statement to update password
                $update_pass->execute([$new_pass_hashed, $seller_id]); // Executing the prepared statement
                $success_msg[] = 'Password updated successfully!'; // Adding success message
            } else { // If new password is not provided
                $warning_msg[] = 'Please enter a new password'; // Adding warning message
            }
        }
    }
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Seller Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body class="header_body">

    <div class="main-container">
       <?php include '../components/admin-header.php'; ?>

       <section class="form-container">
            <div class="heading">
                <h1>Update Profile Details</h1>
                <img src="../images/seperator.png">
            </div>

            <form action="" method="post" enctype="multipart/form-data" class="register update-profile">
                <div class="img-box">
                    <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
                </div>
                <div class="flex">
                    <div class="col">
                        <div class="input-field">
                            <p>Your Name <span>*</span> </p>
                            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p>Your Email <span>*</span> </p>
                            <input type="email" name="email" placeholder="<?= $fetch_profile['email'] ; ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p>Upload profile picture<span>*</span> </p>
                            <input type="file" name="image" accept="image/*" class="box">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-field">
                            <p>Old Password <span>*</span> </p>
                            <input type="password" name="old_pass" placeholder="Enter your old password" class="box">
                        </div>
                        <div class="input-field">
                            <p>New Password <span>*</span> </p>
                            <input type="password" name="new_pass" placeholder="Enter your new password" class="box">
                        </div>
                        <div class="input-field">
                            <p>Confirm Password <span>*</span> </p>
                            <input type="password" name="cpass" placeholder="Confirm your password" class="box">
                        </div>
                    </div>
                </div>
                <input type="submit" name="submit" value="update profile" class="btn" style="margin-top: 2rem; width: 30%;">
            </form>  
        </section>
    </div>

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom js link -->
    <script src="../js/script.js"></script>
    <?php include '../components/alert.php'; ?>

</body>
</html>