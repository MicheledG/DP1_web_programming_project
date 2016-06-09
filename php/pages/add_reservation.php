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
			redirect_with_status("signout.php", "expired");
		}
	}
	
?>
<?php //manage reservation isertion form 
	
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
			
			//start transaction to insert a new reservation
			mysqli_autocommit($conn_id, false);
			
			//check availability of machine for the requested reservation
			$available_machine = check_machine_availability($conn_id, $start_time_h,
					$start_time_m, $duration_time);
			
			//if no exception (there is availability) insert the new reservation
			insert_new_reservation($conn_id, $_SESSION['user_id'], $start_time_h,
					$start_time_m, $duration_time, $available_machine);
				
			$insert_operation_result = '<span class="success">'."New reservation added
					succesfully!".'</span>';
			
			//everything is ok
			mysqli_commit($conn_id);
			
			//close the connection
			
			disconnect_to_project_db($conn_id);
		}
		catch (Exception $e) {
			mysqli_rollback($conn_id);
			$insert_operation_result = '<span class="warning">'. $e->getMessage() . '</span>';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reservation System</title>
	<script type="text/javascript" src="../../js/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="../../js/add_reservation_js_functions.js"></script>
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
		<h2>Add Reservation</h2>
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" onsubmit="return validateAddReservationForm()"> 
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