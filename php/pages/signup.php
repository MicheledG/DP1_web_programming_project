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
	
	
 	$user_signedin = false;
 	$insert_operation_result = "";
	$user_name = "";
	$user_lastname = "";
	$user_email = "";
	$user_password = "";
	
	
	//check if there is already an opened session
	if(isset($_SESSION['user_id']) && isset($_SESSION['timeout'])){
		//availble session for the specific user on the server
		$elapsed_time = time() - $_SESSION['timeout'];
		if($elapsed_time < MAX_SESSION_TIME){
			//still valid session
			$insert_operation_result = '<span class="warning">'.'User "'
						.$_SESSION['user_email'].'" already signed in!</span>';
			//set the new timeout session time
			$_SESSION['timeout'] = time();
			$user_signedin = true;
		} 
		else {
			//session expired
			//session expired => redirect to sign out
			//header("Location: https://" . $_SERVER["HTTP_HOST"] . "/dp_web_programming_project/php/pages/signout.php?status=expired");
			header("Location: https://" . $_SERVER["HTTP_HOST"] . "/~s231050/53474c/php/pages/signout.php?status=expired");
		}
	}
	
?>
<?php //manage sign up form
	
	//check if it is a post request to add a new user inside the database
	if ($_SERVER['REQUEST_METHOD']=='POST' && !$user_signedin){
		
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
			
			$inserted_user = insert_new_user($conn_id, $user_name, $user_lastname,
					$user_email, $user_password);
			
			$insert_operation_result = '<span class="success">'."user with username '"
					.$user_email."' added succesfully!".'</span>';
			
			//with a succesful sign in set the session parameters
			$_SESSION['user_id'] = $inserted_user['user_id'];
			$_SESSION['user_email'] = $inserted_user['email'];
			$_SESSION['user_name'] = $inserted_user['name'];
			$_SESSION['timeout'] = time();
			
			disconnect_to_project_db($conn_id);
			
			//redirect to the home page
			//header("Location: https://" . $_SERVER["HTTP_HOST"] . "/dp_web_programming_project/php/pages/home.php?status=signed_up");
			header("Location: https://" . $_SERVER["HTTP_HOST"] . "/~s231050/53474c/php/pages/home.php?status=signed_up");
		}
		catch (Exception $e) {
			$insert_operation_result = '<span class="warning">'. $e->getMessage() . '</span>';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reservation System</title>
	<script type="text/javascript" src="../../js/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="../../js/validate_input_js_functions.js"></script>
	<script type="text/javascript" src="../../js/signup_js_functions.js"></script>
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
		<?php test_js()?>
		
		<h2>Sign Up</h2>
		<fieldset>
			<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" onsubmit="return validateSignupForm()"> 
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
				<span class="warining">All fields are required</span>
				<input type="submit" value="Submit">
				<input type="button" value="Clear" onclick="clearSignupForm()">
			</form>
		</fieldset>
		<?php echo $insert_operation_result?>
	</section>
	<footer>
		<?php include_once '../utility/footer.php';?>
	</footer>
</body>
</html>