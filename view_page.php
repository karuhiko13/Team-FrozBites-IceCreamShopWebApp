<?php

    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) { 
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }

    $pid = $_GET['pid'];

    include 'components/add_wishlist.php';
    include 'components/add_cart.php';
    
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Product Detail</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Product Detail</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Product Detail</span>
        </div>
    </div>

    <section class="view_page">

        <div class="heading">
            <h1>product detail</h1>
            <img src="images/seperator_home.png">
        </div>

        <?php
            if (isset($_GET['pid'])) { 

                $pid = $_GET['pid'];

                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
                $select_products->execute([$pid]);

                if ($select_products->rowCount() > 0) {
                    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>

        <form action="" method="post" class="box">

            <div class="img-box">
                <img src="uploaded_files/<?= $fetch_products['image']; ?>">
            </div>

            <div class="detail">
                <?php if($fetch_products['stock'] > 9){ ?>
                    <span class="stock" style="color:green;">In Stock</span>
                <?php }elseif ($fetch_products['stock'] == 0){ ?>
                    <span class="stock" style="color:red;">Out of stock</span>
                <?php }else{ ?>
                    <span class="stock" style="color:red;">Only <?= $fetch_products ['stock'] ?> left</span>
                <?php } ?>

                <p class="price">$ 
                    <?= $fetch_products['price']; ?>
                </p>
                <div class="name">
                    <?= $fetch_products['name']; ?>
                </div>
                <p class="product-detail">
                    <?= $fetch_products ['product_detail']; ?>
                </p>
                <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                <div class="button">
                    <button type="submit" name="add_to_wishlist" class="btn">add to wishlist <i class="bx bx-heart"></i> </button>
                    <input type="hidden" name="qty" value="1" min="0" class="quantity">
                    <button type="submit" name="add_to_cart" class="btn">add to cart <i class="bx bx-cart"></i> </button>
                </div>
            </div>
        </form>

        <?php
                    }
                }
            }
        ?>

    </section>

    <div class="products">
        <div class="heading">
            <h1>Similar Products</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br> tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
            <img src="images/seperator_home.png">
        </div>
        <?php include 'components/shop.php'; ?>


    </div>

        



    <?php include 'components/footer.php'; ?>    

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>

</body>