<?php include_once '../utility/project_defined_values.php';?>
<?php 
	//open the session relative to the received session cookie of the user
	//or create and send to the user the session cookie
	session_start();
	$signout_result = "";
	
	//check if there is already an opened session
	if(isset($_SESSION['user_id'])){
		//there should always be an opened session
		$signout_result = '<p class="success"> User "'.$_SESSION['user_email'].'" signed out!</p>';
	} 
	else {
		$signout_result = '<p class="warning"> No signed in user to signed out! </p>';
	}
	
	//unset all the session variables
	session_unset();
	//destroy the session
	session_destroy();
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Reservation System</title>
	<link rel="stylesheet" href="../../css/common_style.css">
	<link rel="stylesheet" href="../../css/home_style.css">
</head>
<body>
	<header>
		<h1>Reservation System</h1>
	</header>
	<nav>
		<?php include_once '../utility/nav.php'?>
	</nav>
	<section>
		<p class="success"><?php echo $signout_result;?> </p>
	</section>
	<footer>
		<?php include_once '../utility/footer.php'?>
	</footer>
</body>
</html>