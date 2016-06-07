<?php include_once '../utility/project_defined_values.php';?>
<?php include_once '../utility/utilities.php';?>
<?php 
	//check if cookies are enabled
	require_COOKIE();
	
	//open the session relative to the received session cookie of the user
	//or create and send to the user the session cookie
	session_start(); 
	
	//check if there is already an opened session
	if(isset($_SESSION['user_id']) && isset($_SESSION['timeout'])){
		//availble session for the specific user on the server
		$elapsed_time = time() - $_SESSION['timeout'];
		if($elapsed_time < MAX_SESSION_TIME){
			//valid session for the user
			//update the new timeout session time
			if(isset($_SESSION['just_signedin'])){
				//user just singned in
				//first clear the flag
				unset($_SESSION['just_signedin']);
				//greetings to the user
				echo '<script type="text/javascript">
					alert("User \"'.$_SESSION['user_email'].'\" succesfully signed in!");
				</script>';
			}
			elseif (isset($_SESSION['just_signedup'])){
				//user just signed up
				//first clear the flag
				unset($_SESSION['just_signedup']);
				//greetings to the user
				echo '<script type="text/javascript">
					alert("User \"'.$_SESSION['user_email'].'\" succesfully signed up!");
				</script>';
			}
		} 
		else {
			//session expired
			session_unset();
			session_destroy();
		}
	}
	
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
		<?php test_js();?>
		<h2>Home</h2>
		<table>
			<thead>
				<tr>
					<td>Reservation IDs</td>
					<td>Starting Times</td>
					<td>Duration Times</td>
					<td>Selected Machines</td>
					<td>Users</td>
				</tr>
			</thead>
			<tbody>
				<?php include_once "../utility/reservations_table.php"?>
			</tbody>
		</table>
		<?php echo $table_status;?>
	</section>
	<footer>
		<?php include_once '../utility/footer.php'?>
	</footer>
</body>
</html>