<?php
session_start();
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
if(!isset($_SESSION['username'])) {
	echo "<script>console.log('Nobody is logged in.')</script>";
	header("Location:login_form_09.php");
}
else {
	// $_SESSION['username'] = $userRow['username'];
	$username = $_SESSION['username'];
	echo "<script>console.log('" . $username . " is logged in.')</script>";
}
?>
<!DOCTYPE html>
<html>
<head><meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
    <title>Manage Observation</title>
<?php echo $stylesAndSuch; ?>   
</head>
<body>
	<div class="container">
             
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="//www.roxorsoxor.com/mailer9/index_09.php">You</a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    	<ul class="nav navbar-nav">
                            <li><a href="//www.roxorsoxor.com/mailer9/cases_09.php">Cases</a></li>
					<li><a href="//www.roxorsoxor.com/mailer9/observations_09.php">Observations</a></li>
					<li><a href="//www.roxorsoxor.com/mailer9/gators_09.php">Investigators</a></li>
					<li><a href="//www.roxorsoxor.com/mailer9/assignments_09.php">Assignments</a></li></ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="logout_09.php">Logout</a></li>
                        </ul>
                    </div> <!-- /collapse -->                    
                </div> <!-- /container-fluid -->   
            </nav> <!-- /navbar -->
            <!-- main -->
	<div class="panel panel-default">
		<div class="panel-heading"><h4>Observations</h4></div>
			<div class="panel-body">
				<!-- Panel Content -->
                <a href="//www.roxorsoxor.com/mailer9/insert_observe_09.php" class="btn btn-primary">Add Observation</a>
<?php
    // PHP code in a more secure location
    include("../../../php/landfill.php");
    //Uses PHP code to connect to database
	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    // Connection test and feedback
	
	
	// COPIED FROM ELSEWHERE
// confirm id is valid and is numeric/larger than 0)
		if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0){
			// query db
			$id = $_GET['id'];
			
			// Create variable for query
			$query = "
				SELECT a.caseID, a.observeID, a.observation, a.pix, a.observeTime, c.caseName, a.username, b.forename, b.surname, a.action 
					FROM observations4 a
						INNER JOIN user_creds4 b
							ON a.username = b.username
						INNER JOIN cases4 c
							ON a.caseID = c.caseID
								WHERE a.observeID = '$id'"; 				
			// Use variable with MySQL command to grab info from database
			$result = $connekt->query($query)
			or die(mysqli_error($result));
			$row = mysqli_fetch_array($result);
			// check that the 'id' matches up with a row in the databse
			if($row){
	 			// if there's a match
				// get data from db
				$observeID = $row['observeID'];
				$date = $row['observeTime'];
				$caseName = $row['caseName'];
				$forename = $row['forename'];
				$surname = $row['surname'];
				$observation = $row['observation'];
				$lng = $row['lng'];
				$lat = $row['lat'];
				$observePic = $row['observePic'];
				$pix = $row['pix'];
				
			}
			else // if no match, display error
			{
				echo "<script>console.log('No results.')</script>";
			}
		}

	// END OF COPIED


    // Start creating an HTML table and create header row
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr><th>Case Name</th><th>View</th><th>Action</th><th>User</th><th>Observation</th><th>Photos</th><th>Time Stamp</th></tr></thead><tbody>";
    // Create a row in HTML table for each row from database
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
		echo "<td>" . $row["caseName"] . "</td>";
		echo "<td>View</td>";
		echo "<td>" . $row["action"] . "</td>";
		echo "<td>" . $row['forename'] . " " . $row['surname'] . "</td>";
        echo "<td>" . $row["observation"] . "</td>";
		echo "<td>" . $row["pix"] . "</td>";
        echo "<td>" . $row["observeTime"] . "</td>";
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
</body>
</html>