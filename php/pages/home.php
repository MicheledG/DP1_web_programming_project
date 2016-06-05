<?php include_once '../utility/project_defined_values.php';?>
<?php 
	//open the session relative to the received session cookie of the user
	//or create and send to the user the session cookie
	session_start(); 
	
	//check if there is already an opened session
	if(isset($_SESSION['user_id']) && isset($_SESSION['timeout'])){
		//availble session for the specific user on the server
		$elapsed_time = time() - $_SESSION['timeout'];
		if($elapsed_time < MAX_SESSION_TIME){
			//set the new timeout session time
			$_SESSION['timeout'] = time();
		} 
		else {
			//session expired
			//reset all the session variables
			session_unset();
			//NOT DESTROY THE SESSION!
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reservation System</title>
</head>
<body>
	<header>
		<h1>Reservation System</h1>
		<h2>Home</h2>
	</header>
	<nav>
		<?php include_once '../utility/nav.php'?>
	</nav>
	<section>
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