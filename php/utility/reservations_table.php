<?php
include_once "db_functions.php";

try{
	//retrieve reservations for the all the users
	$conn_id = connect_to_project_db();

	$reservations = retrieve_reservations($conn_id);

	if(mysqli_num_rows($reservations) > 0){
		//put in the table the reservations
		$reservation_number = 0;
		while($reservation = mysqli_fetch_assoc($reservations)) {
			echo '<tr>';
			echo '<td>';
			echo $reservation['res_id'];
			echo '</td>';
			//compute start_time_h and start_time_m
			$start_time_h = floor($reservation['start_time'] / 60);
			$start_time_m = $reservation['start_time'] % 60;
			echo '<td>';
			printf("%02d:%02d", $start_time_h, $start_time_m);
			echo '</td>';
			echo '<td>';
			echo $reservation['duration_time'];
			echo '</td>';
			echo '<td>';
			echo $reservation['selected_machine'];
			echo '</td>';
			echo '<td>';
			echo $reservation['email'];
			echo '</td>';
			echo '</tr>';
			$reservation_number++;
		}
		$table_status = '<span class="success">Nr. active reservations: '.$reservation_number.'</span>';
	}
	else {
		//no reservations available
		$table_status = '<span class="warning">No registered reservations</span>';
	}
}
catch (Exception $e) {
	echo $table_status = '<span class="warning">Error occured downloading reservations</span>';
}

?>