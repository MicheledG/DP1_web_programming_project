<?php
include_once "utilities.php";
function connect_to_project_db(){
	//create connection
	$conn_id = mysqli_connect(SERVER_NAME, SERVER_USER, SERVER_PASSWORD, SERVER_DB_NAME);
	
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
	
	$sql_query = "INSERT INTO USERS (user_id, email, password, name, lastname)
			VALUES ('','".$user_email."','".md5($user_password)."','"
					.$user_name."','".$user_lastname."')";
	
	$res = mysqli_query($conn_id, $sql_query);
	
	if (!$res) {
		throw new Exception("exception: ".mysqli_error($conn_id));
	}
}

function retrieve_reservations($conn_id, $user_id = null){
		
	$sql_query = "SELECT res_id, start_time, duration_time, selected_machine
			FROM RESERVATIONS";
	
	//if a user_id is specified retrieve reservations only for that specified user
	if($user_id != null) {
		$sql_query .= "\rWHERE user_id =".$user_id;
	}
	
	$sql_query .= "\rORDER BY start_time ASC";
			
	$res = mysqli_query($conn_id, $sql_query);
	
	$res_type = gettype($res);
	
	switch ($res_type) {
		case "boolean": //only false is the possible value
			throw new Exception("exception: ".mysqli_error($conn_id));
		case "object": //it a mysqli_object with the resulting rows
			return $res;
			break;
		default:
			throw new Exception("exception: unexpected query result");
	}	
}

function delete_reservation($conn_id, $res_id){
	
	$sql_query = "DELETE FROM RESERVATIONS
			WHERE res_id = ".$res_id;
	
	$res = mysqli_query($conn_id, $sql_query);
	
	if (!$res) {
		throw new Exception("exception: ".mysqli_error($conn_id));
	}
	
}

function check_machine_availability($conn_id, $start_time_h, $start_time_m, $duration_time) {
	
	$available_machine = FIRST_PRINTER;
	
	//on the db the start_time is represented in minute
	$start_time = $start_time_h * HOUR_MIN + $start_time_m;
	
	//select all the existing reservation with overlapping time periods
	$sql_query = "SELECT selected_machine
			FROM RESERVATIONS
			WHERE ".$start_time." <= start_time AND ".($start_time + $duration_time)." >= start_time OR 
					".$start_time.">= start_time AND ".$start_time." <= start_time + duration_time
			GROUP BY selected_machine";
	
	$res = mysqli_query($conn_id, $sql_query);
	
	//check the query result
	if(mysqli_num_rows($res) > 0){
		//there are overlapping reservations
		while($selected_machine = mysqli_fetch_assoc($res)){
			if ($selected_machine['selected_machine'] == $available_machine) {
				//that machine is not available
				$available_machine++;
			} 
			else {
				//that machine is available
				break;
			}
		}
		
		if($available_machine > AVAILABLE_PRINTERS) {
			throw new Exception("exception: no available machine to add the reservation");
		}
	}
	else {
		//no overlapping reservations
		//first machine is availble
		$available_machine = FIRST_PRINTER;
	}
	
	return $available_machine;
}

function insert_new_reservation($conn_id, $user_id, $start_time_h, $start_time_m, $duration_time, $selected_machine) {
	
	//on the db the start_time is represented in minute
	$start_time = $start_time_h * HOUR_MIN + $start_time_m;
	
	$sql_query = "INSERT INTO RESERVATIONS(res_id, user_id, start_time, duration_time, selected_machine)
			VALUES('','".$user_id."','".$start_time."','".$duration_time."','".$selected_machine."')";
	
	$res = mysqli_query($conn_id, $sql_query);
	
	if (!$res) {
		throw new Exception("exception: ".mysqli_error($conn_id));
	}
}

function search_user($conn_id, $user_email, $user_password){
	
	$user_password = md5($user_password);
	
	//select the user with the specified credentials
	$sql_query = "SELECT user_id, name
			FROM USERS
			WHERE email = '".$user_email."' AND password = '".$user_password."'";
	
	$res = mysqli_query($conn_id, $sql_query);
	
	$res_type = gettype($res);
	
	switch ($res_type) {
		case "object": //it a mysqli_object 
			// check if there is one row
			if(mysqli_num_rows($res) == 1){
				$found_user = mysqli_fetch_assoc($res);
				return $found_user;
			} else {
				throw new Exception("exception: wrong email or password");
			}
			break;
		case "boolean": //only false is the possible value
		default:
			throw new Exception("exception: unexpected query result");
	}
	
}


?>