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
<style>
#map {
	width: 600px;
	height: 400px;
}
</style>
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
		<div class="panel-heading"><h4>Observation #<?php echo $observeID; ?></h4></div>
			<div class="panel-body">
				<!-- Panel Content -->
                
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
				SELECT a.caseID, a.observeID, a.action, a.observation, a.pix, a.observePic, a.observeTime, a.lng, a.lat, c.caseName, a.username, b.forename, b.surname, a.action 
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
	 			// if there's a match, display data from db
				echo "<table class='table'><tbody>";
				echo "<tr></tr>";
				// Create a row in HTML table for each row from database
				echo "<tr><th>Case Name: </th><td>" . $row["caseName"] . "</td></tr>";
				echo "<tr><th>Image Uploaded Filename: </th><td>" . $row["observePic"] . "</td></tr>";
				echo "<tr><th>Image Uploaded: </th><td><a href='observe_pix/" . $row["observePic"] . "'><img src='observe_pix/" . $row["observePic"] . "' width='200px' height='auto'></a></td></tr>";
				echo "<tr><th>Action: </th><td>" . $row["action"] . "</td></tr>";
				echo "<tr><th>Investigator: </th><td>" . $row['forename'] . " " . $row['surname'] . "</td></tr>";
				echo "<tr><th>Observation: </th><td>" . $row["observation"] . "</td></tr>";
				if ($row["pix"] == 1) {
					$available = "Yes";
				}
				else {
					$available = "No";
				}
				echo "<tr><th>Photos Available: </th><td>" . $available . "</td></tr>";
				echo "<tr><th>Date &amp; Time: </th><td>" . $row["observeTime"] . "</td></tr>";
				echo "<tr><th>Longitude: </th><td>" . $row["lng"] . "</td></tr>";
				echo "<tr><th>Latitude: </th><td>" . $row["lat"] . "</td></tr>";
				echo "<tr><th>Map: </th><td><div id='map'></div></td></tr>";
				echo "</tbody></table>";
			}
			else // if no match, display error
			{
				echo "<script>console.log('No results.')</script>";
			}
		}

?>
			</div>
		</div>
	</div> <!-- /container -->

    
    <!-- google map -->
<?php
   echo "<script>
      function initMap() {
		var myLatLng = {lat: " . $row["lat"] . ", lng: " . $row["lng"] . "};  
        var mapDiv = document.getElementById('map');
        var map = new google.maps.Map(mapDiv), {
          center: myLatLng,
          zoom: 17
        });
		var marker = new google.maps.Marker({
			map: map,
			position: myLatLng,
			title: 'Where I was'
		});
      }
    </script>
    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyA2-DtyAjZ0X3w5989NXEnKBlU4tmJfKeA&callback=initMap' async defer></script>";
	
	// When attempt is complete, connection closes
    mysqli_close($connekt);
?>
<!-- /google map -->

</body>
</html>