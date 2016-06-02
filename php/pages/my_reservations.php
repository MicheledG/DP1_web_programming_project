<!DOCTYPE html>
<html>
<head>
	<title>Reservatation System</title>
	<?php 
		include_once '../utility/db_functions.php';
		//check if it is a post request to add a new user inside the database
		if ($_SERVER['REQUEST_METHOD']=='POST'){
		
			try {
				//collect selected reservations to delete (if there is at least one selected reservation)
				if(!isset($_POST['selected_reservation'])) {
					throw new Exception("exception: not selected reservations to remove");
				}
				$selected_reservations = $_POST['selected_reservation'];
					
				//connect and delete all selected reservations then close connection
				$conn_id = connect_to_project_db();
				
				foreach ($selected_reservations as $selected_reservation) {
					delete_reservation($conn_id, $selected_reservation);
				}
					
				disconnect_to_project_db($conn_id);
			}
			catch (Exception $e) {
				echo '<span class="warning">'. $e->getMessage() . '</span>';
			}
		}
	?>
</head>
<body>
	<header>
	<h1>Reservation System</h1>
	<h2>My Reservations</h2>
	</header>
	<nav>
	<?php include_once '../utility/nav.php'?>
	</nav>
	<section>
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
			<table>
			<thead>
				<tr>
					<td>Selected</td>
					<td>Reservation IDs</td>
					<td>Starting Times</td>
					<td>Duration Times</td>
					<td>Machine Numbers</td>
				</tr>
			</thead>
			<tbody>
				<?php include_once "../utility/my_reservations_table.php"?>
			</tbody>
			</table>
			<a href="reservation_system.php"><input type="button" value="Add" ></a>
			<input type="submit" value="Remove">
			<?php echo $remove_operation_result;?>
		</form>
	</section>
	<footer>
		<?php include_once '../utility/footer.php';?>
	</footer>
</body>
</html>