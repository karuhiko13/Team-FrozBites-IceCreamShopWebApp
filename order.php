<?php

    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) { 
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
        header('location:login.php');
        exit();
    }

    
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - My Orders</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>My Orders</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Order </span>
        </div>
    </div>
    
    <div class="orders">

        <div class="heading">
            <h1>My Orders</h1>
            <img src="images/seperator_home.png">
        </div>

        <div class="box-container">

            <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
                $select_orders->execute([$user_id]);

                if ($select_orders->rowCount() > 0) {
                    while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {

                        $product_id = $fetch_orders['product_id'];
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_products->execute([$product_id]);

                        if ($select_products->rowCount() > 0) {
                            while($fetch_products = $select_products->fetch(PDO:: FETCH_ASSOC)){
                                $total_price = $fetch_products['price'] * $fetch_orders['qty'];
                
            ?>

            <div class="box" <?php if($fetch_orders['status']=='Canceled' ) {echo 'style="border: 2px solid red"';} elseif ($fetch_orders['status']=='Order Delivered') { echo 'style="border: 2px solid green"'; } ?>>
                <a href="view_order.php?get_id=<?= $fetch_orders['id']; ?>">
                    <img src="uploaded_files/<?= $fetch_products['image'] ?>" class="image">
                </a>

                <div class="content">
                    <img src="images/shape-19.png" class="shap">
                    <p class="date"> <i class="bx bxs-calender-alt"></i>
                        <?= $fetch_orders['date'];?>
                    </p>
                    <div class="row">
                        <h3 class="name">
                            <?= $fetch_products['name'] ?>
                        </h3>
                        <p class="price">Price to pay: $<?= $fetch_orders['price'] ?><span></span>
                        </p>
                        <p style="font-size: 1rem">
                            Quantity: <?= $fetch_orders['qty'] ?>
                        </p>
                        <p class="status" style="color: <?php if($fetch_orders['status'] == 'Order Delivered'){echo "green"; } elseif
                            ($fetch_orders['status']=='Canceled' ) {echo "red" ;}else{echo "orange" ;} ?>">
                            <?= $fetch_orders['status']; ?>
                        </p>
                    </div>
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