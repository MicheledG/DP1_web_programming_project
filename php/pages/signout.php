<?php include_once '../utility/project_defined_values.php';?>
<?php include_once '../utility/utilities.php';?>
<?php include_once '../utility/db_functions.php';?>
<?php //manage cookie check and session 

	require_COOKIE();
	//open the session relative to the received session cookie of the user
	//or create and send to the user the session cookie
	session_start();
	
	//check HTTPS connection
	require_HTTPS();
	
	$user_email = "";
	$signout_result = "";
	
	//check if there is already an opened session
	if(isset($_SESSION['user_id'])){
		//there is an opened session of the user
		$user_email = $_SESSION['user_email'];
		//unset all the session variables
		session_unset();
		//destroy the session
		session_destroy();
		//check the cause of the sign out
		if(isset($_GET['status'])){
			//automatic redirect to the sign out page
			switch ($_GET['status']){
				case "expired":
					//session is expired redirect to sign in
					redirect_with_status("signin.php", "expired");
					break;
				default:
					//unexpected status prompt the user
					$signout_result = "Unexpected session status!";
					break;
			}
		}
		else {
			//simple sign out request of the user
			$signout_result = '<p class="success"> User "'.$user_email.'" signed out!</p>';
		}
	} 
	else {
		//no opened session
		$signout_result = '<p class="warning"> No signed in user to sign out! </p>';
		//destroy the session
		session_destroy();
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Reservation System</title>
	<link rel="stylesheet" href="../../css/common_style.css">
</head>
<body>
	<div id="main-container">
		
		<div id="header">
			<h1>Reservation System</h1>
		</div>
		
		<div id="center-container">
			
			<div id="nav">
				<?php include_once '../utility/nav.php'?>
			</div>
			
			<div id="section">
				<?php test_js();?>
				<p class="success"><?php echo $signout_result;?> </p>
			</div>
		
		</div>
		
		<div id="footer">
			<?php include_once '../utility/footer.php'?>
		</div>
		
	</div>
	
</body>
</html>