<?php
session_start();
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
require_once 'navbar.php';
$user = new USER();

if(!$user->areTheyLoggedIn()) {
	$user->redirect('https://www.roxorsoxor.com/stakeout/login_form.php');
}
else {
	$jefe = $_SESSION['jefe'];
	if ($jefe == 1) {
		echo "<script>console.log('You are an admin.')</script>";
	}
	$username = $_SESSION['username'];
	echo "<script>console.log('" . $username . " is logged in.')</script>";
}

function truncomatic ($textytext, $endomatic, $linkylink) {
	$temp = substr ($textytext, 0, $endomatic);
	$lastThing = strrpos ($temp, " ");
	$temp = substr($temp, 0, $lastThing);
	$temp = preg_replace("/([^\w])$/", "", $temp);
	return "$temp$linkylink";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Observations</title>
	<?php echo $stylesAndSuch; ?>   
</head>
<body>
	<div class="container">
             
<nav class='navbar navbar-default'>	
	<div id='header' class='container-fluid'>		
		<h1 class="hide"><a href="index.php">Stakeout</a></h1>
		
<?php 
	if ($jefe == 1) {
		echo $navbarJefe;
	}
	else {
		echo $navbarGator;
	}
?>
	
	</div> <!-- /container-fluid -->   
</nav> <!-- /navbar -->	

            <!-- main -->
	<div class="panel panel-primary">
		<div class="panel-heading"><h3 class="panel-title">Observations</h3></div>
			<div class="panel-body">
				<!-- Panel Content -->
                <a href="//www.roxorsoxor.com/stakeout/insert_observe.php" class="btn btn-primary">Add Observation</a>
<?php
    // PHP code in a more secure location
    include("../../../php/landfill.php");
    //Uses PHP code to connect to database
	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    // Connection test and feedback
  if (!$connekt) {
    die('Rats! Could not connect: ' . mysqli_error());
  }
  else {
		// Create variable for query
		if ($jefe == 1) {
			// Admin sees all observations
			$query = "
					SELECT a.caseID, a.observeID, a.description, a.pix, a.observeTime, c.caseName, c.status, a.username, b.forename, b.surname, b.userStatus, a.action 
						FROM observations a
							INNER JOIN user_creds b
								ON a.username = b.username
							INNER JOIN cases c
								ON a.caseID = c.caseID
									WHERE b.userStatus = 'Y' AND c.status = 1
									 ORDER BY a.observeTime ASC";
			// Use variable with MySQL command to grab info from database
			$result = $connekt->query($query);								 
		}
		else {
			// Gators only see their observations
			$query = "
					SELECT a.caseID, a.observeID, a.description, a.pix, a.observeTime, c.caseName, c.status, a.username, b.forename, b.surname, b.userStatus, a.action 
						FROM observations a
							INNER JOIN user_creds b
								ON a.username = b.username
							INNER JOIN cases c
								ON a.caseID = c.caseID
									WHERE a.username = '$username' AND c.status = 1
									 ORDER BY a.observeTime ASC";		
			// Use variable with MySQL command to grab info from database
			$result = $connekt->query($query);								 
		}
  }

    // Start creating an HTML table and create header row
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr><th>Case</th><th>Investigator</th><th>Description</th><th>Date</th></tr></thead><tbody>";
    // Create a row in HTML table for each row from database
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
		echo "<td>" . $row["caseName"] . "</td>";
		echo "<td>" . $row['surname'] . "</td>";
		
		$thisObserve = $row["description"];
		$observeLength = strlen($thisObserve);
		if ($oserveLength > 30) {
			$observeX = truncomatic($thisObserve, 30, " ...");
		}
		else {
			$observeX = $thisObserve;
		}
		
        echo "<td><a href='manage_observe.php?id=" . $row['observeID'] . "'>" . $observeX . "</a></td>";
		
		$ourTime = new DateTime($row["observeTime"] ." UTC");
		$ourTime ->setTimezone(new DateTimeZone('America/New_York'));
        echo "<td>" . $formatted_date_long=date_format($ourTime, 'm-d-y') . "</td>";
		
        echo "</tr>";
    }
	
    // Finish creating HTML table
    echo "</tbody></table>";
    // When attempt is complete, connection closes
    mysqli_close($connekt);
?>
			</div>
		</div>
	</div> <!-- /container -->
<script src='//roxorsoxor.com/stakeout/mobrules.js'></script></body>
</html>