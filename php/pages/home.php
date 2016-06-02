<!DOCTYPE html>
<html>
<head>
	<title>Reservatation System</title>
</head>
<body>
	<header>
		<h1>Reservation System</h1>
		<h2>Home</h2>
	</header>
	<nav>
		<?php include '../utility/nav.php'?>
	</nav>
	<section>
		<table>
			<thead>
				<tr>
					<td>Reservation IDs</td>
					<td>Starting Times</td>
					<td>Duration Times</td>
					<td>Selected Machines</td>
				</tr>
			</thead>
			<tbody>
				<?php include "../utility/reservations_table.php"?>
			</tbody>
		</table>
	</section>
	<footer>
		<?php include '../utility/footer.php'?>
	</footer>
</body>
</html>