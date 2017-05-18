<?php
session_start();
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
require_once 'navbar.php';
$user = new USER();

if(!$user->areTheyLoggedIn()) {
	$user->redirect('login_form_09.php');
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
	if (isset($_POST['submit']))
	{
	// confirm that the 'id' value is a valid integer before getting the form data
	if (is_numeric($_POST['caseID']))
		{
		// get form data, making sure it is valid
		$caseID = $_POST['caseID'];
		$caseNum = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['caseNum']));
		$caseName = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['caseName']));
		$startDate = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['startDate']));
		$endDate = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['endDate']));
		$deliveryDate = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['deliveryDate']));
		// check that caseNum and startDate fields are both filled in
		if ($caseNum == '' || $startDate == '')
			{
			// generate error message
			$error = 'ERROR: Boy, you sure are stupid! Fill in all required fields like you were told!';
			}
		else
			{
				// save data to database
				$updateCase = "UPDATE cases4 SET caseNum='$caseNum', caseName='$caseName', startDate='$startDate', endDate='$endDate', deliveryDate='$deliveryDate' WHERE caseID='$caseID'";
				$retval = $connekt->query($updateCase);
				// Feedback of whether INSERT worked or not
				if(!$retval){
					die('Crap. Could not update your case: ' . mysqli_error());
				}
				else
				{
				// after save, go to view page
				header("Location: cases_09.php");
				}
			}
		}
		else // if the 'id' isn't valid, display an error
		{
		echo $error;
		}
	}
	else // if the form hasn't been submitted, get the data from the db and display the form
	{
		// get 'id' value from URL (if it exists), confirming it is valid and is numeric/larger than 0)
		if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
		{
			// query db
			$caseID = $_GET['id'];
			$result = mysqli_query($connekt, "SELECT * FROM cases4 WHERE caseID=$caseID")
			or die(mysqli_error($result));
			$row = mysqli_fetch_array($result);
			// check that the 'id' matches up with a row in the databse
			if($row)
				{
				// get data from db
				$caseID = $row['caseID'];
				$caseNum = $row['caseNum'];
				$caseName = $row['caseName'];
				$startDate = $row['startDate'];
				$endDate = $row['endDate'];
				$deliveryDate = $row['deliveryDate'];
				}
			else // if no match, display result
				{
					echo "No results!";
				}
		}
		else // if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
		{
			echo $error;
		}
	}
?>

<!DOCTYPE html>
<html>
<head><meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
    <title>Case Management</title>
<?php echo $stylesAndSuch; ?>   
</head>
<body>
	<div class="container">
             
<?php 
	if ($jefe == 1) {
		echo $navbarJefe;
	}
	else {
		echo $navbarGator;
	}
?>

		<p>*Required</p>
        <form class="form-horizontal" action="" method="post">
        	<input type="hidden" name="caseID" value="<?php echo $caseID; ?>"/>
            <fieldset>
            	<legend>Case Management</legend>
                <div class="form-group"> <!-- Row 1 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="caseNum">Case Number*</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="caseNum" value="<?php echo $caseNum; ?>"/>
                    </div>
                </div><!-- /Row 1 -->
                <div class="form-group"> <!-- Row 2 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="caseName">Case Name*</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="caseName" value="<?php echo $caseName; ?>" />
                    </div>
                </div><!-- /Row 2 -->
                <div class="form-group"> <!-- Row 3 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="startDate">Start Date*</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="startDate" value="<?php echo $startDate; ?>" />
                    </div>
                </div><!-- /Row 3 -->
                <div class="form-group"> <!-- Row 4 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="endDate">End Date</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="endDate" value="<?php echo $endDate; ?>" />
                    </div>
                </div><!-- /Row 4 -->
                <div class="form-group"> <!-- Row 5 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="deliveryDate">Delivery Date</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="deliveryDate" value="<?php echo $deliveryDate; ?>" />
                    </div>
                </div><!-- /Row 5 -->
                <div class="form-group"> <!-- Last Row -->
                    <div class="col-lg-4 col-lg-offset-2">
                        <button class="btn btn-primary" type="submit" name="submit">Update Case</button>
                    </div>
                </div><!-- /Last Row -->
            </fieldset>
        </form>
 <?php
	// Should this only appear for Admin?
	// Should this instead list observations for gators?
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
 	</div> <!-- /container -->
 </body>
 </html>