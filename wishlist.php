<?php

    include 'components/connect.php'; // Including database connection file

    if (isset($_COOKIE['user_id'])) { // Checking if user_id cookie is set
        $user_id = $_COOKIE['user_id']; // Assigning user_id cookie value to $user_id variable if set
    } else {
        $user_id = 'location:login.php'; // Redirecting to login page if user_id cookie is not set
    }


    // Remove product from wishlist
    if (isset($_POST['delete_item'])) { // Checking if the delete_item form is submitted

        $wishlist_id = $_POST['wishlist_id']; // Getting wishlist_id from POST data
        $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING); // Sanitizing wishlist_id

        $verify_delete = $conn -> prepare("SELECT * FROM `wishlist` WHERE id = ?"); // Prepare SQL statement to verify wishlist item deletion
        $verify_delete -> execute([$wishlist_id]); // Executing the prepared statement

        if ($verify_delete -> rowCount() > 0) { // If wishlist item exists
            $delete_wishlist_id = $conn -> prepare("DELETE FROM `wishlist` WHERE id=?"); // Prepare SQL statement to delete wishlist item
            $delete_wishlist_id -> execute([$wishlist_id]); // Executing the prepared statement to delete the wishlist item
            $success_msg[] = 'Item removed from wishlist'; // Adding success message
        } else {
            $warning_msg[] = 'Item already removed'; // Adding warning message if item is already removed
        }
    }


    // Remove product from wishlist and add to cart
    if (isset($_POST['add_to_cart'])) { // Checking if the add_to_cart form is submitted

        $wishlist_id = $_POST['wishlist_id']; // Getting wishlist_id from POST data
        $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING); // Sanitizing wishlist_id

        $select_wishlist_item = $conn->prepare("SELECT * FROM `wishlist` WHERE id = ? AND user_id = ?"); // Prepare SQL statement to select wishlist item
        $select_wishlist_item->execute([$wishlist_id, $user_id]); // Executing the prepared statement

        if ($select_wishlist_item->rowCount() > 0) { // If wishlist item exists for the current user
            // Item exists in wishlist, move it to cart
            $wishlist_item = $select_wishlist_item->fetch(PDO::FETCH_ASSOC); // Fetching wishlist item details
            $product_id = $wishlist_item['product_id']; // Getting product_id from wishlist item
            $qty = 1; // Assuming quantity is 1, you can modify this as per your requirement

            // Check if product is in stock
            $select_stock = $conn->prepare("SELECT stock FROM `products` WHERE id = ? AND status = 'active'"); // Prepare SQL statement to select product stock
            $select_stock->execute([$product_id]); // Executing the prepared statement
            $product_stock = $select_stock->fetchColumn(); // Fetching product stock

            if ($product_stock > 0) { // If product is in stock
                // Check if product already exists in cart
                $check_cart_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?"); // Prepare SQL statement to check cart item
                $check_cart_item->execute([$user_id, $product_id]); // Executing the prepared statement

                if ($check_cart_item->rowCount() > 0) { // If product already exists in cart
                    // Product already exists in cart
                    $warning_msg[] = 'Product is already in cart'; // Adding warning message
                } else {
                    // Add to cart
                    $add_to_cart = $conn->prepare("INSERT INTO `cart` (user_id, product_id, price, qty) SELECT ?, product_id, price, ? FROM `wishlist` WHERE id = ?"); // Prepare SQL statement to add to cart
                    $add_to_cart->execute([$user_id, $qty, $wishlist_id]); // Executing the prepared statement to add to cart

                    // Remove from wishlist
                    $remove_from_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?"); // Prepare SQL statement to remove from wishlist
                    $remove_from_wishlist->execute([$wishlist_id]); // Executing the prepared statement to remove from wishlist

                    $success_msg[] = 'Product added to cart'; // Adding success message

                    // Redirect to avoid resubmission on page refresh
                    header("Location: {$_SERVER['REQUEST_URI']}"); // Redirecting to the current page
                    exit(); // Exiting script
                }
            } else {
                $warning_msg[] = 'Product is out of stock'; // Adding warning message if product is out of stock
            }
        } else {
            $warning_msg[] = 'Item not found in wishlist'; // Adding warning message if item is not found in wishlist
        }
    }

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - My Wishlist</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body>

    <?php include 'components/user_header.php';?>

    <div class="banner">
        <div class="detail">
            <h1>Wishlist</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Wishlist</span>
        </div>
    </div>

    <div class="products">

        <div class="heading">
            <h1>My wishlist</h1>
            <img src="images/seperator_home.png">
        </div>

        <div class="box-container">

            <?php
                $grand_total = 0;
                $select_wishlist = $conn -> prepare("SELECT * FROM `wishlist` WHERE user_id=?");
                $select_wishlist -> execute([$user_id]);

                if ($select_wishlist -> rowCount() > 0) {
                    while ($fetch_wishlist = $select_wishlist -> fetch(PDO:: FETCH_ASSOC)) {

                        $select_products = $conn -> prepare("SELECT * FROM `products` WHERE id=?");
                        $select_products -> execute([$fetch_wishlist['product_id']]);

                        if ($select_products -> rowCount() > 0) {
                            $fetch_products = $select_products -> fetch(PDO:: FETCH_ASSOC)
            ?>

            <form action="" method="post" class="box <?php if($fetch_products['stock'] == 0) {echo " disabled";} ?>">
                <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">

                <img src="uploaded_files/<?= $fetch_products ['image']; ?>" class="image">
                <?php if($fetch_products['stock'] > 9){ ?>

                <span class="stock" style="color: green;">In Stock</span>
                <?php }elseif ($fetch_products['stock'] == 0){ ?>

                <span class="stock" style="color: red;">Out of stock</span>
                <?php }else{ ?>

                <span class="stock" style="color: red;">Only <?= $fetch_products['stock'] ; ?> left</span>
                <?php } ?>

                <div class="content">
                    <img src="images/shape-19.png" class="shap">
                    <div class="button">
                        <div>
                            <h3>
                                <?= $fetch_products ['name']; ?>
                            </h3>
                        </div>
                        <div>
                            <button type="submit" name="add_to_cart"> <i class="bx bx-cart"></i></button>
                            <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>
                            <button type="submit" name="delete_item" onclick="return confirm(' Remove from wishlist?');"><i class="bx bx-x"></i></button>
                        </div>
                    </div>
                    <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                    <div class="flex-btn">
                        <p class="price">Price - $<?= $fetch_products ['price']; ?></p>
                    </div>
                    <div class="flex-btn">
                        <input type="hidden" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                        <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">buy now</a>
                    </div>
                </div>
            </form>
        
            
            <?php
                    $grand_total+= $fetch_wishlist['price'];
                    }
                    }
                }else{
                    echo '
                        <div class="empty">
                            <p>No product added yet!</p>
                        </div>
                    ';
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