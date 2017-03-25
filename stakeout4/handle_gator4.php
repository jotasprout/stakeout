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
	$token = hash('ripemd128', "$salt1$password$salt2");

// Instructions for inserting form content into database

  $pushGator = "INSERT INTO user_creds (

  	forename,
	surname,
	username,
	password

	)

  VALUES (

  	'$forename',
	'$surname',
	'$username',
	'$token'

	);";

// mysqli_query($pushGator);
// I can remove line 44, yes?

// Feedback of whether INSERT worked or not
// $retval = mysqli_query($pushGator, $connekt);
// trying line 51 instead of line 48

	$retval = $connekt->query($pushGator);

  if(!$retval){

	  die('Nuts. Could not add an investigator: ' . mysqli_error());

  }

	echo "<h2>You've added an investigator and their name should appear here with maybe a log in link.</h2>";

	echo "<p>Assign this investigator or <a href=\"http://www.roxorsoxor.com/stakeout4/insert_gator4.php\">add another investigator</a>.</p>";

// When attempt is complete, connection closes

  mysqli_close($connekt);

?>