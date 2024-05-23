<?php

    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) { 
        $user_id = $_COOKIE['user_id'];

        // Fetch the user profile details from the database
        $select_profile = $conn->prepare("SELECT * FROM `user` WHERE id = ?");
        $select_profile->execute([$user_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

        if (!$fetch_profile) {
            // Handle the case where the profile is not found
            // Redirect the user to login.php or handle it as per your logic
            header("location: login.php");
            exit(); // Ensure that script execution stops after redirection
        }
    } else {
        // Redirect the user to login.php if not logged in
        header("location: login.php");
        exit(); // Ensure that script execution stops after redirection
    }

    $select_orders = $conn -> prepare("SELECT * FROM `orders` WHERE user_id = ?"); 
    $select_orders -> execute([$user_id]);
    $total_orders = $select_orders -> rowCount();

    $select_message = $conn -> prepare("SELECT * FROM `inquiry` WHERE user_id = ?");
    $select_message -> execute([$user_id]);
    $total_message = $select_message -> rowCount();


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - User Profile</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body >

    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Profile</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Profile</span>
        </div>
    </div>

    <section class="profile">

        <div class="heading">
            <h1>profile detail</h1>
            <img src="images/seperator_home.png">
        </div>

        <div class="details">

            <div class="user">
                <img src="uploaded_files/<?= $fetch_profile['image']; ?>">
                <h3>
                    <?= $fetch_profile['name']; ?>
                </h3>
                <p>user</p>
                <a href="update.php" class="btn">update profile</a>
            </div>

            <div class="box-container">

                <div class="box">
                    <div class="flex">
                        <i class="bx bxs-folder-minus"></i>
                        <h3>
                            <?= $total_orders ?>
                        </h3>
                    </div>
                    <a href="order.php" class="btn">view orders</a>
                </div>

                <div class="box">
                    <div class="flex">
                        <i class="bx bxs-chat"></i>
                        <h3>
                            <?= $total_message; ?>
                        </h3>
                    </div>
                    <a href="message.php" class="btn">view message</a>
                </div>
            </div>
        </div>
    </section>



    



    <?php include 'components/footer.php'; ?>    

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>

</body>