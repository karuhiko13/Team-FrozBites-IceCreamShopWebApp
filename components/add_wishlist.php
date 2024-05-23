<?php

if (isset($_POST['add_to_wishlist'])) { // Checking if add_to_wishlist form is submitted

    if ($user_id != '') { // Checking if user is logged in

        $id = unique_id(); // Generating a unique ID for the wishlist item
        $product_id = $_POST['product_id']; // Getting product_id from POST data

        $verify_wishlist = $conn -> prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?"); // Prepare SQL statement to verify if product is in wishlist
        $verify_wishlist -> execute([$user_id, $product_id]); // Executing the prepared statement

        $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?"); // Prepare SQL statement to check if product is in cart
        $cart_num->execute([$user_id, $product_id]); // Executing the prepared statement

        if ($verify_wishlist -> rowCount() > 0) { // If product is already in wishlist
            $warning_msg[] = 'Prduct is already in wishlist'; // Adding warning message
        } else if ($cart_num -> rowCount() > 0) { // If product is already in cart
            $warning_msg[] = 'Product is already in cart'; // Adding warning message
        } else if ($user_id != '') { // If user is logged in
            $select_price = $conn -> prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1"); // Prepare SQL statement to select product price
            $select_price -> execute([$product_id]); // Executing the prepared statement
            $fetch_price = $select_price -> fetch(PDO:: FETCH_ASSOC); // Fetching product price

            $insert_wishlist = $conn -> prepare("INSERT INTO `wishlist` (id, user_id, product_id, price) VALUES(?,?,?,?)"); // Prepare SQL statement to insert into wishlist
            $insert_wishlist -> execute([$id, $user_id, $product_id, $fetch_price['price']]); // Executing the prepared statement to insert into wishlist

            $success_msg[] = 'product added to your wishlist successfully'; // Adding success message
        }
        
    } else {
        $warning_msg = 'Please log in first'; // Adding warning message if user is not logged in
    }
}
?>

