<?php
    include '../components/connect.php';

    if (isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        $seller_id = '';
        header('location:login.php');
        exit(); // Add exit after header redirection
    }

    // Fetch profile details once
    $select_profile = $conn->prepare("SELECT * FROM seller WHERE id = ?");
    $select_profile->execute([$seller_id]);
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

    
    $select_products = $conn -> prepare("SELECT * FROM `products` WHERE seller_id = ?");
    $select_products -> execute([$seller_id]);
    $total_products = $select_products -> rowCount();

    $select_orders = $conn -> prepare("SELECT * FROM `orders` WHERE seller_id = ?");
    $select_orders -> execute([$seller_id]);
    $total_orders = $select_orders -> rowCount();


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

       <section class="seller-profile">
            <div class="heading">
                <h1>Profile Details</h1>
                <img src="../images/seperator.png">
            </div>

            <div class="details">
                <div class="seller">
                    <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
                    <h3 class="name">
                        <?= $fetch_profile['name']; ?>        
                    </h3>
                        <span>seller</span>
                        <a href="update.php" class="btn">update profile</a>
                </div>
                <div class="flex">
                    <div class="box">
                        <span><?= $total_products; ?></span>
                        <p>Total Products</p>
                        <a href="view_product.php" class="btn">View Products</a>
                    </div>
                    <div class="box">
                        <span><?= $total_orders; ?></span>
                        <p>Total Orders Placed</p>
                        <a href="admin_order.php" class="btn">View Orders</a>
                    </div>
                </div>
            </div>
            
        </section>
    </div>

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom js link -->
    <script src="../js/script.js"></script>
    <?php include '../components/alert.php'; ?>

</body>
</html>