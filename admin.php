<?php
	session_start();
	//kung may sess id at kung admin siya 
	if (!isset(($_SESSION['user_level'])) or ($_SESSION['user_level'] != 1)){
		header("Location: login.php");
		exit();
	}
?>
<!doctype html!>
	<html lang="en">
	<head>
		<title>Dy</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="includes.css">
	</head>
	<body>
		<div id="container">
		<?php include('nav-admin.php');?>
			<div id='content'>
				<h2>Homepage</h2>
				<p>whats up.</p>
				<img id = "shane" src = "picc.png">
			</div>
			<?php include('info-col.php');?>
			
		</div>
		<?php include('footer.php'); ?>
	</body>
	</html>