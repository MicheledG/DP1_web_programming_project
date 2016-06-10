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
 	$signup_error = "";
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
			$signup_error = '<span class="warning">'.'User "'
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
			
			//with a succesful sign in set the session parameters
			$_SESSION['user_id'] = $inserted_user['user_id'];
			$_SESSION['user_email'] = $inserted_user['email'];
			$_SESSION['user_name'] = $inserted_user['name'];
			$_SESSION['timeout'] = time();
			
			disconnect_to_project_db($conn_id);
			
			//redirect to the home page
			redirect_with_status("home.php", "signed_up");
		}
		catch (Exception $e) {
			$signup_error = '<span class="warning">'. $e->getMessage() . '</span>';
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
		<div id="signup-error-div">
			<p id="signup-error-msg" class="warning"><?php echo $signup_error?></p>
		</div>	
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" 
		onsubmit="return validateSignupForm()"> 
			<p>Insert your data</p>
			<ul id="sign-up-list">
				<li>
					<label>
						Name:
					</label>
					<input id="name" type="text" name="user_name" class="user_input" 
					required="required" value="<?php echo $user_name;?>">
					<p id="name-warning" class="warning"></p>
				</li>
				<li>
					<label>
						Last Name:
					</label>
					<input id="lastname" type="text" name="user_lastname" class="user_input" 
					required="required" value="<?php echo $user_lastname;?>">
					<p id="lastname-warning" class="warning"></p>
				</li>
				<li>
					<label>
						Email:
					</label>
					<input id="email" type="email" name="user_email" class="user_input" 
					required="required" value="<?php echo $user_email;?>">
					<p id="email-warning" class="warning"></p>
				</li>
				<li>
					<label>
						Password:
					</label>
					<input id="password" type="password" name="user_password" class="user_input" 
					required="required"	value="<?php echo $user_password;?>">
					<p id="password-warning" class="warning"></p>
				</li>
				<li>
					<label>
						Confirm Password:
					</label>
					<input id="confirm-password" type="password" name="user_confirm_password" class="user_input" 
					required="required">
					<p id="confirm-password-warning" class="warning"></p>
				</li>
				<li>
					<p class="warning">All fields are required</p>
				</li>
			</ul>
			<div id="buttons">
				<input type="submit" value="Submit">
				<input type="button" value="Clear" onclick="clearSignupForm()">
			</div>
		</form>
	</section>
	<footer>
		<?php include_once '../utility/footer.php';?>
	</footer>
</body>
</html>