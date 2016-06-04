<!DOCTYPE html>
<html>
<head>
	<title>Reservation System</title>
	<script type="text/javascript" src="../../js/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="../../js/add_reservation_js_functions.js"></script>
	<?php include_once '../utility/project_defined_values.php';?>
</head>
<body>
	<header>
		<h1>Reservation System</h1>
		<h2>Add Reservation</h2>
	</header>
	<nav>
		<?php include_once '../utility/nav.php'?>
	</nav>
	<section>
		<?php 
			include_once '../utility/db_functions.php';
			$insert_operation_result = "";
			
			//check if it is a post request to add a new reservation inside the database
			if ($_SERVER['REQUEST_METHOD']=='POST'){
				
				try {
					//collect reservation parameters
					$start_time_h = $_POST['start_time_h'];
					$start_time_m = $_POST['start_time_m'];
					$duration_time = $_POST['duration_time'];
					
					//validate reservation parameters
					if(($start_time_h < MIN_HOUR || $start_time_h > MAX_HOUR) ||
							($start_time_m < MIN_MIN || $start_time_h > MAX_MIN) ||
							($duration_time < MIN_DURATION || $start_time_h > MAX_DURATION)) {
						throw new Exception("exception: reservation parameters out of range");			
					}
					
					//connect to the db
					$conn_id = connect_to_project_db();
					
					//check availbality of machine for the requested reservation
					$available_machine = check_machine_availability($conn_id, $start_time_h,
							$start_time_m, $duration_time);
					
					//if no exception (no availability) insert the new reservation
					insert_new_reservation($conn_id, 1 /*USER ID!!!*/, $start_time_h,
							$start_time_m, $duration_time, $available_machine);
						
					$insert_operation_result = '<span class="success">'."New reservation added
							succesfully!".'</span>';
					
					//close the connection
					
					disconnect_to_project_db($conn_id);
				}
				catch (Exception $e) {
					$insert_operation_result = '<span class="warning">'. $e->getMessage() . '</span>';
				}
			}
		?>
		
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>"> 
			<span class="warning">All fields are required</span>
			<table id="add_reservation_table">
			</table>
			<input type="submit" value="Add">
			<input type="button" value="Clear" onclick="clearAddReservationForm()">
		</form>
		<?php echo $insert_operation_result?>
		<script type="text/javascript">
			createAddReservationTable();
		</script>
	</section>
	<footer>
		<?php include_once '../utility/footer.php';?>
	</footer>
</body>
</html>