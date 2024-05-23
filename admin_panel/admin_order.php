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

    // Update Order Status and Payment Status
        if (isset($_POST['update_order'])) {
            $order_id = $_POST['order_id'];
            $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

            $update_status = $_POST['update_status'];
            $update_status = filter_var($update_status, FILTER_SANITIZE_STRING);

            // Update status
            $update_status_query = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
            $update_status_query->execute([$update_status, $order_id]);

            // If the order status is "Order Delivered", update payment status to "Paid"
            if ($update_status === 'Order Delivered') {
                $update_payment_status_query = $conn->prepare("UPDATE `orders` SET payment_status = 'Paid' WHERE id = ?");
                $update_payment_status_query->execute([$order_id]);
            }elseif ($update_status === 'Canceled') {
                $update_payment_status_query = $conn->prepare("UPDATE `orders` SET payment_status = 'Canceled' WHERE id = ?");
                $update_payment_status_query->execute([$order_id]);
            }

            $success_msg[] = 'Order status has been updated';
        }


    //Delete Order
    if (isset($_POST['delete_order'])) {
        $delete_id = $_POST['order_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    
        $verify_delete = $conn->prepare("SELECT * FROM `orders` WHERE id = ?"); $verify_delete->execute([$delete_id]);
        if ($verify_delete->rowCount() > 0) {
            $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?"); $delete_order->execute([$delete_id]);
            $success_msg[] = 'Order deleted';
        }else{
            $warning_msg[] = 'Order already deleted';
        }
    }
    

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Seller Total Orders</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body class="header_body">

    <div class="main-container">
       <?php include '../components/admin-header.php'; ?>

       <section class="order-container">
            <div class="heading">
                <h1>Total Orders Placed</h1>
                <img src="../images/seperator.png">
            </div>
            <div class="box-container">
                
                <?php
                    $select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?"); $select_order->execute([$seller_id]);
                    if ($select_order->rowCount() > 0) {
                    while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="box">
                    <div class="status" style="color: 
                        <?php
                            if($fetch_order['status'] == 'Order Delivered') {
                                echo "limegreen";
                            } elseif ($fetch_order['status'] == 'Canceled') {
                                echo "red";
                            } else {
                                echo "orange";
                            }
                        ?>"><?= $fetch_order['status']; ?>
                    </div>
                    <div class="details">
                        <p>User Name: <span><?= $fetch_order['name']; ?></span></p>
                        <p>User Id: <span><?= $fetch_order ['user_id']; ?></span></p>
                        <p>Placed On: <span><?= $fetch_order['date']; ?></span></p>
                        <p>User Number: <span><?= $fetch_order['number']; ?></span></p>
                        <p>User Email: <span><?= $fetch_order ['email']; ?></span></p>
                        <p>Total Price: <span><?= $fetch_order ['price']; ?></span></p>
                        <p>Payment Method: <span><?= $fetch_order ['method']; ?></span></p>
                        <p>Payment Status: <span><?= $fetch_order ['payment_status']; ?></span></p>
                        <p>User address: <span><?= $fetch_order ['address']; ?></span></p>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
                        <select name="update_status" class="box" id="status" style="width: 90%;">
                            <option disabled selected><?= $fetch_order['status']; ?></option>
                            <option value="In Progress">In Progress</option>
                            <option value="Order Delivered">Order Delivered</option>
                            <option value="Canceled">Canceled</option> <!-- Add this option if you want to allow canceling orders from admin panel -->
                        </select>
                        <div class="flex-btn">
                            <input type="submit" name="update_order" value="Update Status" class="btn">
                            <input type="submit" name="delete_order" value="Delete Order" class="btn" onclick="return confirm('Are you sure you want to delete this order?')">
                        </div>
                    </form>
                </div>
                
                <?php
                        }
                    }else{
                        echo'
                            <div class="empty">
                                <p>No Orders</p>
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