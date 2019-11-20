<?php # - index.php

include('includes/config.inc.php');
$page_title = 'Welcome to this Site! ';

include('includes/header.html');

//Welcome the user
echo '<h1>Welcome';

if (isset($_SESSION['first_name'])) {
	echo ", {$_SESSION['first_name']}";
}
echo '!</h1>';
?>

<p>Spam spam spam spam spam spam
spam spam spam spam spam spam
spam spam spam spam spam spam
spam spam spam spam spam spam.</p>
<p>Spam spam spam spam spam spam
spam spam spam spam spam spam
spam spam spam spam spam spam
spam spam spam spam spam spam.</p>

<?php include('includes/footer.html'); ?>