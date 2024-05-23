<?php
    include '../components/connect.php';

    if (isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        $seller_id = '';
        header('location:login.php');
        exit(); // Add exit after header redirection
    }

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Registered Users </title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body class="header_body">

    <div class="main-container">
       <?php include '../components/admin-header.php'; ?>

       <section class="user-container">
            <div class="heading">
                <h1>Registered Users</h1>
                <img src="../images/seperator.png">
            </div>
            <div class="box-container">
                
                <?php
                    $select_users = $conn->prepare("SELECT * FROM `user`");
                    $select_users->execute();

                    if ($select_users->rowCount() > 0) {
                        while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){ 
                            $user_id = $fetch_users['id'];
                ?>
                <div class="box">
                    <img src="../uploaded_files/<?= $fetch_users['image']; ?>">
                    <p>User ID: <span><?= $user_id; ?></span></p>
                    <p>User Name : <span><?= $fetch_users ['name']; ?></span></p>
                    <p>User Email: <span><?= $fetch_users['email']; ?></span></p>
                </div>


                <?php
                        }
                    }else{
                        echo'
                            <div class="empty">
                                <p>No Registered Users</p>
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