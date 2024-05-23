<?php
include '../components/connect.php'; // Including database connection

if (isset($_COOKIE['seller_id'])) { // Checking if seller is logged in
    $seller_id = $_COOKIE['seller_id']; // Getting seller ID from cookie
} else {
    $seller_id = '';
    header('location:login.php');
    exit(); // Add exit after header redirection
}

// Fetch profile details once
$select_profile = $conn->prepare("SELECT * FROM seller WHERE id = ?");
$select_profile->execute([$seller_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) { // Processing update product form
    $product_id = $_POST['product_id'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    $stock = $_POST['stock'];
    $stock = filter_var($stock, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);

    // Update product details
    $update_product = $conn->prepare("UPDATE `products` SET name =?, price =?, product_detail = ?, stock = ?, status = ? WHERE id = ?");
    $update_product->execute([$name, $price, $description, $stock, $status, $product_id]);
    $success_msg[] = 'Product Updated';

    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/'.$image;

    $select_image = $conn->prepare("SELECT * FROM `products` WHERE image=? AND seller_id=?");
    $select_image->execute([$image, $seller_id]);

    if (!empty($image)) { // If new image uploaded
        if ($image_size > 10000000) { // Checking image size limit
            $warning_msg[] = 'Image size is too large';
        } elseif ($select_image->rowCount() > 0 AND $image != '') { // Checking if image with same name already exists
            $warning_msg[] = 'Please rename your image';
        } else {
            $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id=?");
            $update_image->execute([$image, $product_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            if ($old_image != $image AND $old_image != '') { // If image changed, delete old image
                unlink('../uploaded_files/'.$old_image);
            }
            $success_msg[] = 'Image updated!';
        }
    }
}

//delete image
if (isset($_POST['delete_image'])) { // Deleting product image
    $empty_image = '';

    $product_id = $_POST['product_id'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

    $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_image->execute([$product_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_delete_image['image'] != '') { // Checking if image exists
        unlink('../uploaded_files/'.$fetch_delete_image['image']); // Deleting image file
    }
    $unset_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
    $unset_image->execute([$empty_image, $product_id]);
    $success_msg[] = 'Image Removed Successfully';
}

//delete product
if (isset($_POST['delete_product'])) { // Deleting product
    $product_id = $_POST['product_id'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

    $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_image->execute([$product_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    if ($fetch_delete_image['image'] != '') { // Checking if image exists
        unlink('../uploaded_files/'.$fetch_delete_image['image']); // Deleting image file
    }

    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$product_id]);
    $success_msg[] = 'Product Removed Successfully!';
    header('location:view_product.php');
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Edit Product</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body class="header_body">

    <div class="main-container">
       <?php include '../components/admin-header.php'; ?>

       <section class="post-editor">
            <div class="heading">
                <h1>EDIT PRODUCT</h1>
                <img src="../images/seperator.png">
            </div>

            <div class="box-container">

                <?php
                    $product_id = $_GET['id'];
                    $select_product = $conn -> prepare("SELECT * FROM `products` WHERE id = ? AND seller_id = ? ");
                    $select_product -> execute([$product_id, $seller_id]);
                    if ($select_product -> rowCount() > 0) {
                        while ($fetch_product = $select_product -> fetch(PDO:: FETCH_ASSOC)) {
                ?>

                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data" class="register">
                        <input type="hidden" name="old_image" value="<?= $fetch_product['image']; ?>">
                        <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                        <div class="input-field">
                            <p>Product Status <span>*</span></p>
                            <select name="status" class="box">
                                <option value="<?= $fetch_product['status']; ?>" selected>
                                    <?= $fetch_product['status']; ?>
                                </option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <p>Product Name <span>*</span></p>
                            <input type="text" name="name" value="<?= $fetch_product['name']; ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p>Product Price <span>*</span></p>
                            <input type="number" name="price" value="<?= $fetch_product['price']; ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p>Product description <span>*</span></p>
                            <textarea name="description" class="box"><?= $fetch_product['product_detail']; ?></textarea>
                        </div>
                        <div class="input-field">
                            <p>Product stock <span>*</span></p>
                            <input type="number" name="stock" value="<?= $fetch_product['stock']; ?>" class="box" min="0" max="999999999" maxlength="10">
                        </div>
                        <div class="input-field">
                            <p>Product Image <span>*</span></p>
                            <input type="file" name="image" accept="image/*" class="box">
                            <?php if($fetch_product['image'] != ''){ ?>
                                <img src="../uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                            <?php } ?>
                            <div class="flex-btn">
                                <input type="submit" name="delete_image" class="btn" value="delete image">
                                <input type="submit" name="update" value="update product" class="btn">
                            </div>
                        </div>

                        <div class="flex-btn">
                            <input type="submit" name="delete_product" value="delete product" class="btn">
                            <a href="view_product.php" class="btn" style="width:44%; text-align: center; height: 2.8rem;">Go Back</a>
                        </div>
                    </form>
                </div>

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
        </section>
    </div>

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom js link -->
    <script src="../js/script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
