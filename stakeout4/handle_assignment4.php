<?php

	// PHP code in a more secure location
	require_once '../../../php/landfill.php';

	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);

	if ($connekt->connect_error) die($connekt->connect_error);

	// Assigns form field content to columns in database
	$assignedCase = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['assignedCase']));
	$assignedGator = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['assignedGator']));

	// Check to see if assignment already exists
	$query4 = "SELECT * FROM assignments4 WHERE caseNum = '$assignedCase' AND username = '$assignedGator'";
	$result4 = $connekt->query($query4);

	if(mysqli_num_rows($result4) == 0){

		// if assignment doesn't exist, insert a row with that caseNum and user

		$pushAssignment = "
		INSERT INTO assignments (
		caseNum,
		username
		)

		VALUES (
		'$assignedCase',
		'$assignedGator'
		);";

		$retval = $connekt->query($pushAssignment);

		// Feedback of whether INSERT worked or not
		if(!$retval){
			die('Crap. Could not assign the investigator to the case: ' . mysqli_error());
		}

		else {
			header("location:assignments4.php");
		}

		// When attempt is complete, connection closes
		mysqli_close($connekt);		

	} // end of IF

?>