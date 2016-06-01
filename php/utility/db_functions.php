<?php
include "utilities.php";
function connect_to_project_db(){
	$servername = "localhost";
	$user = "xampp_server";
	$password = "password";
	$dbname = "web_project";
	
	//create connection
	$conn_id = mysqli_connect($servername, $user, $password, $dbname);
	
	//check connection
	if (!$conn_id) {
		throw new Exception("exception: " . mysqli_connect_error());
	}
	else {
		return $conn_id;	
	}
}

function disconnect_to_project_db($conn_id) {
	$res = mysqli_close($conn_id);
	
	if(!$res){
		throw new Exception("exception: impossible to close connection to the db");
	}
}

function insert_new_user($conn_id, $user_name, $user_lastname, $user_email, $user_password) {
	
	$user_name = sanitize_user_input($user_name, $conn_id);
	$user_lastname = sanitize_user_input($user_lastname, $conn_id);
	$user_email = sanitize_user_input($user_email, $conn_id);
	$user_password = sanitize_user_input($user_password, $conn_id);
	
	$sql_query = "INSERT INTO users (user_id, email, password, name, lastname)
			VALUES ('','".$user_email."','".md5($user_password)."','"
					.$user_name."','".$user_lastname."')";
	
	$res = mysqli_query($conn_id, $sql_query);
	
	if (!$res) {
		throw new Exception("exception: ".mysqli_error($conn_id));
	}
}
?>