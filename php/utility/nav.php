<?php
	if(isset($_SESSION['user_email'])){
?>
		<div id="active-user-email">
			<h2>User</h2>
			<p id="user-email"><?php echo $_SESSION['user_email']; ?></p>
		</div>
		<div id="menu"><h2> Menu </h2>
			<ul>
				<li><a href="home.php">Home</a></li>
				<li><a href="my_reservations.php">My Reservations</a></li>
				<li><a href="signout.php">Sign Out</a></li>
			</ul>
		</div>

<?php
	}
	else {
?>
	
		<div id="menu"><h2> Menu </h2>
			<ul>
				<li><a href="home.php">Home</a></li>
				<li><a href="signin.php">Sign In</a></li>
				<li><a href="signup.php">Sign Up</a></li>
			</ul>
		</div>
		
<?php 
	}
?>
