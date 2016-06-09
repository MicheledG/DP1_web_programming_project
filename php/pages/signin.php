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
 	$user_email = "";
 	$user_password = "";
 	$signin_error = "";
	
	//check if there is already an opened session
	if(isset($_SESSION['user_id']) && isset($_SESSION['timeout'])){
		//availble session for the specific user on the server
		$elapsed_time = time() - $_SESSION['timeout'];
		if($elapsed_time < MAX_SESSION_TIME){
			//still valid session => set the new timeout session time
			$_SESSION['timeout'] = time();
			$user_signedin = true;
			$signin_error = 'User "'.$_SESSION['user_email'].'" already signed in';
			echo '<script type="text/javascript">
					alert("User '.$_SESSION['user_email'].' already signed in!");
				</script>';
		} 
		else {
			//session expired => redirect to sign out
			redirect_with_status("signout.php", "expired");
		}
	}
	elseif(isset($_GET['status'])){
		//check what cause the redirect to the sign in
		switch ($_GET['status']){
			case "expired":
				//expired session
				echo '<script type="text/javascript">
					alert("Expired session, please sign in again!");
					</script>';
				break;
			default:
				//unexpected
				$signin_error = "Unexpected session status";
				break;
		}
	}
	
	
?>
<?php //manage the sign in form
	
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
			
			//with a succesful sign in set the session parameters
			$_SESSION['user_id'] = $found_user['user_id'];
			$_SESSION['user_email'] = $found_user['email'];
			$_SESSION['user_name'] = $found_user['name'];
			$_SESSION['timeout'] = time();
			
			disconnect_to_project_db($conn_id);
			
			//redirect to the home page
			redirect_with_status("home.php", "signed_in");
			exit;
		}
		catch (Exception $e) {
			$signin_error = $e->getMessage();
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
	<link rel="stylesheet" href="../../css/common_style.css">
	<link rel="stylesheet" href="../../css/signin_style.css">
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
		<h2>Sign In</h2>
		<div id="warning_div">
			<?php echo $signin_error?>
		</div>
		<fieldset>	
			<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" onsubmit="return validateSigninForm()"> 
				<table>
					<tr>
						<td>Email:</td>
						<td><input type="email" name="user_email" class="user_input" required="required"
							value="<?php echo $user_email;?>"></td>
						<td><p class="warning"></p></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="user_password" class="user_input" required="required"
							value="<?php echo $user_password;?>"></td>
						<td colspan="2"><p class="warning"></p></td>
					</tr>
				</table>
				<div id="buttons">
					<input id="submit" type="submit" value="Submit">
					<input id="clear" type="button" value="Clear" onclick="clearSigninForm()">
				</div>
			</form>
		</fieldset>
	</section>
	<footer>
		<?php include_once '../utility/footer.php';?>
	</footer>
</body>
</html>
