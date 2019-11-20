<?php #FINAL PROJ logout.php
require('includes/config.inc.php');
$page_title = 'Logout';
include('includes/header.html');

if (!isset($_SESSION['first_name'])) {
	$url = BASE_URL . 'index.php';
	ob_end_clean();
	header("Location: $url");
	exit();
	
}else{
	$_SESSION = [];
	session_destroy();
	setcookie (session_name(),'', time()-3600);
}

echo '<h3>You are now logged out.</h3>';
include('includes/footer.html');
?>