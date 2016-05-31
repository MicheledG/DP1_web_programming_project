<!DOCTYPE html>
<html>
<head>
	<title>Reservatation System</title>
	<script type="text/javascript" src="jquery-1.12.4.js"></script>
	<script type="text/javascript" src="signup_js_functions.js"></script>
</head>
<body>
	<header>
		<h1>Reservation System</h1>
		<h2>Sign Up</h2>
	</header>
	<nav>
		<?php include 'nav.php'?>
	</nav>
	<section>
		<?php 
			include 'db_functions.php';
			if ($_SERVER['REQUEST_METHOD']=='POST'){
				try {
					$conn_id = connect_to_project_db();
					
					$user_name = $_POST['user_name'];
					$user_last_name = $_POST['user_last_name'];
					$user_email = $_POST['user_email'];
					$user_password = $_POST['user_password'];
					
					insert_new_user($conn_id, $user_name, $user_last_name, $user_email, $user_password);
					
					echo "User with username '".$user_email."' added succesfully!";
					
					disconnect_to_project_db($conn_id);
				}
				catch (Exception $e) {
					die($e->getMessage());
				}
			}
		?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>"> 
			<table>
				<tr>
					<td>Name:</td>
					<td><input type="text" name="user_name" class="user_input"></td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="user_last_name" class="user_input"></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type="email" name="user_email" class="user_input"></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="user_password" class="user_input"></td>
				</tr>
				<tr>
					<td>Confirm Password:</td>
					<td><input type="password" name="user_confirm_password" class="user_input"></td>
				</tr>
			</table>
			<input type="submit" value="Submit">
			<input type="button" value="Clear" onclick="clearSignupForm()">
		</form>
	</section>
	<footer>
		<?php include 'footer.php';?>
	</footer>
</body>
</html>