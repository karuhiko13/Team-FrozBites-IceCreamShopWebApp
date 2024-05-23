<?php

    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) { 
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
        header('location:login.php');
        exit();
    }

    if (isset($_GET['get_id'])) { 
        $get_id = $_GET['get_id'];
    }else{
        $get_id = '';
        header('location:order.php');
    }

    if (isset($_POST['cancel'])) { 
        $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
        $update_order->execute(['Canceled', $get_id]);

        header('location:order.php');
        exit();
    }

    
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Order Details</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet"   type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Order Detail</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Order</span>
        </div>
    </div>
    
    <div class="order-detail">

        <div class="heading">
            <h1>View Order</h1>
            <img src="images/seperator_home.png">
        </div>

        <div class="box-container">

            <?php
                $grand_total = 0;
                $select_order = $conn->prepare("SELECT * FROM `orders` WHERE id=? LIMIT 1");
                $select_order->execute([$get_id]);

                if ($select_order->rowCount() > 0) {

                    while($fetch_order = $select_order->fetch (PDO::FETCH_ASSOC)){
                        $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                        $select_product->execute([$fetch_order ['product_id']]);


                        if ($select_product->rowCount() > 0) {
                            while($fetch_product = $select_product->fetch(PDO:: FETCH_ASSOC)) {
                                $sub_total = ($fetch_order ['price']*$fetch_order ['qty']); 
                                $grand_total += $sub_total;
            ?>
            <div class="box">
                <div class="col">
                    <p class="title"> <i class="bx bxs-calendar-alt"></i>
                        <?= $fetch_order ['date']; ?>
                    </p>
                    <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                   
                    <h3 class="name" style="text-align: center;">
                        <?= $fetch_product['name']; ?>
                    </h3>
                    <p class="grand-total">total amount payable: <span> $<?= $grand_total; ?></span>
                    </p>
                </div>
                <div class="col">
                    <p class="title">billing address</p>
                    <p class="user"><i class="fas fa-user"></i>
                        <?= $fetch_order ['name' ]; ?>
                    </p>
                    <p class="user"><i class="fas fa-phone"></i>
                        <?= $fetch_order['number']; ?>
                    </p>
                    <p class="user" style="text-transform: lowercase;"><i class="fas fa-envelope"></i>
                        <?= $fetch_order ['email']; ?>
                    </p>
                    <p class="user"><i class="fas fa-map-marker-alt"></i>
                        <?= $fetch_order ['address'];?>
                    </p>
                    <p class="status" style="color: <?php if($fetch_order['status'] == 'Order Delivered'){echo "green";} elseif ($fetch_order['status']=='Canceled' ) {echo "red" ; } else {echo "orange" ; } ?>">
                        <?= $fetch_order['status']; ?>
                    </p>
                    <?php 
                        if($fetch_order['status'] == 'Canceled'){ ?>
                            <a href="menu.php" class="btn">order again</a>
                        <?php } elseif ($fetch_order['status'] == 'Order Delivered') { ?>
                            <a href="menu.php" class="btn">order again</a>
                        <?php } else { ?>
                            <form action="" method="post">
                                <button type="submit" name="cancel" class="btn" onclick="return confirm('Do you want to cancel this order?');">Cancel</button>
                            </form>
                    <?php } ?>
                </div>
            </div>


            <?php
                            }
                        }
                    }
                }else{ 
                    echo '<p class="empty">No orders placed</p>';
                }

            ?>
            
        </div>
        
    </div>



    <?php include 'components/footer.php'; ?>    

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>

</body>