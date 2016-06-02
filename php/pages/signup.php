<!DOCTYPE html>
<html>
<head>
	<title>Reservatation System</title>
	<script type="text/javascript" src="../../js/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="../../js/signup_js_functions.js"></script>
</head>
<body>
	<header>
		<h1>Reservation System</h1>
		<h2>Sign Up</h2>
	</header>
	<nav>
		<?php include_once '../utility/nav.php'?>
	</nav>
	<section>
		<?php 
			include_once '../utility/db_functions.php';
			$insert_operation_result = "";
			$user_name = "";
			$user_lastname = "";
			$user_email = "";
			$user_password = "";
			
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
		
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" onsubmit="return validateSignupForm()"> 
			<span class="warining">All fields are required</span>
			<table>
				<tr>
					<td>Name:</td>
					<td><input type="text" name="user_name" class="user_input" required="required"
						value="<?php echo $user_name;?>"></td>
					<td><span class="warning"></span></td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="user_lastname" class="user_input" required="required"
						value="<?php echo $user_lastname;?>"></td>
					<td><span class="warning"></span></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type="email" name="user_email" class="user_input" required="required"
						value="<?php echo $user_email;?>"></td>
					<td><span class="warning"></span></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="user_password" class="user_input" required="required"
						value="<?php echo $user_password;?>"></td>
					<td><span class="warning"></span></td>
				</tr>
				<tr>
					<td>Confirm Password:</td>
					<td><input type="password" name="user_confirm_password" class="user_input" required="required"></td>
					<td><span class="warning"></span></td>
				</tr>
			</table>
			<input type="submit" value="Submit">
			<input type="button" value="Clear" onclick="clearSignupForm()">
		</form>
		<?php echo $insert_operation_result?>
	</section>
	<footer>
		<?php include_once '../utility/footer.php';?>
	</footer>
</body>
</html>