<?php
session_start();
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
require_once 'navbar.php';
$user = new USER();

if(!$user->areTheyLoggedIn()) {
	$user->redirect('https://www.roxorsoxor.com/stakeout/login_form_09.php');
}
else {
	$jefe = $_SESSION['jefe'];
	if ($jefe == 1) {
		echo "<script>console.log('You are an admin.')</script>";
	}
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
	width: 300px;
	height: 300px;
}
</style>
</head>
<body onload="initMap()">
	<div class="container">
	<nav class='navbar navbar-default'>	
		<div id='header' class='container-fluid'>
			<h1 class="hide"><a href="index_09.php">Stakeout</a></h1>
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
		<div class="panel-heading"><h3 class="panel-title">Manage Observation</h3></div>
			<div class="panel-body">
				<!-- Panel Content -->
                
<?php
    // PHP code in a more secure location
    include("../../../php/landfill.php");
    //Uses PHP code to connect to database
	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    // Connection test and feedback
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
			echo "<tr><th>Image Uploaded: </th><td><a href='observe_pix/" . $row["observePic"] . "'><img src='observe_pix/" . $row["observePic"] . "' width='300px' height='auto'></a></td></tr>";
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
			echo "<tr><th>Location: </th><td><div id='map'></div></td></tr>";
			echo "</tbody></table>";

			$latitude = $row["lat"];
			$longitude = $row["lng"];
			$observation = $row["observation"];
		}
		else // if no match, display error
		{
			echo "<script>console.log('No results.')</script>";
		}
	}

	// When attempt is complete, connection closes
    mysqli_close($connekt);
	
?>
			</div>
		</div>
	</div> <!-- /container -->

<!-- google map -->
<script>
	function initMap() {
		var myLatLng = {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>};  
		/*
		infoWindow = new google.maps.InfoWindow();
		*/
		
		var map = new google.maps.Map(document.getElementById('map'), {
			center: myLatLng,
			zoom: 15
		});
		
		var marker = new google.maps.Marker({
			map: map,
			position: myLatLng,
			title: 'Where I was'
		});
	}
</script>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDQS5VSppsf0VpNd8le9EexkJlIleZIQ04&callback=initMap' async defer></script>
<!-- /google map -->

<script src='//roxorsoxor.com/stakeout/mobrules.js'></script></body>
</html>