<?php include_once '../utility/project_defined_values.php';?>
<?php 
	//open the session relative to the received session cookie of the user
	//or create and send to the user the session cookie
	session_start();
	
	//check if there is already an opened session
	if(isset($_SESSION['user_id']) && isset($_SESSION['timeout'])){
		//reset all the session variables
		session_unset();
	}
	
	//destroy the session
	session_destroy();
	
	//redirect to the home page
	header("location: home.php");
	exit;
	
?>
