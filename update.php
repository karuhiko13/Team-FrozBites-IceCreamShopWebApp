<?php

    include 'components/connect.php'; // Including database connection file

    if (isset($_COOKIE['user_id'])) { // Checking if user_id cookie is set
        $user_id = $_COOKIE['user_id']; // Assigning user_id cookie value to $user_id variable if set
    } else {
        $user_id = 'location:login.php'; // Redirecting to login page if user_id cookie is not set
        exit(); // Exiting script
    }

    if (isset($_POST['submit'])) { // Checking if the form is submitted

        $conn->beginTransaction(); // Begin transaction

        $valid_input = true; // Flag to track if all inputs are valid

        // Fetch user data
        $select_user = $conn->prepare("SELECT * FROM `user` WHERE id = ? LIMIT 1");
        $select_user->execute([$user_id]);
        $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

        $prev_pass = $fetch_user['password'];
        $prev_image = $fetch_user['image'];

        // Sanitizing and filtering input data
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $old_pass = filter_var($_POST['old_pass'], FILTER_SANITIZE_STRING);
        $new_pass = filter_var($_POST['new_pass'], FILTER_SANITIZE_STRING);
        $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);

        // Validate name
        if (!empty($name)) {
            $update_name = $conn->prepare("UPDATE `user` SET `name` = ? WHERE `id` = ?");
            $update_name->execute([$name, $user_id]);
            $success_msg[] = 'Name updated successfully!';
        }

        // Validate email
        if (!empty($email)) {
            $select_email = $conn->prepare("SELECT * FROM `user` WHERE `email` = ? AND `id` != ?");
            $select_email->execute([$email, $user_id]);
            if ($select_email->rowCount() > 0) {
                $valid_input = false;
                $warning_msg[] = 'Email already exists!';
            } else {
                $update_email = $conn->prepare("UPDATE `user` SET `email` = ? WHERE `id` = ?");
                $update_email->execute([$email, $user_id]);
                $success_msg[] = 'Email updated successfully!';
            }
        }

        // Validate profile picture
        if (!empty($_FILES['image']['name'])) {
            $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $rename = unique_id() . '.' . $ext;
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = 'uploaded_files/' . $rename;
            
            if ($image_size > 10000000) {
                $valid_input = false;
                $warning_msg[] = 'Image size is too large';
            } else {
                $update_image = $conn->prepare("UPDATE `user` SET `image` = ? WHERE `id` = ?");
                $update_image->execute([$rename, $user_id]);
                move_uploaded_file($image_tmp_name, $image_folder);

                // Check if previous image exists before unlinking
                if ($prev_image != '' && $prev_image != $rename && file_exists('uploaded_files/' . $prev_image)) {
                    unlink('uploaded_files/' . $prev_image);
                }
                $success_msg[] = 'Profile picture updated successfully!';
            }
        }

        // Validate password
        if (!empty($old_pass) && !empty($new_pass) && !empty($cpass)) {
            $old_pass_hashed = sha1($old_pass);
            if ($old_pass_hashed != $prev_pass) {
                $valid_input = false;
                $warning_msg[] = 'Old password does not match';
            } elseif ($new_pass != $cpass) {
                $valid_input = false;
                $warning_msg[] = 'Passwords do not match';
            } else {
                $new_pass_hashed = sha1($new_pass);
                $update_pass = $conn->prepare("UPDATE `user` SET `password` = ? WHERE `id` = ?");
                $update_pass->execute([$new_pass_hashed, $user_id]);
                $success_msg[] = 'Password updated successfully!';
            }
        }

        // Final data update if all inputs are valid
        if ($valid_input) {
            $conn->commit(); // Commit the transaction
        } else {
            $conn->rollback(); // Rollback the transaction if any input is invalid
        }
    }

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - User Profile Update</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body class="update-profile">

    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Update Profile</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Update Profile</span>
        </div>
    </div>

    <section class="form-container">
            <div class="heading">
                <h1>Update Profile Details</h1>
                <img src="images/seperator_home.png">
            </div>

            <form action="" method="post" enctype="multipart/form-data" class="register update-profile">
                <div class="img-box">
                    <img src="uploaded_files/<?= $fetch_profile['image']; ?>">
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



    



    <?php include 'components/footer.php'; ?>    

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>

</body>