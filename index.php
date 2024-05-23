<?php

    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) { 
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrozBites - Home Page</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>

    <?php include 'components/user_header.php'; ?>


    <!-- Slider Section Start -->
    <div class="slider-container">
        <div class="slider">
            <div class="slideBox active">  
            <!--<div class="textBox ">
                    <h1>we pride ourselfs on <br> exceptional flavors</h1>
                    <a href="menu.php" class="btn">shop now</a>
                </div>-->
                <div class="imgBox">
                    <img src="images/slider.jpg">
                </div>
            </div>
            <div class="slideBox">
               <!-- <div class="textBox">
                    <h1>cold treats are my kind <br> of comfort food</h1>
                    <a href="menu.php" class="btn">shop now</a>
                </div>-->
                <div class="imgBox">
                    <img src="images/slider1.png">
                </div>
            </div>
        </div>
        <ul class="controls">
            <li onclick="nextSlide();" class="next"> <i class="bx bx-right-arrow-alt"></i> </li>
            <li onclick="prevSlide();" class="prev"> <i class="bx bx-left-arrow-alt"></i> </li>
        </ul>
    </div>
    <!-- Slider Section End -->

    <!-- Service section start-->
    <div class="service">
        <div class="box-container">
            <!-- service item box-->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="images/ser (1).png" class="img1">
                        <img src="images/ser (2).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Delivery</h4>
                    <span>Fast Delivery</span>
                </div>
            </div>
            <!-- service item box-->
            <!-- service item box-->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="images/ser (3).png" class="img1">
                        <img src="images/ser (4).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Payment</h4>
                    <span>100% Secure</span>
                </div>
            </div>
            <!-- service item box-->
            <!-- service item box-->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="images/ser (5).png" class="img1">
                        <img src="images/ser (6).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Support</h4>
                    <span>24/7 Hours</span>
                </div>
            </div>
            <!-- service item box-->
            <!-- service item box-->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="images/ser (7).png" class="img1">
                        <img src="images/ser (8).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Gift</h4>
                    <span>Support Gift Services</span>
                </div>
            </div>
            <!-- service item box-->
            <!-- service item box-->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="images/ser (9).png" class="img1">
                        <img src="images/ser (10).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Easy Return</h4>
                    <span>24/7 Free Return</span>
                </div>
            </div>
            <!-- service item box-->
            <!-- service item box-->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="images/ser(11).png" class="img1">
                        <img src="images/ser(12).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>24/7</h4>
                    <span>Delivery Service</span>
                </div>
            </div>
            <!-- service item box-->
        </div>
    </div>
    <!-- service section end-->

    <!-- Categories section start-->

    <div class="categories">
        <div class="heading">
            <h1 style="font-family: Poetsen One, sans-serif; font-size: 3.5rem;">Featured Flavors</h1>
            <img src="images/seperator_home.png">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="images/categories.jpg">
                <a href="menu.php" class="btn">Rocky Road</a>
            </div>
            <div class="box">
                <img src="images/categories0.jpg">
                <a href="menu.php" class="btn">Vanilla</a>
            </div>
            <div class="box">
                <img src="images/categories2.jpg">
                <a href="menu.php" class="btn">Blueberry</a>
            </div> 
            <div class="box">
                <img src="images/categories1.jpg">
                <a href="menu.php" class="btn">Strawberry</a>
            </div> 
        </div>
    </div>

    <!-- Categories section end-->

    <img src="images/sale.jpg" class="menu-banner">

    <!-----Taste Section Start----->
    <div class="taste">
        <div class="heading">
            <span style="font-size: 2rem;">EXPLORE</span>
            <h1 style="font-family: Poetsen One, sans-serif; font-size: 3.5rem;">Exprience our unique products</h1>
            <img src="images/seperator_home.png">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="images/taste1.jpg">
                <div class="detail" style="color:black; margin-top: -.5rem;">
                    <h1 style="line-height: 1;">Coffee & Donuts Ice Cream</h1>
                </div>
            </div>
            <div class="box">
                <img src="images/taste2.jpg">
                <div class="detail" style="color:white; margin-top: -.5rem;">
                    <h1 style="line-height: 1;">Honey Pistachio Ice Cream</h1>
                </div>
            </div>
            <div class="box">
                <img src="images/taste3.jpg">
                <div class="detail" style="color:black; margin-top: -.5rem;">
                    <h1 style="line-height: 1;">Three-Way Banana Split Ice Cream</h1>
                </div>
            </div>
        </div>    
    </div>

    <!-----Taste Section end----->

    <!-----Trivia Section start----->

    <div class="ice-container">
        <div class="overlay"></div>
        <div class="detail">
            <h1> Ice cream is <br> happiness condensed</h1>
            <p style="padding: 0 20rem 0 20rem; margin-bottom: 2rem;">Indulge in our delectable selection of artisanal ice creams made with the finest ingredients. Whether you crave classic flavors or adventurous combinations, we have something to tantalize your taste buds. Explore our menu and treat yourself today!</p>
            <a href="menu.php" class="btn">Shop Now</a>
        </div>
    </div>

    <!-----Trivia Section end----->

    <!--flavor section start-->

    <div class="flavor">
        <div class="box-container">
            <div class="detail">
                <h1>Hot Deal! Sale Up To <span>50% off</span> </h1>
                <p>EXPIRED</p>
                <a href="menu.php" class="btn">shop now</a>
            </div>
            <img src="images/left-banner2.jpg">
            
        </div>
    </div>

    <!-- flavour section end-->

    <!--taste2 section start-->

    <div class="taste2">
        <div class="t-banner">
            <div class="overlay"></div>
            <div class="detail">
                <h1>find your taste of desserts</h1>
                <p>Treat them to a delicious treat and send them some Luck 'o the Irish too!</p>
                <a href="menu.php" class="btn">shop now</a>
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <div class="box-overlay"></div>
                <img src="images/type1.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>Cookies & Cream</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="images/type2.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>Rocky Road</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="images/type3.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>Blueberry</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="images/type4.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>Mango</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="images/type5.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>Strawberry</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="images/type6.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>Macha</h1>
                    <p>Find your taste of desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
                </div>
            </div>
        </div>
    </div>
    <!--taste2 section end-->

    

    <!-- pride section START -->
    <div class="pride">
        <div class="detail">
            <h1>We Pride Ourselves On <br> Exceptional Flavors.</h1>
            <p>Experience the richness of our handcrafted flavors,<br> meticulously crafted to delight your senses. <br>From creamy classics to daring innovations, <br>each scoop is a testament <br>to our commitment to excellence.</p>
            <a href="menu.php" class="btn">shop now</a>
        </div>
    </div>
    <!-- pride section end -->

    







    <?php include 'components/footer.php'; ?>    

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>

</body>