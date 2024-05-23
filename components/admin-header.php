<header>
    <div class="logo">
        <img src="../images/logo.png" width="100">
    </div>
    
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="bx bx-menu"></i></div>
    </div>

    <div class="profile-detail" id="profile-detail">
        <?php if ($fetch_profile): ?>
            <div class="profile">
                <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" class="logo-img" width="130">
                <p><?= $fetch_profile['name']; ?></p>
                <div class="flex-btn">
                    <a href="profile.php" class="btn">Profile</a>
                    <a href="../components/admin_logout.php" onclick="return confirm('Are you sure you want to log out?');" class="btn">Logout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
</header>


<div class="sidebar-container">
	<div class="sidebar">
		<?php
			$select_profile = $conn->prepare("SELECT * FROM seller WHERE id = ?"); 
			$select_profile->execute([$seller_id]);
			
			if ($select_profile->rowCount() > 0) {
				$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
			}
		?>
	    <div class="profile">
	        <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" class="logo-img" width="125">
	        <p><?= $fetch_profile['name']; ?></p>
	    </div>
		<h5>menu</h5>
		<div class="navbar">
		    <ul>
		        <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i>dashboard</a></li>
		        <li><a href="add_product.php"><i class="bx bxs-shopping-bags"></i>add product</a></ li>
		        <li><a href="view_product.php"><i class="bx bxs-food-menu"></i>view products</a></li>
		        <li><a href="user_accounts.php"><i class="bx bxs-user-detail"></i>accounts</a></li>
		        <li><a href="../components/admin_logout.php" onclick="return confirm('Are you sure you want to log out?');"><i class="bx bx-log-out"></i>Log out</a></li>
		    </ul>
		</div>

		<h5>Our Social Media</h5>

		<div class="social-links">
		    <i class="bx bxl-facebook"></i>
		    <i class="bx bxl-instagram-alt"></i> 
		    <i class="bx bxl-linkedin"></i>
		    <i class="bx bxl-twitter"></i>
		    <i class="bx bxl-pinterest-alt"></i>
		</div>
	</div>
</div>

<script>
    document.addEventListener('scroll', function() {
        const profileElement = document.querySelector('.sidebar .profile');
        if (window.scrollY > 0) {
            profileElement.classList.add('scrolled');
        } else {
            profileElement.classList.remove('scrolled');
        }
    });
</script>

