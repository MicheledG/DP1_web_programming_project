<?php
 function sanitize_user_input($user_input, $conn_id = null){
 	$user_input = trim(strip_tags($user_input));
 	if($conn_id != null){
 		$user_input = mysqli_real_escape_string($conn_id, $user_input);
 	}
 	return $user_input;
 }
 
 function validate_name($str_name){
 	if(strcmp('', $str_name) == 0) {
 		throw new Exception("exception: empty name/lastname");
 	}
 	//check if there are only letters and spaces
 	elseif (!preg_match("/^[a-zA-Z ]+$/",$str_name)) {
 		throw new Exception("exception: only letters and white space allowed in name/lastname");
 	}
 	
 	return $str_name;
 }
 
 function validate_email($str_email){
 	if(strcmp('', $str_email) == 0) {
 		throw new Exception("exception: empty email");
 	}
 	elseif (!filter_var($str_email, FILTER_VALIDATE_EMAIL)) {
 		echo $str_email;
 		throw new Exception("exception: invalid email format");
 	}
 	
 	return $str_email;
 }
 
 function validate_password($str_password){
 	if(strcmp('', $str_password) == 0) {
 		throw new Exception("exception: empty password");
 	}
 	//check if there are only letters and numbers
 	elseif (!preg_match("/^[a-zA-Z0-9]+$/",$str_password)) {
 		throw new Exception("exception: only letters and numbers allowed in password");
 	}
 	
 	return $str_password;
 }
 
 ?>