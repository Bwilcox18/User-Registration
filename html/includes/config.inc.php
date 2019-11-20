<?php
define('LIVE', FALSE);
define('EMAIL', 'mrw321@gmail.com');

define('BASE_URL',
	'http://p00625551.dccc.tech/');
define('MYSQL',
	'mysqli_connect.php');
	
date_default_timezone_set('America/New_York');

	
function my_error_handler
	($e_number, $e_message, $e_file,
	$e_line, $e_vars) {
		
	$message = "An error occired in 
	script '$e_file' on line
	$e_line: $e_message\n";
	
	$message .="Date/Time: " . date('n-j-Y H:i:s') . "\n";
	
	if (!LIVE) { //Development (print the error).
		echo '<div class="error">' . nl2br($message);
		echo '<pre>' . print_r	
			($e_vars, 1) . "\n";
			debug_print_backtrace();
			echo'</pre></div>';
			
	} else { //Don't show the error
		$body = $message . "\n" .
		print_r ($e_vars, 1);
	mail(EMAIL, 'Site Error!', $body,
		'From: email@example.com');
		if ($e_number != E_NOTICE) {
			echo '<div class="error">
			A system error occured.
			We apologize for the inconvenience.</div><br>';
		}
	} //End of !LIVE if	
	}
set_error_handler('my_error_handler');