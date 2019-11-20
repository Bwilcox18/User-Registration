<?php

define('DB_USER', 'p00625551');
define('DB_PASSWORD', 'esindnus581');
define('DB_HOST', 'localhost');
define('DB_NAME', 'P00625551');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$dbc) {
	trigger_error('Could not connect to MySQL: ' . mysqli_connection_error() );
} else {
	mysqli_set_charset($dbc, 'utf8');
	echo "CONNECTED";
}
