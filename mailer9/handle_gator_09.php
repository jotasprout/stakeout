<?php
// PHP code in a more secure location
  require_once '../../../php/landfill.php';
  $connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
  if ($connekt->connect_error) die($connekt->connect_error);
  $salt1    = "qm&h*";
  $salt2    = "pg!@";
	// Assigns form field content to columns in database
	$forename = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['forename']));
	$surname = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['surname']));
	$username = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['username']));
	$password = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['password']));
	$pw_hashness = hash('ripemd128', "$salt1$password$salt2");
	$email = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['email']));
	// Instructions for inserting form content into database
  $pushGator = "INSERT INTO user_creds4 (
  	forename,
	surname,
	username,
	password,
	email
	)
  VALUES (
  	'$forename',
	'$surname',
	'$username',
	'$pw_hashness',
	'$email'
	);";
// Feedback of whether INSERT worked or not
	$retval = $connekt->query($pushGator);
  if(!$retval){
	  die('Nuts. Could not add an investigator: ' . mysqli_error());
  }
	header("location:gators5.php");
	// When attempt is complete, connection closes
	mysqli_close($connekt);
?>
