<?php include_once '../utility/project_defined_values.php';?>
<?php include_once '../utility/utilities.php';?>
<?php include_once '../utility/db_functions.php';?>
<?php //manage cookie check and session 
	
	//check if cookies are enabled
	require_COOKIE();
	
	//open the session relative to the received session cookie of the user
	//or create and send to the user the session cookie
	session_start(); 
	
	//check if there is an opened session
	if(isset($_SESSION['user_id']) && isset($_SESSION['timeout'])){
		//availble session for the specific user on the server
		//check if expired session
		$elapsed_time = time() - $_SESSION['timeout'];
		if($elapsed_time < MAX_SESSION_TIME){
			//session not expired
			//update the session timeout
			$_SESSION['timeout'] = time();
			//check user status
			if(isset($_GET['status'])){
				switch ($_GET['status']){
					case "signed_in":
						//user just signed in
						echo '<script type="text/javascript">
							alert("User \"'.$_SESSION['user_email'].'\" succesfully signed in!");
							</script>';
						break;
					case "signed_up":
						//user just signed up
						echo '<script type="text/javascript">
							alert("User \"'.$_SESSION['user_email'].'\" succesfully signed up!");
							</script>';
						break;
					default:
						//unexpected
						break;
				}
			}
		} 
		else {
			//session expired => redirect to sign out
			header("Location: https://" . $_SERVER["HTTP_HOST"] . "/dp_web_programming_project/php/pages/signout.php?status=expired");
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
				<?php //retrieve reservations for the all the users 
				
					try{
						$conn_id = connect_to_project_db();
					
						$reservations = retrieve_reservations($conn_id);
					
						if(mysqli_num_rows($reservations) > 0){
							//put in the table the reservations
							$reservation_number = 0;
							while($reservation = mysqli_fetch_assoc($reservations)) {
								echo '<tr>';
								echo '<td>';
								echo $reservation['res_id'];
								echo '</td>';
								//compute start_time_h and start_time_m
								$start_time_h = floor($reservation['start_time'] / 60);
								$start_time_m = $reservation['start_time'] % 60;
								echo '<td>';
								printf("%02d:%02d", $start_time_h, $start_time_m);
								echo '</td>';
								echo '<td>';
								echo $reservation['duration_time'];
								echo '</td>';
								echo '<td>';
								echo $reservation['selected_machine'];
								echo '</td>';
								echo '<td>';
								echo $reservation['email'];
								echo '</td>';
								echo '</tr>';
								$reservation_number++;
							}
							$table_status = '<span class="success">Nr. reservations: '.$reservation_number.'</span>';
						}
						else {
							//no reservations available
							$table_status = '<span class="warning">No registered reservations</span>';
						}
					}
					catch (Exception $e) {
						echo $table_status = '<span class="warning">Error occured downloading reservations</span>';
					}
				?>
			</tbody>
		</table>
		<?php echo $table_status;?>
	</section>
	<footer>
		<?php include_once '../utility/footer.php'?>
	</footer>
</body>
</html>