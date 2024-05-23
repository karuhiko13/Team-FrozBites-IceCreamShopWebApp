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
    <title>FrozBites - About Us</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>

    <?php include 'components/user_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>about us</h1>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>about us </span>
        </div>
    </div>

    <div class="chef">
        <div class="box-container">
            <div class="box cntent">
                <div class="heading">
                    <span>Krisha Reyes</span>
                    <h1>Masterchef</h1>
                    <img src="images/seperator_home.png">
                </div>
                <p>Meet Krisha Reyes, a true master of frozen indulgence with over a decade of experience under her belt. With an innate talent for crafting heavenly ice cream creations, Krisha's innovative flavors and unwavering commitment to quality have earned her a place among the elite in the culinary world. Her passion, creativity, and genuine love for her craft shine through in every scoop, delighting taste buds and warming hearts alike.</p>
                <div class="flex-btn">
                    <a href="" class="btn">explore our menu</a>
                </div>
            </div>
            <div class="box withbg">
                <img src="images/ceaf.png" class="img">
            </div>
        </div>
    </div>

    <div class="story">
        <div class="heading">
            <h1>Our Story</h1>
            <img src="images/seperator_home.png">
        </div>
        <p>
            Established in 2024, FrozBites emerged with a simple yet powerful belief: that exceptional ice cream has the power to create unforgettable moments. From our very first scoop, we've been on a mission to craft frozen treats that transcend the ordinary, blending the finest ingredients with boundless creativity to delight taste buds and warm hearts alike. With each passing year, our dedication to quality and innovation has only grown stronger, earning FrozBites a cherished place in the hearts of ice cream aficionados far and wide.
            <br><br>
            Our commitment to spreading joy, flavor, and frozen happiness is unwavering, and as we continue our sweet journey, we invite you to join us in savoring the magic of FrozBites—a place where every spoonful is a celebration of love, laughter, and the simple joys of life. 
        </p>
        <a href="menu.php" class="btn">Our Services</a>
    </div>

    <div class="container">
        <div class="box-container">
            <div class="img-box">
                <img src="images/about.png">
            </div>
            <div class="box">
                <div class="heading">
                    <h1 >Indulge in Our Heavenly Ice Cream Experience</h1>
                    <img src="images/seperator_home.png" style="margin-bottom: 2rem;">
                </div>
                <p style="margin-bottom: 2rem;">Discover the bliss of our artisanal ice cream, meticulously crafted to tantalize your taste buds and elevate your senses.
                </p> 
                <a href="" class="btn">learn more</a>
            </div>
        </div>
    </div>

    <!-- team section start-->
    <div class="team">
        <div class="heading">
            <span>Our Organization</span>
            <h1>Quality & passion with our services</h1>
            <img src="images/seperator_home.png" alt="">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="images/team-1.jpg" class="img">
                <div class="content">
                    <img src="images/shape-19.png" alt="chef" class="shap">
                    <h2>Mikko Panuculan</h2>
                    <p>Chief Executive Officer</p>
                </div>
            </div>
            <div class="box">
                <img src="images/team-2.jpg" class="img">
                <div class="content">
                    <img src="images/shape-19.png" alt="chef" class="shap">
                    <h2>Mark Opis</h2>
                    <p>Operations Manager</p>
                </div>
            </div>
            <div class="box">
                <img src="images/team-3.jpg" class="img">
                <div class="content">
                    <img src="images/shape-19.png" alt="chef" class="shap">
                    <h2>Nathaniel Layag</h2>
                    <p>Marketing Manager</p>
                </div>
            </div>
            <div class="box">
                <img src="images/team-4.jpg" class="img">
                <div class="content">
                    <img src="images/shape-19.png" alt="chef" class="shap">
                    <h2>Ginalyn Vasquez</h2>
                    <p>Finance Manager</p>
                </div>
            </div>
            <div class="box">
                <img src="images/team-5.jpg" class="img">
                <div class="content">
                    <img src="images/shape-19.png" alt="chef" class="shap">
                    <h2>Aizel Reyes</h2>
                    <p>Human Resources Manager</p>
                </div>
            </div>
            <div class="box">
                <img src="images/team-6.jpg" class="img">
                <div class="content">
                    <img src="images/shape-19.png" alt="chef" class="shap">
                    <h2>Chester Manzo</h2>
                    <p>Product Manager</p>
                </div>
            </div>
        </div>
    </div>
    <!-- team section end-->

    <!-- our values start-->

    <div class="standers">
    <div class="detail">
        <div class="heading">
            <h1>Our Mission, Vision, and Goal</h1>
            <img src="images/seperator_home.png">
        </div>
        <span>Vision</span>
        <p>To become the premier destination for ice cream lovers worldwide, offering innovative flavors and exceptional experiences that delight our customers.</p>
        <i class="bx bxs-heart"></i> <br><br><br>

        <span>Mission</span>
        <p>At FrozBites, our mission is to craft delicious, high-quality ice cream using only the finest ingredients, while maintaining a commitment to sustainability and community involvement.</p>
        <i class="bx bxs-heart"></i><br><br><br>

        <span>Goal</span>
        <p>Our goal is to spread joy and happiness through our delectable treats, fostering memorable moments and creating a loyal community of ice cream enthusiasts around the globe.</p>
        <i class="bx bxs-heart"></i><br><br><br>
    </div>
