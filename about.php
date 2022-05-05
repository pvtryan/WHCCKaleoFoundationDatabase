<?php require_once("includes/all.php") ?>

<?php logout() ?>
<?php  $year = year();?>

<?php require_once("partials/home/header.php") ?>
<div class="about-info">
<h1>About Page</h1>
	<hr>


	<h2 class='center'>Purpose</h2>
	<div class='show-container'>
	<button class='show-more-button'></button>
	<div class='about-info-content'>
    <p>This Site was created for the Western Hills Christian Church of Lawton, OK to be used for tracking and reporting of inventroy they have recived or have given out.</p>
    </div>
    </div>
    <hr>

    <h2 class='center'>Languages and OS</h2>
	<div class='show-container'>
	<button class='show-more-button'></button>
	<div class='about-info-content'>
		<ul class='role-privileges'>
			<li>HTML/CSS/JavaScript for front end Web forms.</li>
			<li>PHP middleware.</li>
			<li>SQL backend with MySQL database server.</li>
			<li>Linux/Unix.</li>
			<!--<li><a target="_blank" href="https://github.com/cu-capstone-team2/capstone_project/">Github Repository</a></li>-->
		</ul>
	</div>
	</div>

	<!--
		DEVELOPERS OF THE PROJECT
	-->
	<hr>

   
    
    <h2 class='center'>Contact And Developer</h2>
	<div class='show-container'>
	<button class='show-more-button'></button>
	<div class='about-info-content'>
        <ul class='role-privileges'>
            <li>Ryan Cox</li>
            <li>Phone: (580)-606-3014</li>
            <li>Email 1: <a href="mailto:ryancox@ryancox.site?Subject=Western Hills">ryancox@ryancox.site</a>
            <li>Email 2: <a href="mailto:ryan.cox2@cameron.edu?Subject=Western Hills">ryan.cox2@cameron.edu</a>
        </ul>
    </div>
	</div>
</div>

<hr>
<h2 class='center'>Created by Ryan Cox &copy <?=$year["year"]?></h2>
<?php require_once("partials/home/footer.php") ?>
<script src='js/about.js'></script>