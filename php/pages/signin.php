<?php include_once '../utility/project_defined_values.php';?>
<?php 
	//open the session relative to the received session cookie of the user
	//or create and send to the user the session cookie
	session_start(); 
 	$user_signedin = false;
 	$signin_operation_result = "";
 	$user_email = "";
 	$user_password = "";
	
	//check if there is already an opened session
	if(isset($_SESSION['user_id']) && isset($_SESSION['timeout'])){
		//availble session for the specific user on the server
		$elapsed_time = time() - $_SESSION['timeout'];
		if($elapsed_time < MAX_SESSION_TIME){
			//still valid session
			$signin_operation_result = '<span class="warning">'.'User "'
						.$_SESSION['user_email'].'" already signed in!</span>';
			//set the new timeout session time
			$_SESSION['timeout'] = time();
			$user_signedin = true;
		} 
		else {
			//session expired
			//reset all the session variables
			session_unset();
			//NOT DESTROY THE SESSION!
		}
	}
	
?>
<?php 
	//manage the sign in operation
	include_once '../utility/db_functions.php';
	
	//check if it is a post request to add a new user inside the database
	if ($_SERVER['REQUEST_METHOD']=='POST' && !$user_signedin){
		
		try {
			//sanitize, validate and collect user input
			$user_email = validate_email(sanitize_user_input($_POST['user_email']));
			$user_password = validate_password(sanitize_user_input($_POST['user_password'])); 
			
			//connect and check if the user is already signed up
			$conn_id = connect_to_project_db();
			
			//returns user_id and name in an associative array
			$found_user = search_user($conn_id, $user_email, $user_password);
			
			$signin_operation_result = '<span class="success">'.'Welcome back "'
				.$found_user['name'].'"!</span>';
			
			//with a succesful sign in set the session parameters
			$_SESSION['user_id'] = $found_user['user_id'];
			$_SESSION['user_email'] = $found_user['email'];
			$_SESSION['user_name'] = $found_user['name'];
			$_SESSION['timeout'] = time();
			
			disconnect_to_project_db($conn_id);
			
			//redirect to the home page
			header("location: home.php");
		}
		catch (Exception $e) {
			$signin_operation_result = '<span class="warning">'. $e->getMessage() . '</span>';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reservation System</title>
	<script type="text/javascript" src="../../js/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="../../js/validate_input_js_functions.js"></script>
	<script type="text/javascript" src="../../js/signin_js_functions.js"></script>
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
