<?php

// Include file to connect to the database
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) { 
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
}


// Check if the 'send_message' form is submitted
if (isset($_POST['send_message'])) {

    // Sanitize and retrieve the name
    $name = $_POST['name']; 
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    
    // Sanitize and retrieve the email
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    
    // Sanitize and retrieve the subject
    $subject = $_POST['subject'];
    $subject = filter_var($subject, FILTER_SANITIZE_STRING);
   
    // Sanitize and retrieve the message
    $message = $_POST['message'];
    $message = filter_var($message, FILTER_SANITIZE_STRING);

    // Prepare and execute an SQL statement to verify if the message already exists
    $verify_message = $conn->prepare("SELECT * FROM `inquiry` WHERE name = ? AND email = ? AND subject = ? AND message = ?");
    $verify_message->execute([$name, $email, $subject, $message]);

    // Check if the message already exists
    if ($verify_message->rowCount() > 0) {
        // If the message exists, add a warning message
        $warning_msg[] = 'Message already exist';
    } else {
        // If the message doesn't exist, prepare and execute an SQL statement to insert the message into the 'inquiry' table
        $id = unique_id(); // Assuming unique_id() function exists
        $insert_message = $conn->prepare("INSERT INTO `inquiry` (id, name, email, subject, message) VALUES(?,?,?,?,?)");
        $insert_message->execute([$id, $name, $email, $subject, $message]);

        // Add a success message
        $success_msg[] = 'Message sent successfully';
    }
}
?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Contact Us</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body class="contact">

    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Contact Us</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Contact</span>
        </div>
    </div>

    <div class="services">

        <div class="heading">
            <h1>our services</h1>
            <p>Just A Few Click To Make The Reservation Online For Saving Your Time And Money</p>
            <img src="images/seperator_home.png">
        </div>

        <div class="box-container">
            <div class="box">
                <img src="images/ser (1).png">
                <div>
                    <h1>Fast Shipping Fast</h1>
                    <p>Experience lightning-fast shipping to get your favorite treats delivered straight to your door.</p>
                </div>
            </div>
            <div class="box">
                <img src="images/ser (3).png">
                <div>
                    <h1>Money Back Guaranteed</h1>
                    <p>Shop with confidence knowing that your satisfaction is guaranteed, or your money back.</p>
                </div>
            </div>
            <div class="box">
                <img src="images/ser (5).png">
                <div>
                    <h1>24/7 Online Support</h1>
                    <p>Get assistance anytime, anywhere with our round-the-clock online support team ready to help.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-container">

        <div class="heading">
            <h1>Message Us</h1>
            <p>For any inquiries feel free to fill up the details below and send it to us.</p>
            <img src="images/seperator_home.png">
        </div>

        <form action="" method="post" class="register">
            <div class="input-field">
                <label>name <sup>*</sup></label>
                <input type="text" name="name" required placeholder="Enter your full name" class="box">
            </div>
            <div class="input-field">
                <label>email <sup>*</sup></label>
                <input type="email" name="email" required placeholder="Enter your email" class="box">
            </div>
            <div class="input-field">
                <label>subject <sup>*</sup></label>
                <input type="text" name="subject" required placeholder="Title" class="box">
            </div>
            <div class="input-field">
                <label>Message<sup>*</sup></label>
                <textarea name="message" cols="30" rows="10" required placeholder="Your inquiry goes here..." class="box"></textarea>
            </div>
            <button type="submit" name="send_message" class="btn">send message</button>
        </form>
    </div>
    
    <div class="address">

        <div class="heading">
            <h1>Our Contact Details</h1>
            <p>Our contact details address is listed below</p>
            <img src="images/seperator_home.png">
        </div>

        <div class="box-container">
            <div class="box">
                <i class="bx bxs-map-alt"></i>
                <div>
                    <h4>address</h4>
                    <p>123 Boac, Marinduque,<br> Philippines,  4900 </p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-phone-incoming"></i>
                <div>
                    <h4>Phone Number</h4>
                    <p>(+63) 987-6541-320</p>
                    <p>(+63) 903-2165-478</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-phone-incoming"></i>
                <div>
                    <h4>Email</h4>
                    <p>frozbites@gmail.com</p>
                    <p>tech.frozbites@gmail.com</p>

                </div>
            </div>
        </div>
    </div>


    <?php include 'components/footer.php'; ?>    

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>

</body>