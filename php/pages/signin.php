<!DOCTYPE html>
<html>
<head>
	<title>Reservation System</title>
	<script type="text/javascript" src="../../js/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="../../js/validate_input_js_functions.js"></script>
	<script type="text/javascript" src="../../js/signin_js_functions.js"></script>
	<?php include_once '../utility/project_defined_values.php';?>
</head>
<body>
	<header>
		<h1>Reservation System</h1>
		<h2>Sign In</h2>
	</header>
	<nav>
		<?php include_once '../utility/nav.php'?>
	</nav>
	<section>
		<?php 
			include_once '../utility/db_functions.php';
			$signin_operation_result = "";
			$user_email = "";
			$user_password = "";
			
			//check if it is a post request to add a new user inside the database
			if ($_SERVER['REQUEST_METHOD']=='POST'){
				
				try {
					//sanitize, validate and collect user input
					$user_email = validate_email(sanitize_user_input($_POST['user_email']));
					$user_password = validate_password(sanitize_user_input($_POST['user_password'])); 
					
					//connect and check if the user is already signed up
					$conn_id = connect_to_project_db();
					
					//returns user_id and name in an associative array
					$found_user = search_user($conn_id, $user_email, $user_password);
					
					$signin_operation_result = '<span class="success">'.'Welcome back"'
						.$found_user['name'].'"!</span>';
					
					disconnect_to_project_db($conn_id);
				}
				catch (Exception $e) {
					$signin_operation_result = '<span class="warning">'. $e->getMessage() . '</span>';
				}
			}
		?>
		
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" onsubmit="return validateSigninForm()"> 
			<span class="warining">All fields are required</span>
			<table>
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
			</table>
			<input type="submit" value="Submit">
			<input type="button" value="Clear" onclick="clearSigninForm()">
		</form>
		<?php echo $signin_operation_result?>
	</section>
	<footer>
		<?php include_once '../utility/footer.php';?>
	</footer>
</body>
</html>
