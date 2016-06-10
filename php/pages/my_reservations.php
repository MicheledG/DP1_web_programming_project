<?php include_once '../utility/project_defined_values.php';?>
<?php include_once '../utility/utilities.php';?>
<?php include_once '../utility/db_functions.php';?>
<?php //manage cookie check and session

	//check cookies are enabled
	require_COOKIE();
	
	//check HTTPS connection
	//require_HTTPS();
	
	session_start(); 
	
	//check if there is already an active session
	if(isset($_SESSION['user_id']) && isset($_SESSION['timeout'])){
		//active session for the specific user on the server
		//check if the session is expired
		$elapsed_time = time() - $_SESSION['timeout'];
		if($elapsed_time < MAX_SESSION_TIME){
			//session not expired
			//update session timeout
			$_SESSION['timeout'] = time();
		} 
		else {
			//session expired => redirect to sign out
			redirect_with_status("signout.php", "expired");
		}
	}
	
?>
<?php //manage reservation removal
	
	//remove operation message
	$remove_operation_result = "";
	
	//check if it is a post request to remove reservations from database
	if ($_SERVER['REQUEST_METHOD']=='POST'){
	
		try {
			//collect selected reservations to delete (if there is at least one selected reservation)
			if(!isset($_POST['selected_reservation'])) {
				throw new Exception("exception: not selected reservations to remove");
			}
			
			$selected_reservations = $_POST['selected_reservation'];
				
			//connect and start transaction to delete all selected reservations then close connection
			$conn_id = connect_to_project_db();
			
			mysqli_autocommit($conn_id, false);
			
			foreach ($selected_reservations as $selected_reservation) {
					delete_reservation($conn_id, $selected_reservation);
			}
			
			mysqli_commit($conn_id);
			
			$remove_operation_result = '<p class="success"> Reservations removed </p>';
			
			disconnect_to_project_db($conn_id);
		}
		catch (Exception $e) {
			mysqli_rollback($conn_id);
			$remove_operation_result = '<p class="warning">'. $e->getMessage() . '</p>';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reservation System</title>
	<script type="text/javascript" src="../../js/my_reservations_js_functions.js"></script>
	<link rel="stylesheet" href="../../css/common_style.css">
	<link rel="stylesheet" href="../../css/my_reservations_style.css">
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
				<h2>My Reservations</h2>
				<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" 
				onsubmit="return validateRemoveReservationsForm()">
					<table id="my-reservations-table">
					<caption>
						Reservations Table
					</caption>
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
						<?php //retrieve the reservations from the db
		
							$tot_reservations = "";
							$table_warning = "";
				
							try{
								//retrieve reservations for the actual user_id (session needs to be implemented)
								$conn_id = connect_to_project_db();
								
								$user_reservations = retrieve_reservations($conn_id, $_SESSION['user_id']);
							
								if(mysqli_num_rows($user_reservations) > 0){
									//put in the table the reservations
									$reservation_number = 0;
									while($reservation = mysqli_fetch_assoc($user_reservations)) {
										//compute start_time_h and start_time_m
										$start_time_h = floor($reservation['start_time'] / 60);
										$start_time_m = $reservation['start_time'] % 60;
										
										//update number of reservation
										$reservation_number++;
										?>
										
										<!-- output the reservation row -->
										<tr>
											<td>
												<input type="checkbox" name="selected_reservation[]" 
												value="<?php echo $reservation['res_id']; ?>">
											</td>
											<td>
												<?php echo $reservation['res_id']; ?>
											</td>
											<td>
												<?php printf("%02d:%02d", $start_time_h, $start_time_m); ?>
											</td>
											<td>
												<?php echo $reservation['duration_time']; ?>
											</td>
											<td>
												<?php echo $reservation['selected_machine']; ?>
											</td>
										</tr>
										
										<?php 
									}
									$tot_reservations = $reservation_number;
								}
								else {
									//no reservations available for the actual user_id
									$tot_reservations = 0;
								}
							}
							catch (Exception $e) {
								$table_warning = 'Error occured downloading reservations';
							}
						?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<p>Total reservations: <?php echo $tot_reservations;?></p>
							</td>
						</tr>
					</tfoot>
					</table>
						
					<div id="table-warning">
						<p class="warning"><?php echo $table_warning;?></p>
					</div>
					
					<div id="buttons">
						<a href="add_reservation.php"><input type="button" value="Add" ></a>
						<input type="button" value="Clear" onclick="clearRemoveReservationsForm()">
						<input type="submit" value="Remove">
					</div>
					
					<div id="remove-operation-result">
						<?php echo $remove_operation_result;?>	
					</div>
					
				</form>
			</div>
		
		</div>
		
		<div id="footer">
			<?php include_once '../utility/footer.php';?>
		</div>
		
	</div>
	
</body>
</html>