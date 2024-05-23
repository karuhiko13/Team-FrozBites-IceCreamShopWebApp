<?php

// Include file to connect to the database
include 'components/connect.php';

// Check if the user ID cookie is set
if (isset($_COOKIE['user_id'])) { 
    // Assign the user ID from the cookie to a variable
    $user_id = $_COOKIE['user_id'];
} else {
    // If the user ID cookie is not set, set the user ID to empty string,
    // redirect to the login page, and exit the script
    $user_id = '';
    header('location:login.php');
    exit();
}

// Check if the 'place_order' form is submitted
if (isset($_POST['place_order'])) {

    // Sanitize and retrieve user input values

    // Sanitize and retrieve the name
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    // Sanitize and retrieve the number
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);

    // Sanitize and retrieve the email
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    // Construct the address from individual address components and sanitize it
    $address = $_POST['flat']. ','.$_POST['street'].','.$_POST['city'].','.$_POST['country'].','.$_POST['pin'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);

    // Sanitize and retrieve the address type
    $address_type = $_POST['address_type'];
    $address_type = filter_var($address_type, FILTER_SANITIZE_STRING);

    // Sanitize and retrieve the payment method
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);

    // Prepare and execute an SQL statement to verify if the user has items in the cart
    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $verify_cart->execute([$user_id]);

    // Check if a product ID is provided in the URL
    if (isset($_GET['get_id'])) {
        // Prepare and execute an SQL statement to retrieve product details by ID
        $get_product = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
        $get_product->execute([$_GET['get_id']]);

        // Check if the product exists
        if ($get_product->rowCount() > 0) {
            // Loop through the fetched product details
            while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
                // Retrieve the seller ID
                $seller_id = $fetch_p['seller_id'];
                
                // Prepare and execute an SQL statement to insert order details into the 'orders' table
                $insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_order->execute([uniqid(), $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'], 1]);

                // Update the stock for the ordered product
                $update_stock = $conn->prepare("UPDATE products SET stock = stock - 1 WHERE id = ?");
                $update_stock->execute([$fetch_p['id']]);

                // Redirect to the order page after placing the order
                header('location:order.php');
            }
        } else {
            // If the product doesn't exist, add a warning message
            $warning_msg[] = 'Something went wrong';
        }
    } elseif ($verify_cart->rowCount() > 0) {
        // If the user has items in the cart, loop through them
        while ($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
            // Prepare and execute an SQL statement to retrieve product details by ID
            $s_products = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
            $s_products->execute([$f_cart['product_id']]);
            $f_product = $s_products->fetch(PDO::FETCH_ASSOC);

            // Retrieve the seller ID
            $seller_id = $f_product['seller_id'];
            
            // Calculate the total price for the product by multiplying price and quantity
            $total_price = $f_product['price'] * $f_cart['qty'];

            // Prepare and execute an SQL statement to insert order details into the 'orders' table
            $insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
            $insert_order->execute([uniqid(), $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method, $f_cart['product_id'], $total_price, $f_cart['qty']]);

            // Update the stock for the ordered product
            $update_stock = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $update_stock->execute([$f_cart['qty'], $f_cart['product_id']]);
        }
        
        // After inserting order details into `orders` table
        // Delete items from cart and redirect to order.php
        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->execute([$user_id]);
        header('location:order.php');
    } else {
        // If the cart is empty, add a warning message
        $warning_msg[] = 'Something went wrong';
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Checkout</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Checkout</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Checkout </span>
        </div>
    </div>

    <div class="checkout">

        <div class="heading">
            <h1>Checkout Summary</h1>
            <img src="images/seperator_home.png">
        </div>

        <div class="row">

            <form action="" method="post" class="register">

                <input type="hidden" name="p_id" value="<?= $get_id; ?>">
                <h3>billing details</h3>

                <div class="flex">
                    <div class="box">

                        <div class="input-field">
                            <p>Full Name<span>*</span> </p>
                            <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="input">
                        </div>

                        <div class="input-field">
                            <p>Contact Number<span>*</span> </p>
                            <input type="number" name="number" required maxlength="10" placeholder="Enter your number" class="input">
                        </div>

                        <div class="input-field">
                            <p>Email <span>*</span> </p>
                            <input type="email" name="email" required maxlength="50" placeholder="Enter your name" class="input">
                        </div>

                        <div class="input-field">
                            <p>Payment Method<span>*</span> </p>
                            <select name="method" class="input">
                                <option value="none" selected disabled hidden>Select an Option</option>
                                <option value="cash on delivery">cash on delivery</option> 
                                <option value="credit or debit card">credit or debit card</option>
                                <option value="crypto">cryptocurrency</option>
                                <option value="gcash">gcash</option>
                                <option value="paymaya">paymaya</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <p>Address Type <span>*</span> </p>
                            <select name="address_type" class="input">
                                <option value="none" selected disabled hidden>Select an Option</option>
                                <option value="home">Home</option>
                                <option value="office">Office</option>
                            </select>
                        </div>
                    </div>

                    <div class="box">
                        <div class="input-field">
                            <p>address line 01 <span>*</span> </p>
                            <input type="text" name="flat" required maxlength="50" placeholder="e.g flat or building name" class="input">
                        </div>
                        <div class="input-field">
                            <p>address line 02 <span>*</span> </p>
                            <input type="text" name="street" required maxlength="50" placeholder="e.g street name" class="input">
                        </div>
                        <div class="input-field">
                            <p>city name <span>*</span> </p>
                            <input type="text" name="city" required maxlength="50" placeholder="e.g city name" class="input">
                        </div>
                        <div class="input-field">
                            <p>country name <span>*</span> </p>
                            <input type="text" name="country" required maxlength="50" placeholder=" e.g country name" class="input">
                        </div>
                        <div class="input-field">
                            <p>postal code <span>*</span> </p>
                            <input type="number" name="pin" required maxlength="6" min="0" placeholder="e.g 110011" class="input">
                        </div>
                    </div>
                </div>
                <div class="flex-btn">
                    <button type="submit" name="place_order" class="btn">Place order</button>
                </div>
            </form>

            <div class="summary">
                <h3> My Bag</h3>
                <div class="box-container">
                    <?php
                        $grand_total = 0;
                        if (isset($_GET['get_id'])) {

                            $select_get = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
                            $select_get->execute([$_GET['get_id']]);

                                while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                                    $sub_total = $fetch_get['price']; 
                                    $grand_total+=$sub_total;
                    ?>
                    <div class="flex">
                        <img src="uploaded_files/<?= $fetch_get['image']; ?>" class="image">
                        <div>
                            <h3 class="name">
                                <?= $fetch_get['name']; ?>
                            </h3>
                            <p class="price">$ 
                                <?= $fetch_get['price']; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                            }
                        }else{
                            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?"); 
                            $select_cart->execute([$user_id]);

                            if ($select_cart->rowCount() > 0) {
                                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) { 
                                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                                    $select_products->execute([$fetch_cart['product_id']]);
                                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                                    $sub_total = ($fetch_cart['qty'] * $fetch_products['price']);
                                    $grand_total += $sub_total;
                    ?>

                    <div class="flex">
                        <img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
                        <div>
                            <h3 class="name">
                                <?= $fetch_products ['name']; ?>
                            </h3>
                            <p class="price">$
                                <?= $fetch_products ['price']; ?> X
                                <?= $fetch_cart['qty']; ?>
                            </p>
                        </div>
                    </div>

                    <?php
                                } 
                            }else{ 
                                echo '<p class="empty">your cart is empty</p>';
                            }
                        }
                    ?>
                </div>

                <div class="grand-total">
                    <span>total amount payable: </span>
                    <p>$<?= $grand_total; ?></p>
                </div>       
            </div>
        </div>
    </div>

    



    <?php include 'components/footer.php'; ?>    

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>

</body>