<?php
	
	// THIS IS ALL OLD STUFF FOR REFERENCE
	// DO NOT COPY THIS
	// THIS GETS THE ASSIGNMENTS, GIVES APPROPRIATE CHECKBOXES
	require_once '../../../php/landfill.php';
	$username = $_SESSION['username'];
  	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);

	if ($connekt->connect_error) die($connekt->connect_error);

	// Create variable for query
    $query0 = "SELECT * FROM assignments WHERE username = '$username'";

	// Use variable with MySQL command to grab info from database
	$result0 = $connekt->query($query0);	

	// put current user's cases into array
	while ($row0 = mysqli_fetch_array($result0)){
		$userAssignments[] = $row0['caseNum'];
	}

	$query = "SELECT * FROM cases WHERE status = 1";

	// Use variable with MySQL command to grab info from database
	$result = $connekt->query($query);

	// Start creating an HTML table and create header row
    echo "<div class='col-lg-10'>";

 	// Create a row in HTML table for each row from database
    while ($row = mysqli_fetch_array($result)) {
		if (in_array($row['caseNum'],$userAssignments)){
			echo "<div class='col-lg-10'><div class='checkbox'>";
			echo "<label><input type='checkbox' value='" . $row["caseNum"] . " checked'> " . $row["caseName"] . " </label>";
			echo "</div></div>";			
		}
		else {
        echo "<div class='col-lg-10'><div class='checkbox'>";
		echo "<label><input type='checkbox' value='" . $row["caseNum"] . "'> " . $row["caseName"] . " </label>";
		echo "</div></div>";
		}

    }

	// Finish column and form group
    echo "</div></div>";
	
	// HERE IS THE NEW CHECKBOX STUFF
	// THIS IS FOR COPYING INTO MANAGE_GATOR4
	// HERE IS METHOD #1

	// check if the form has been submitted. If it has, process these assignment updates
	if (isset($_POST['submit'])){
		$checkbox = $_POST['checkbox'];
		$count = count($checkbox);
		
		// loop through each case's checkbox
		
		for($i=0; $i<$count; $i++) {
			// assign the checkbox value(?) -- which I think is caseNum -- to a variable called caseNum
			$caseNum = mysqli_real_escape_string($connekt,$checkbox[$i]);			
			// is it empty?
			if(empty($checkbox[$i])){
				// check to see if a row exists with this caseNum and this user
				$query3 = "SELECT * FROM assignments WHERE caseNum = '$caseNum' AND username = '$username'";
				$result3 = $connekt->query($query3);
				if(mysqli_num_rows($result3) > 0){
					// delete the row with that caseNum and user
					mysqli_query($connekt,"DELETE FROM assignments WHERE caseNum = '$caseNum' AND username = '$username'");
				}
			else { // if box is checked
				// check to see if a row exists with this caseNum and this user
				$query4 = "SELECT * FROM assignments WHERE caseNum = '$caseNum' AND username = '$username'";
				$result4 = $connekt->query($query4);
				if(mysqli_num_rows($result4) == 0){
					// insert a row with that caseNum and user
					// mysqli_query($connekt,"INSERT INTO assignments WHERE caseNum = '$caseNum' AND username = '$username'");	
					
					// Try above if below doesn't work
					// Instructions for inserting assignments

					  $pushAssignment = "INSERT INTO assignments (

						username,
						caseNum

						)

					  VALUES (

						'$username',
						'$caseNum'

						);";

					// Feedback of whether INSERT worked or not

						$retval2 = $connekt->query($pushAssignment);

					  if(!$retval2){

						  die('Darn. Could not add or update those assignments: ' . mysqli_error());

					  }					
				
			} // end of IF
		} // end of FOR
	} // end of ISSET

	// HERE IS METHOD #2
	// if I need it

?>