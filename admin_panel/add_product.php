<?php
include '../components/connect.php'; // Include the file which establishes database connection

if (isset($_COOKIE['seller_id'])) { // Check if seller_id cookie is set
    $seller_id = $_COOKIE['seller_id']; // If set, retrieve seller_id from the cookie
} else {
    $seller_id = ''; // If not set, set seller_id to empty string
    header('location:login.php'); // Redirect to login page if seller_id is not set
    exit(); // Add exit after header redirection to stop further execution
}

// Fetch profile details of the seller from the database
$select_profile = $conn->prepare("SELECT * FROM seller WHERE id = ?");
$select_profile->execute([$seller_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

// Add a product to the database when the publish button is clicked
if (isset($_POST['publish'])) {

    // Generate a unique ID for the product
    $id = unique_id();

    // Sanitize and retrieve product details from the form inputs
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $stock = $_POST['stock'];
    $stock = filter_var($stock, FILTER_SANITIZE_STRING);
    $status = 'Active';

    // Handle product image upload
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/'.$image;

    // Check if the image already exists or if its size exceeds the limit
    $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND seller_id = ?");
    $select_image->execute([$image, $seller_id]);

    // If image is provided and passes validation checks, move it to the upload folder
    if (isset($image)) {
        if ($select_image->rowCount() > 0) {
            $warning_msg[] = 'Image already exist';
        } elseif($image_size > 10000000) {
            $warning_msg[] = 'Image size is too large';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
        }
    } else {
        $image = '';
    }

    // Check if the image already exists and if it's not empty, display a warning message
    if ($select_image->rowCount() > 0 AND $image != '') {
        $warning_msg[] = 'Please rename your image';
    } else {
        // If everything is fine, insert the product details into the database
        $insert_product = $conn->prepare("INSERT INTO `products` (id, seller_id, name, price, image, stock, product_detail, status) VALUES (?,?,?, ?, ?, ?, ?,?)");
        $insert_product->execute([$id, $seller_id, $name, $price, $image, $stock, $description, $status]);
        $success_msg[] = 'Product Added Successfully';
    }
}

// Save a product as a draft when the draft button is clicked
if (isset($_POST['draft'])) {

    // Generate a unique ID for the product
    $id = unique_id();

    // Sanitize and retrieve product details from the form inputs
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $stock = $_POST['stock'];
    $stock = filter_var($stock, FILTER_SANITIZE_STRING);
    $status = 'Inactive';

    // Handle product image upload
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/'.$image;

    // Check if the image already exists or if its size exceeds the limit
    $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND seller_id = ?");
    $select_image->execute([$image, $seller_id]);

    // If image is provided and passes validation checks, move it to the upload folder
    if (isset($image)) {
        if ($select_image->rowCount() > 0) {
            $warning_msg[] = 'Image already exist';
        } elseif($image_size > 10000000) {
            $warning_msg[] = 'Image size is too large';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
        }
    } else {
        $image = '';
    }

    // Check if the image already exists and if it's not empty, display a warning message
    if ($select_image->rowCount() > 0 AND $image != '') {
        $warning_msg[] = 'Please rename your image';
    } else {
        // If everything is fine, insert the product details into the database
        $insert_product = $conn->prepare("INSERT INTO `products` (id, seller_id, name, price, image, stock, product_detail, status) VALUES (?,?,?, ?, ?, ?, ?,?)");
        $insert_product->execute([$id, $seller_id, $name, $price, $image, $stock, $description, $status]);
        $success_msg[] = 'Product Saved as Draft Successfully';
    }
}

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Add product</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body class="header_body">

    <div class="main-container">
       <?php include '../components/admin-header.php'; ?>

       <section class="post-editor">
            <div class="heading">
                <h1>ADD PRODUCTS</h1>
                <img src="../images/seperator.png">
            </div>

            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data" class="register">
                    <div class="input-field">
                        <p>Product Name <span>*</span> </p>
                        <input type="text" name="name" maxlength="100" placeholder="Add Product Name" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Product Price<span>*</span> </p>
                        <input type="number" name="price" maxlength="100" placeholder="Add Product Price" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Product Detail<span>*</span> </p>
                        <textarea name="description" required maxlength="1000" placeholder="Add Product Detail" required class="box"></textarea>
                    </div>
                    <div class="input-field">
                        <p>Product Stock<span>*</span> </p>
                        <input type="number" name="stock" maxlength="10" min="0" max="9999999999" placeholder="Add Product Stock" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Product Image<span>*</span> </p>
                        <input type="file" name="image" accept="image/*" required class="box">
                    </div>
                    <div class="flex-btn">
                        <input type="submit" name="publish" value="Add Product" class="btn">
                        <input type="submit" name="draft" value="Save as Draft" class="btn">
                    </div>


                </form>
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