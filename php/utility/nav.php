<?php

	if(isset($_SESSION['user_email'])){
		$nav_content = '<span id="active_user_email"> User: "'.$_SESSION['user_email'].'"</span>';
		$nav_content .= '<a href="home.php">Home</a>';
		$nav_content .= '<a href="my_reservations.php">My Reservations</a>';
	}
	else {
		$nav_content = '<a href="home.php">Home</a>';
		$nav_content .= '<a href="signup.php">Sign Up</a>';
		$nav_content .= '<a href="signin.php">Sign In</a>';
	}
	
	echo $nav_content;

?>