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
	echo "<script>console.log('" . $username . "  is logged in.')</script>";
}
	require_once '../../../php/landfill.php';
	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	if ($connekt->connect_error) die($connekt->connect_error);

	// check if the form has been submitted. If it has, process the form and save it to the database
	if (isset($_POST['submit'])) {
		// confirm that the 'id' value is a valid integer before getting the form data
		if (is_numeric($_POST['caseID'])) {
			// get form data, making sure it is valid
			$caseID = $_POST['caseID'];
			$caseNum = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['caseNum']));
			$caseName = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['caseName']));
			$startDate = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['startDate']));
			$endDate = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['endDate']));
			$deliveryDate = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['deliveryDate']));
			$status = 1;
	
			if ($endDate !== ''){
				$status = 0;
			}
	
			// check that caseNum and startDate fields are both filled in
			if ($caseNum == '' || $startDate == '') {
				// generate error message
				$error = 'ERROR: Boy, you sure are stupid! Fill in all required fields like you were told!';
			}
			else {
				// save data to database
				$updateCase = "UPDATE cases4 SET caseNum='$caseNum', caseName='$caseName', startDate='$startDate', endDate='$endDate', deliveryDate='$deliveryDate', status='$status' WHERE caseID='$caseID'";
				$retval = $connekt->query($updateCase);
				// Feedback of whether INSERT worked or not
				if(!$retval){
					die('Crap. Could not update your case: ' . mysqli_error());
				}
				else {
					// after save, go to view page
					header("Location: cases.php");
				}
			}
		}
		else {
			// if the 'id' isn't valid, display an error 
			echo $error;
		}
	}
	else {
		// if the form hasn't been submitted, get the data from the db and display the form 
		// get 'id' value from URL (if it exists), confirming it is valid and is numeric/larger than 0)
		if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
			// query db
			$caseID = $_GET['id'];
			$result = mysqli_query($connekt, "SELECT * FROM cases4 WHERE caseID=$caseID")
			or die(mysqli_error($result));
			$row = mysqli_fetch_array($result);
			// check that the 'id' matches up with a row in the databse
			if($row) {
				// get data from db
				$caseID = $row['caseID'];
				$caseNum = $row['caseNum'];
				$caseName = $row['caseName'];
				$startDate = new DateTime($row["startDate"] ." UTC");
				$startDate ->setTimezone(new DateTimeZone('America/New_York')); 
				$endDate = $row['endDate'];
				$deliveryDate = $row['deliveryDate'];
			}
			else {
				// if no match, display result
				echo "No results!";
			}
		}
		else {
			// if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error 
			echo $error;
		}
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
    <title>Case Management</title>
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

<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title">Case: <?php echo $caseName; ?></h3></div>
		<div class="panel-body">
		<!-- Panel Content -->
		<?php 
			if ($jefe == 1) {
				include 'case_mgmt.php';
			}
		?>
		
<div class="well">
		
 <?php
	// PHP code in a more secure location
	include("../../../php/landfill.php");
	// Start creating an HTML table for Assigned Cases and create header row
    echo "<table class='table table-striped table-hover '><thead><tr><th>Assigned Investigators</th></tr></thead>";
	echo "<tbody>";
	//Uses PHP code to connect to database
	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	// Connection test and feedback
	if (!$connekt) {
		die('Rats! Could not connect: ' . mysqli_error());
	}
	$caseID = $_GET['id'];
	// Create variable for query
	$query0 = "
	SELECT a.caseID, a.username, b.username, b.forename, b.surname
		FROM assignments4 a
			INNER JOIN user_creds4 b
				ON a.username = b.username
					WHERE a.caseID = '$caseID'";
	// Use variable with MySQL command to grab info from database
	$result0 = $connekt->query($query0);
	// Create a row in HTML table for each row from database
    while ($row = mysqli_fetch_array($result0)) {
		echo "<tr><td>" . $row['forename'] . " " . $row['surname'] . "</td></tr>";
    }
	// Finish table of Assigned Cases
    echo "</tbody></table>";
	// When attempt is complete, connection closes
    mysqli_close($connekt);
?>

</div> <!-- /well -->

<?php
    // PHP code in a more secure location
    include("../../../php/landfill.php");
    //Uses PHP code to connect to database
	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    // Connection test and feedback
  if (!$connekt)
  {
    die('Rats! Could not connect: ' . mysqli_error());
  }
    $caseID = $_GET['id'];
	// Create variable for query
	$query = "
		SELECT a.caseID, a.observeID, a.observation, a.pix, a.observeTime, a.username, b.forename, b.surname, a.action 
			FROM observations4 a
				INNER JOIN user_creds4 b
					ON a.username = b.username
				INNER JOIN cases4 c
					ON a.caseID = c.caseID
						WHERE a.caseID = '$caseID' AND a.username = '$username'"; 				
    // Use variable with MySQL command to grab info from database
	$result = $connekt->query($query);
    // Start creating an HTML table and create header row
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr><th>Observation</th><th>Date</th></tr></thead><tbody>";
    // Create a row in HTML table for each row from database
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";

		$thisObserve = $row["observation"];
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

		</div> <!-- /panel-body -->
	</div> <!-- /panel -->
</div> <!-- /container -->
 <script src='//roxorsoxor.com/stakeout/mobrules.js'></script></body>
 </html>