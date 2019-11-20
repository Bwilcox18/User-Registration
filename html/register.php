<?php # register.php
require ('includes/config.inc.php');
$page_title = 'Register';
include('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	require('mysqli_connect.php');
	
	$trimmed = array_map('trim', $_POST);
	
	$fn = $ln = $e = $p = FALSE;
	//FIRST NAME
	if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
		$fn = mysqli_real_escape_string($dbc, $trimmed['first_name']);
	} else {
		echo '<p class="error>Please enter your first name!</p>';
	}
	
	//LAST NAME
	if (preg_match('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
		$ln = mysqli_real_escape_string($dbc, $trimmed['last_name']);
	} else {
		echo '<p class="error">Please enter your last name!</p>';
	}
	
	//EMAIL
	if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
		$e = mysqli_real_escape_string($dbc, $trimmed['email']);
	} else {
		echo '<p class="error">Please enter a valid email address!</p>';
	}
	
	//PASSWORD
	if (strlen($trimmed['password1']) >= 10) {
		if ($trimmed['password1'] == $trimmed['password2']) {
			$p = password_hash($trimmed['password1'], PASSWORD_DEFAULT);
		}else{
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo'<p class="error">Please enter a valid password!</p>';
}

	if ($fn && $ln && $e && $p) {
		$q = "SELECT user_id FROM users WHERE email='$e'";
		$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br> MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_num_rows($r) == 0) {
			$a = md5(uniqid(rand(), true));
			$q = "INSERT INTO users (email, pass, first_name, last_name, active, registration_date)
					VALUES ('$e', '$p', '$fn', '$ln', '$a', NOW() )";
			$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MYSQL error: " . mysqli_error($dbc));
			
			if (mysqli_affected_rows($dbc) == 1) {
				$body = "Thank you for registering at Alien Database. 
						 To activate your account, please click on this link: \n\n";
				$body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";
				mail($trimmed['email'], 'Registration Confirmation', $body, 'From: admin@sitename.com');
				
				echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</h3>';
				include('includes/footer.html');
				exit();
				
		}else{
			echo '<p class="error">You could not be a registered due to a system error. We apologize for any inconvenience.</p>';
		}
		
	}else{
		echo '<p class="error">That email address has already been registered. If you have forgotten your password,
		use the link at right to have your password sent to you.</p>';
	}
}else{
	echo '<p class="error">Please try again.</p>';
}
mysqli_close($dbc);
} //END
?>

<h1>Register Here:</h1>
<form action="register.php" method="post">
	<fieldset>

	<p><strong>First Name:</strong> <input type="text" name="first_name" size="20" maxlength="20" value="<?php if (isset($trimmed['first_name'])) echo $trimmed['first_name']; ?>"></p>

	<p><strong>Last Name:</strong> <input type="text" name="last_name" size="20" maxlength="40" value="<?php if (isset($trimmed['last_name'])) echo $trimmed['last_name']; ?>"></p>

	<p><strong>Email Address:</strong> <input type="email" name="email" size="30" maxlength="60" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>"> </p>

	<p><strong>Password:</strong> <input type="password" name="password1" size="20" value="<?php if (isset($trimmed['password1'])) echo $trimmed['password1']; ?>"> <small>At least 10 characters long.</small></p>

	<p><strong>Confirm Password:</strong> <input type="password" name="password2" size="20" value="<?php if (isset($trimmed['password2'])) echo $trimmed['password2']; ?>"></p>
	</fieldset>

	<div align="center"><input type="submit" name="submit" value="Register"></div>

</form>

<?php include('includes/footer.html'); ?>			
		
			
		
			