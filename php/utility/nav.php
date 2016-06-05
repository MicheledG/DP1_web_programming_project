<?php
	
	$nav_content = '<ul>';

	if(isset($_SESSION['user_email'])){
		$nav_content .= '<li><span id="active_user_email"> User: "'.$_SESSION['user_email'].'"</span></li>';
		$nav_content .= '<li><a href="home.php">Home</a></li>';
		$nav_content .= '<li><a href="my_reservations.php">My Reservations</a></li>';
		$nav_content .= '<li><a href="signout.php">Sign Out</a></li>';
	}
	else {
		$nav_content .= '<li><a href="home.php">Home</a></li>';
		$nav_content .= '<li><a href="signin.php">Sign In</a></li>';
		$nav_content .= '<li><a href="signup.php">Sign Up</a></li>';
	}
	
	$nav_content .= '</ul>';
	
	echo $nav_content;

?>