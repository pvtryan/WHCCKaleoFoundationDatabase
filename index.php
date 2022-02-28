<?php 

// connect to database, authentication functions, and common functions
require_once("includes/all.php");

// allows logout the user on homepage
logout();




?>

<?php require_once("partials/home/header.php") ?>

	
	<button class="button" onclick="document.location='login.php'">Login</button>
	<br>
	<br>
	<div class="welcome">
			<div class="welcome_text">
				Kaleo Foundation - WHCC <br> Inventory System
				
				
			</div>	
	<br>	
    </div>
	<?php require_once("partials/home/footer.php") ?>

