<?php

if (isset($_POST['add_to_cart'])) { // Checking if add_to_cart form is submitted
    if ($user_id != '') { // Checking if user is logged in

        $id = unique_id(); // Generating a unique ID for the cart item
        $product_id = $_POST['product_id']; // Getting product_id from POST data

        $qty = $_POST['qty']; // Getting quantity from POST data
        $qty = filter_var($qty, FILTER_SANITIZE_STRING); // Sanitizing quantity

        // Check if the product is in stock
        $select_stock = $conn->prepare("SELECT stock FROM `products` WHERE id = ? AND status = 'active'"); // Prepare SQL statement to select product stock
        $select_stock->execute([$product_id]); // Executing the prepared statement
        $product_stock = $select_stock->fetchColumn(); // Fetching product stock

        if ($product_stock > 0) { // If product is in stock
            $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?"); // Prepare SQL statement to verify if product is in cart
            $verify_cart->execute([$user_id, $product_id]); // Executing the prepared statement

            $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?"); // Prepare SQL statement to count cart items
            $max_cart_items->execute([$user_id]); // Executing the prepared statement

            if ($verify_cart->rowCount() > 0) { // If product is already in cart
                $warning_msg[] = 'Product is already in cart'; // Adding warning message
            } elseif ($max_cart_items->rowCount() > 20) { // If cart is full (maximum 20 items)
                $warning_msg[] = 'Your cart is full'; // Adding warning message
            } else { // If product is not in cart and cart is not full
                $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1"); // Prepare SQL statement to select product price
                $select_price->execute([$product_id]); // Executing the prepared statement
                $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC); // Fetching product price

                $insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, qty) VALUES(?, ?, ?, ?, ?)"); // Prepare SQL statement to insert into cart
                $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]); // Executing the prepared statement to insert into cart

                $success_msg[] = 'Product added to cart'; // Adding success message
            }
        } else { // If product is out of stock
            $warning_msg[] = 'Product is out of stock'; // Adding warning message
        }
    } else { // If user is not logged in
        $warning_msg[] = 'Please login first'; // Adding warning message
    }
}
?>
