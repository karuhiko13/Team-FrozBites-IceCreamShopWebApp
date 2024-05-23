<?php
include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) { 
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }

    include 'components/add_wishlist.php';
    include 'components/add_cart.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Shop</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Menu</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>MENU</span>
        </div>
    </div>
    <div class="products">

        <div class="heading">
            <h1>our latest flavors</h1>
            <img src="images/seperator_home.png">
        </div>

        <div class="box-container">
            <?php
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE status = ?"); 
                $select_products->execute(['active']);

                if ($select_products->rowCount() > 0) {
                    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
                    
                
            ?>

            <form action="" method="post" class="box <?php if($fetch_products['stock'] == 0){echo"disabled";} ?>">
                
                <img src="uploaded_files/<?= $fetch_products ['image']; ?>" class="image">
               
                <?php if($fetch_products['stock'] > 9){ ?>
                    <span class="stock" style="color: green;">In Stock</span>
                
                <?php }elseif ($fetch_products['stock'] == 0){ ?>
                    <span class="stock" style="color: red;">Out of Stock</span>
                <?php }else{ ?>
                    <span class="stock" style="color: red;"> Only <?= $fetch_products['stock'] ;?> left</span>
                <?php }?>

                <div class="content">

                    <img src="images/shape-19.png" alt="" class="shap">

                    <div class="button">
                        <div>
                            <h3 class="name">
                                <?= $fetch_products ['name']; ?>
                            </h3>
                        </div>
                        <div>
                            <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                            <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                            <a href="view_page.php?pid=<?= $fetch_products['id'] ?>" class="bx bxs-show"></a>
                        </div>
                    </div>
                    <p class="price">price - $<?= $fetch_products['price']; ?></p>

                    <input type="hidden" name="product_id" value="<?= $fetch_products['id'] ?>">

                    <div class="flex-btn">
                        <a href="home.php?get_id=<?= $fetch_products['id'] ?>" class="btn">buy now</a>
                        <input type="number" name="qty" required min="1" value=" " max="99" maxlength="2" placeholder="0" class="qty box">
                    </div>
                </div>

            </form>



            <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>No product added yet! <br> <a href="add_products.php" class="btn" style="margin-top: 1.5rem;">Add product</a></p>
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