<?php include_once '../utility/project_defined_values.php';?>
<?php include_once '../utility/utilities.php';?>
<?php
	
	//if cookies are enabled redirect to the previous page
	if (isset($_COOKIE["cookie_enabled"])) {
		redirect_with_status($_COOKIE['prev_page']);
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Reservation System</title>
	<link rel="stylesheet" href="../../css/common_style.css">
</head>
<body>
	<div id="main-container">
		
		<div id="header">
			<h1>Reservation System</h1>
		</div>
		
		<div id="center-container">
			
			<div id="nav">
				<?php include_once '../utility/nav.php'?>
			</div>
			
			<div id="section">
				<?php test_js();?>
				<p class="warning">Cookies disabled, enable cookies to navigate this site!</p>
			</div>
			
		</div>
		
		<div id="footer">
			<?php include_once '../utility/footer.php'?>
		</div>
			
	</div>
	
</body>
</html>