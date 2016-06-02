<?php
include_once "db_functions.php";

try{
	//retrieve reservations for the all the users
	$conn_id = connect_to_project_db();

	$reservations = retrieve_reservations($conn_id);

	if(mysqli_num_rows($reservations) > 0){
		//put in the table the reservations
		while($reservation = mysqli_fetch_assoc($reservations)) {
			echo '<tr>';
			echo '<td>';
			echo $reservation['res_id'];
			echo '</td>';
			echo '<td>';
			printf("%02d:%02d", $reservation['start_time_h'], $reservation['start_time_m']);
			echo '</td>';
			echo '<td>';
			echo $reservation['duration_time'];
			echo '</td>';
			echo '<td>';
			echo $reservation['machine_number'];
			echo '</td>';
			echo '</tr>';
		}
	}
	else {
		//no reservations available for the actual user_id
		echo '<tr><td> no reservations available </td></tr>';
	}
}
catch (Exception $e) {
	echo '<tr><td> problem retrieving reservations:'.$e->getMessage().'</td></tr>';
}

?>