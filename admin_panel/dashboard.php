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
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body class="header_body">

    <div class="main-container">
       <?php include '../components/admin-header.php'; ?>

       <section class="dashboard">
            <div class="heading">
                <h1>DASHBOARD</h1>
                <img src="../images/seperator.png">
            </div>
            <div class="box-container">
                <div class="box">
                    <h3>Welcome!</h3>
                    <p>
                        <?= $fetch_profile['name']; ?>
                    </p>
                    <a href="update.php" class="btn">update profile</a>
                </div>
                <div class="box">
                    <?php
                        $select_message = $conn->prepare("SELECT * FROM `inquiry`"); 
                        $select_message->execute();
                        $number_of_msg = $select_message->rowCount();
                    ?>
                    <h3>
                        <?= $number_of_msg; ?>
                    </h3>
                    <p>Unread Messages</p>
                    <a href="admin_message.php" class="btn">View messages</a>
                </div>
                <div class="box">
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?"); 
                        $select_products->execute([$seller_id]);
                        $number_of_products = $select_products->rowCount();
                    ?>
                    <h3>
                        <?= $number_of_products; ?>
                    </h3>
                    <p>Products Added</p>
                    <a href="add_product.php" class="btn">Add product</a>
                </div>
                <div class="box">
                    <?php
                        $select_active_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ? AND status = ?");
                        $select_active_products->execute([$seller_id, 'active']);
                        $number_of_active_products = $select_active_products->rowCount();
                    ?>
                    <h3>
                        <?= $number_of_active_products; ?>
                    </h3>
                    <p>Total Active Products</p>
                    <a href="view_product.php" class="btn">View Active Product</a>
                </div>

                <div class="box">
                    <?php
                        $select_deactive_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id= ? AND status = ?");
                        $select_deactive_products->execute([$seller_id, 'inactive']);
                        $number_of_deactive_products = $select_deactive_products->rowCount();
                    ?>
                    <h3>
                        <?= $number_of_deactive_products; ?>
                    </h3>
                    <p>Total Inactive Products</p>
                    <a href="view_product.php" class="btn">View Inactive Product</a>
                </div>

                <div class="box">
                    <?php
                        $select_users = $conn->prepare("SELECT * FROM `user`");
                        $select_users->execute();
                        $number_of_users = $select_users->rowCount();
                    ?>
                    <h3>
                        <?= $number_of_users; ?>
                    </h3>
                    <p>User Accounts</p>
                    <a href="user_accounts.php" class="btn">View Users</a>
                </div>

                <div class="box">
                    <?php
                        $select_sellers = $conn->prepare("SELECT * FROM `seller`");
                        $select_sellers->execute();
                        $number_of_sellers = $select_sellers->rowCount();
                    ?>
                    <h3>
                        <?= $number_of_sellers; ?>
                    </h3>
                    <p>Seller Accounts</p>
                    <a href="user_accounts.php" class="btn">View sellers</a>
                </div>

                <div class="box">
                    <?php
                        $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?" );
                        $select_orders->execute([$seller_id]);
                        $number_of_orders = $select_orders->rowCount();
                    ?>
                    <h3>
                        <?= $number_of_orders; ?>
                    </h3>
                    <p>Total Orders Placed</p>
                    <a href="admin_order.php" class="btn">View Total Orders</a>
                </div>

                <div class="box">
                    <?php
                        $select_confirm_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ? AND status = ?");
                        $select_confirm_orders->execute([$seller_id, 'in progress']);
                        $number_of_confirm_orders = $select_confirm_orders->rowCount();
                    ?>
                    <h3>
                        <?= $number_of_confirm_orders; ?>
                    </h3>
                    <p>Total Confirmed Orders</p>
                    <a href="admin_order.php" class="btn">View Confirmed Orders</a>
                </div>

                <div class="box">
                    <?php
                        $select_canceled_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ? AND status = ?");
                        $select_canceled_orders->execute([$seller_id, 'canceled']);
                        $number_of_canceled_orders = $select_canceled_orders->rowCount();
                    ?>
                    <h3>
                        <?= $number_of_canceled_orders; ?>
                    </h3>
                    <p>Total Canceled Orders</p>
                    <a href="admin_order.php" class="btn">Cancel Order</a>
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