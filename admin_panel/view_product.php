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

    //Delete Product
    if (isset($_POST['delete'])) {
        $p_id = $_POST['product_id'];
        $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);
        $delete_product = $conn -> prepare("DELETE FROM `products` WHERE id = ?");
        $delete_product -> execute([$p_id]);
        $success_msg[] = 'Product Removed Successfully';
    }


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - View Product</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body class="header_body">

    <div class="main-container">
       <?php include '../components/admin-header.php'; ?>

       <section class="show-post">
            <div class="heading">
                <h1>Your Products</h1>
                <img src="../images/seperator.png">
            </div>

            <div class="box-container">
                <?php
                    $select_products = $conn -> prepare("SELECT * FROM `products` WHERE seller_id = ?");
                    $select_products -> execute([$seller_id]);
                    if ($select_products -> rowCount() > 0) {
                        while ($fetch_products = $select_products -> fetch(PDO:: FETCH_ASSOC)) {
                ?>

                <form action="" method="post" class="box">
                    <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                    <?php if($fetch_products['image'] != ''){ ?>
                        <img src="../uploaded_files/<?= $fetch_products['image']; ?>" class="image">
                    <?php } ?>
                    <div class="status" style="color: <?php if($fetch_products['status'] == 'Active'){ echo " limegreen";
                        }else{echo "coral" ;} ?>"><?= $fetch_products['status']; ?>
                    </div>
                    <div class="price">₱ <?= $fetch_products['price']; ?></div>
                    <div class="content">
                            <img src="../images/shape-19.png" class="shap">
                            <div class="title"><?= $fetch_products['name']; ?></div>
                            <div class="flex-btn">
                                <a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">edit</a>
                                <button type="submit" name="delete" class="btn" onclick="return confirm(' Are you sure you want to delete this item?');">Delete</button>
                                <a href="read_product.php?post_id=<?= $fetch_products['id']; ?>" class="btn">View</a>

                            </div>
                        </div>
                </form>





                <?php
                        }
                    }else{
                        echo'
                            <div class="empty">
                                <p>no products added yet! <br> <a href="add_product.php" class="btn" style="margin-top: 1.5rem;">add products</a></p>
                            </div>

                        ';
                    }



                ?>

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