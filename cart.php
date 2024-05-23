<?php

    // Include file to connect to the database
    include 'components/connect.php';

     // Check if the user ID cookie is set
    if (isset($_COOKIE['user_id'])) { 
        // Assign the user ID from the cookie to a variable
        $user_id = $_COOKIE['user_id'];
    }else{
        // If the user ID cookie is not set, redirect to the login page
        $user_id = 'location:login.php';
    }

    // Update quantity in the cart
    if (isset($_POST['update_cart'])) {

        // Get the cart ID and sanitize it
        $cart_id = $_POST['cart_id'];
        $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

        // Get the quantity and sanitize it
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);

        // Prepare and execute an SQL statement to update the quantity in the cart
        $update_qty = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id = ?");
        $update_qty->execute([$qty, $cart_id]);
        $success_msg[] = 'Quantity Updated';
    }

    // Delete products from the cart
    if (isset($_POST['delete_item'])) {

            // Get the cart ID and sanitize it
            $cart_id = $_POST['cart_id'];
            $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

            // Prepare and execute an SQL statement to verify if the item exists in the cart
            $verify_delete_item = $conn->prepare("SELECT * FROM `cart` WHERE id = ?"); 
            $verify_delete_item->execute([$cart_id]);

            // Check if the item exists in the cart
            if ($verify_delete_item->rowCount() > 0) {

                // If the item exists, prepare and execute an SQL statement to delete it from the cart
                $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
                $delete_cart_id->execute([$cart_id]);
                $success_msg[] = 'Item removed from cart';
            }else{ 
                $warning_msg[] = 'Item already removed';}
        }

    // Empty the cart
    if (isset($_POST['empty_cart'])) {

        // Prepare and execute an SQL statement to verify if the cart is not empty
        $verify_empty_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?"); 
        $verify_empty_item->execute([$user_id]);

         // Check if the cart is not empty
        if ($verify_empty_item->rowCount() > 0) {
            
            // If the cart is not empty, prepare and execute an SQL statement to empty it
            $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart_id->execute([$user_id]);

            $success_msg[] = 'Cart emptied successfully';
        }else{
            $warning_msg[] = 'Cart is already empty';
        }
    }

    
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - My Cart</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body class="cart">

    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Cart</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Cart</span>
        </div>
    </div>

    <div class="products">

        <div class="heading">
            <h1>My Cart</h1>
            <img src="images/seperator_home.png">
        </div>

        <div class="box-container">

            <?php

                $grand_total = 0;

                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $select_cart->execute([$user_id]);

                if ($select_cart->rowCount() > 0) {
                    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id=?");
                        $select_products->execute([$fetch_cart['product_id']]);
                    
                        if ($select_products->rowCount() > 0) {
                            $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
            ?>

            <form action="" method="post" class="box <?php if($fetch_products['stock'] == 0){echo 'disabled';}; ?>">
                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                    <img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">

                    <?php if($fetch_products['stock'] > 9){ ?>
                    <span class="stock" style="color: green;">In stock</span>
                    <?php }elseif ($fetch_products['stock'] == 0){ ?>
                    <span class="stock" style="color: red;">out of stock</span>
                    <?php }else{ ?>
                    <span class="stock" style="color: red;">Only <?= $fetch_products['stock']; ?> left</span>
                    <?php }?>

                    <div class="content">
                        <img src="images/shape-19.png" class="shap">
                        <h3 class="name">
                            <?= $fetch_products['name']; ?>
                        </h3>
                        <div class="flex-btn">
                            <p class="price">Price - $<?= $fetch_products ['price']; ?>
                            </p>
                            <input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty'] ?>" max="99" maxlength="2" class="box qty">
                            <button type="submit" name="update_cart" class="bx bxs-edit fas fa-edit"></button>
                        </div>
                        <div class="flex-btn">

                            <p class="sub-total"> <br>Sub Total:<span> $<?= $sub_total = ($fetch_cart['qty'] *$fetch_cart['price']); ?></span></p>
                            <button type="submit" name="delete_item" class="btn" onclick="return confirm('Remove from cart?');">Delete</button>
                        </div>
                    </div>
                </form> 

            
            <?php
                        $grand_total+= $sub_total;
                        }else{
                            echo '
                                <div class="empty">
                                    <p>Empty cart</p>
                                </div>
                            ';
                        }
                    }
                }else{
                            echo '
                                <div class="empty">
                                    <p>Empty cart</p>
                                </div>
                            ';
                        }

            ?>
        </div>

        <?php if($grand_total != 0){ ?>
            <div class="cart-total">
                <p>total amount payable: <span> $<?= $grand_total; ?></span></p>
                <div class="button">
                    <form action="" method="post">
                        <button type="submit" name="empty_cart" class="btn" onclick="return confirm('Are you sure you want to empty your cart?');">Empty cart</button>
                        <a href="checkout.php" class="btn">Proceed to checkout</a>
                    </form>
                    
                </div>
            </div>
        <?php } ?>

    </div>

    



    <?php include 'components/footer.php'; ?>    

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>

</body>