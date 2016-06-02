<!DOCTYPE html>
<html>
<head>
	<title>Reservatation System</title>
</head>
<body>
	<header>
	<h1>Reservation System</h1>
	<h2>My Reservations</h2>
	</header>
	<nav>
	<?php include '../utility/nav.php'?>
	</nav>
	<section>
		<form>
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
				<?php include "../utility/my_reservations_table.php"?>
			</tbody>
			</table>
			<a href="reservation_system.php"><input type="button" value="Add" ></a>
			<input type="submit" value="Remove">
		</form>
	</section>
	<footer>
		<?php include '../utility/footer.php';?>
	</footer>
</body>
</html>