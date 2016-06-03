<!DOCTYPE html>
<html>
<head>
	<title>Add Reservation</title>
	<script type="text/javascript" src="../../js/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="../../js/add_reservation_js_functions.js"></script>
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
			
			//check if it is a post request to add a new user inside the database
			if ($_SERVER['REQUEST_METHOD']=='POST'){
				
				try {
					//sanitize, validate and collect user input
					$user_name = validate_name(sanitize_user_input($_POST['user_name']));
					$user_lastname = validate_name(sanitize_user_input($_POST['user_lastname']));
					$user_email = validate_email(sanitize_user_input($_POST['user_email']));
					$user_password = validate_password(sanitize_user_input($_POST['user_password']));
					$user_confirm_password = validate_password(sanitize_user_input($_POST['user_confirm_password'])); 
					
					//check if password and confirm password are equal
					if(strcmp($user_password, $user_confirm_password) != 0){
						throw new Exception("exception: password and confirmed password are different");
					}
					
					//connect, add user to the users table and close connection
					$conn_id = connect_to_project_db();
					
					insert_new_user($conn_id, $user_name, $user_lastname,
							$user_email, $user_password);
					
					$insert_operation_result = '<span class="success">'."user with username '"
							.$user_email."' added succesfully!".'</span>';
					
					disconnect_to_project_db($conn_id);
				}
				catch (Exception $e) {
					$insert_operation_result = '<span class="warning">'. $e->getMessage() . '</span>';
				}
			}
		?>
		
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