<?php
require ('includes/config.inc.php');
$page_title = 'Register';
include ('includes/header.html');

if (isset($_GET['x'], $_GET['y'])
	&& filter_var($_GET['x'], FILTER_VALIDATE_EMAIL)
	&& (strlen($_GET['y']) == 32 ) )
	{
	
	require(MYSQL);
	
	$q = "UPDATE users SET active=NULL WHERE 
	(email='" . mysqli_real_escape_string($dbc, $_GET['x']) . "' 
	AND active='" . mysqli_real_escape_string($dbc, $_GET['y']) . "') LIMIT 1";
	
	$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br> MySQL Error: " . mysqli_error($dbc));
	
	if (mysqli_affected_rows($dbc) == 1) {
		echo "<h3>Your account is now active. You may now log in.</h3>";
	}else{
		echo '<p class="error">Your account could not be activated. Please contact your administrator for help.</p>';
	}
	mysqli_close($dbc);
	}else{
		$url = BASE_URL . 'index.php';
		ob_end_clean();
		header("Location: $url");
		exit();
	}
	include('includes/footer.html');
	?>
	