</div>


    <!-- testimonial section start-->

    <div class="testimonial">
        <div class="heading">
            <h1>Testimonials</h1>
            <img src="images/seperator_home.png">
        </div>
        <div class="testimonial-container">
            <div class="slide-row" id="slide">
                <div class="slide-col">
                    <div class="user-text">
                        <p>"FrozBites is a game-changer in the world of ice cream. Their dedication to quality and customer satisfaction is evident in every bite. I'm hooked for life!"</p>
                        <h2>Sarah Brown</h2>
                        <p>Artist</p>
                    </div>
                    <div class="user-img">
                        <img src="images/testimonial (1).jpg">
                    </div>
                </div>

                <div class="slide-col">
                    <div class="user-text">
                        <p>"FrozBites has redefined my ice cream experience. Each scoop is bursting with flavor, and their commitment to using natural ingredients sets them apart. Simply irresistible!"</p>
                        <h2>Jane Smith</h2>
                        <p>Blogger</p>
                    </div>
                    <div class="user-img">
                        <img src="images/testimonial (2).jpg">
                    </div>
                </div>

                <div class="slide-col">
                    <div class="user-text">
                        <p>"I've tried countless ice cream shops, but FrozBites truly stands out. The flavors are divine, and the delivery is always prompt. My go-to dessert destination!"</p>
                        <h2>John Doe</h2>
                        <p>Architect</p>
                    </div>
                    <div class="user-img">
                        <img src="images/testimonial (3).jpg">
                    </div>
                </div>

                <div class="slide-col">
                    <div class="user-text">
                        <p>"As a self-proclaimed ice cream connoisseur, I can confidently say that FrozBites surpasses all expectations. From classic flavors to innovative creations, they never disappoint!"</p>
                        <h2>David Johnson</h2>
                        <p>Author</p>
                    </div>
                    <div class="user-img">
                        <img src="images/testimonial (4).jpg">
                    </div>
                </div>
            </div>
        </div>
        <div class="indicator">
            <span class="btn1 active"></span>
            <span class="btn1"></span>
            <span class="btn1"></span>
            <span class="btn1"></span>
            
        </div>
    </div>











    <?php include 'components/footer.php'; ?>    

    <!--sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>

    <script type="text/javascript">
        /*----testimonial slider----*/

        const btn = document.getElementsByClassName('btn1');
        const slide = document.getElementById('slide');
        let currentIndex = 0;
        let intervalId = null;

        // Function to move the slider to a specific slide
        function moveToSlide(index) {
            const offset = -800 * index;
            slide.style.transform = `translateX(${offset}px)`;
            for (let i = 0; i < btn.length; i++) {
                btn[i].classList.remove('active');
            }
            btn[index].classList.add('active');
        }

        // Function to move to the next slide
        function nextSlide() {
            currentIndex = (currentIndex + 1) % btn.length;
            moveToSlide(currentIndex);
        }

        // Set interval to change slides automatically
        function startSlider() {
            intervalId = setInterval(nextSlide, 3000); // Change slide every 3 seconds
        }

        // Start the slider initially
        startSlider();

        // Pause the slider when the user hovers over it
        slide.addEventListener('mouseenter', () => {
            clearInterval(intervalId);
        });

        // Resume the slider when the user moves the mouse out
        slide.addEventListener('mouseleave', () => {
            startSlider();
        });

        // Event listeners for manual navigation
        for (let i = 0; i < btn.length; i++) {
            btn[i].addEventListener('click', function() {
                currentIndex = i;
                moveToSlide(currentIndex);
                clearInterval(intervalId); // Stop automatic sliding when manual navigation is used
            });
        }
    </script>

</body>