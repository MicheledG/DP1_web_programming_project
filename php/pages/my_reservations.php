<?php include_once '../utility/project_defined_values.php';?>
<?php include_once '../utility/utilities.php';?>
<?php include_once '../utility/db_functions.php';?>
<?php 
	require_COOKIE();
	//open the session relative to the received session cookie of the user
	//or create and send to the user the session cookie
	session_start(); 
	
	//check HTTPS connection
	require_HTTPS();
	
	//check if there is already an opened session
	if(isset($_SESSION['user_id']) && isset($_SESSION['timeout'])){
		//availble session for the specific user on the server
		$elapsed_time = time() - $_SESSION['timeout'];
		if($elapsed_time < MAX_SESSION_TIME){
			//set the new timeout session time
			$_SESSION['timeout'] = time();
		} 
		else {
			//session expired => redirect to sign out
			header("Location: https://" . $_SERVER["HTTP_HOST"] . "/dp_web_programming_project/php/pages/signout.php?status=expired");
		}
	}
	
?>
<?php 
	//manage reservation removal form
	include_once '../utility/db_functions.php';
	//prepare the remove operation result message
	$remove_operation_result = "";
	//check if it is a post request to add a new user inside the database
	if ($_SERVER['REQUEST_METHOD']=='POST'){
	
		try {
			//collect selected reservations to delete (if there is at least one selected reservation)
			if(!isset($_POST['selected_reservation'])) {
				throw new Exception("exception: not selected reservations to remove");
			}
			
			$selected_reservations = $_POST['selected_reservation'];
				
			//connect and delete all selected reservations then close connection
			$conn_id = connect_to_project_db();
			
			mysqli_autocommit($conn_id, false);
			
			foreach ($selected_reservations as $selected_reservation) {
					delete_reservation($conn_id, $selected_reservation);
			}
			
			mysqli_commit($conn_id);
			
			disconnect_to_project_db($conn_id);
		}
		catch (Exception $e) {
			mysqli_rollback($conn_id);
			$remove_operation_result = '<span class="warning">'. $e->getMessage() . '</span>';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reservation System</title>
	<script type="text/javascript" src="../../js/my_reservations_js_functions.js"></script>
	<link rel="stylesheet" href="../../css/common_style.css">
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
		<h2>My Reservations</h2>
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" 
		onsubmit="return validateRemoveReservationsForm()">
			<table>
			<thead>
				<tr>
					<td>Selected</td>
					<td>Reservation IDs</td>
					<td>Starting Times</td>
					<td>Duration Times</td>
					<td>Selected Machines</td>
				</tr>
			</thead>
			<tbody>
				<?php include_once "../utility/my_reservations_table.php"?>
			</tbody>
			</table>
			<?php echo $table_status;?>
			<a href="add_reservation.php"><input type="button" value="Add" ></a>
			<input type="submit" value="Remove">
			<?php echo $remove_operation_result;?>
		</form>
	</section>
	<footer>
		<?php include_once '../utility/footer.php';?>
	</footer>
</body>
</html>