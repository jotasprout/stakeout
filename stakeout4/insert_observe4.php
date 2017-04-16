<?php
	require_once 'areTheyLoggedIn4.php';
	$username = $_SESSION['username'];
	echo "<script>console.log('" . $username . "')</script>";
?>

<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
<title>Report Observation</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
<div class="container">
	<div class="masthead"> <a href="http://www.roxorsoxor.com/stakeout4/index4.php"> <img src="http://www.roxorsoxor.com/stakeout/stakeoutLogo.png" width="680" height="198"/> </a> </div>
	<!-- /masthead -->
	
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header"> <a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout4/index4.php">Home</a> </div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="http://www.roxorsoxor.com/stakeout4/cases4.php">Cases</a></li>
					<li><a href="http://www.roxorsoxor.com/stakeout4/observations4.php">Observations</a></li>
					<li><a href="http://www.roxorsoxor.com/stakeout4/gators4.php">Investigators</a></li>
					<li><a href="http://www.roxorsoxor.com/stakeout4/assignments4.php">Assignments</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="http://www.roxorsoxor.com">RoxorSoxor.com</a></li>
				</ul>
			</div>
			<!-- /collapse --> 
		</div>
		<!-- /container-fluid --> 
	</nav>
	<!-- /navbar --> 
	<div id="location"></div>
	<!-- This form uses code in handle_observe to insert input into the database -->
	<form class="form-horizontal" action="handle_observe4.php" method="post">
		<input type="hidden" name="username" value="<?php echo $username; ?>"/>
		<input type="hidden" name="txtlat" id="txtlat" required value="">
		<input type="hidden" name="txtlng" id="txtlng" required value="">
		<fieldset>
			<legend>Observation Upload</legend>
						
						<?php
						
							// PHP code in a more secure location
							include("../../../php/landfill.php");
						
							// connect to database
							$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
						
							// Connection test and feedback
							if (!$connekt) {
								die('Rats! Could not connect: ' . mysqli_error());
								echo "<script>console.log('Rats! Could not connect')</script>";
							}
						
							// Create variable for query	
							$query9 = "
							
							SELECT a.caseNum, c.caseName, c.status, a.username 
								FROM assignments a
									INNER JOIN cases c
										ON a.caseNum = c.caseNum
											WHERE a.username = '$username' AND c.status = 1";
						
							// Use variable with MySQL command to grab info from database
							$result9 = $connekt->query($query9);	
							
							// Create Case Menu
							echo "<div class='form-group'>";
								echo "<label class='col-lg-2 control-label' for='assignedCase'>Case</label>";
								echo "<div class='col-lg-4'>";
									echo "<select class='form-control' name='assignedCase'>";
										echo "<option value=''>- Choose -</option>";
										while ($row = mysqli_fetch_array($result9)) {
											echo "<script>console.log('" . $row['username'] . " is assigned " . $row['caseName'] . "')</script>";
											echo "<option value='" . $row['caseNum'] . "'>" . $row['caseName'] . "</option>";
										}
									echo "</select>";
								echo "</div>";
							echo "</div>";
						
							// Feedback of whether UPDATE worked or not
							if(!$result9){
								echo "<script>console.log('did not work')</script>";
							}						
						
							// When attempt is complete, connection closes
							mysqli_close($connekt);
						
						?>						
			
			<div class="form-group"> <!-- Row 3 -->
				<label class="col-lg-2 control-label" for="action">Action</label>
				<div class="col-lg-4">
					<select class="form-control" name="action">
						<option value="">- Choose -</option>
						<option value="pretextContact">Pretext Contact</option>
						<option value="socialMedia">Social Media</option>
						<option value="surveillance">Surveillance</option>
						<option value="trashPull">Trash Pull</option>
						<option value="undercover">Undercover</option>
					</select>
				</div>
			</div>
			<!-- /Row 3 -->
			
			<div class="form-group"> <!-- Row 4 --> 
				
				<!-- Column 1 -->
				
				<label class="col-lg-2 control-label" for="observation">Observation</label>
				
				<!-- Column 2 -->
				
				<div class="col-lg-4">
					<input class="form-control" type="text" name="observation" placeholder="Type your observation(s) here." />
					<div class="checkbox">
						<label>
							<input type="checkbox" name="pix" value="yes">
							Photos taken </label>
					</div>
				</div>
			</div>
			<!-- /Row 4 -->
			
			<div class="form-group"> <!-- Last Row -->
				
				<div class="col-lg-4 col-lg-offset-2">
					<button class="btn btn-primary" type="submit" name="submit">Upload</button>
				</div>
			</div>
			<!-- /Last Row -->
			
		</fieldset>
	</form>
	<footer class="footer">
		<p>&copy; RoxorSoxor 2017</p>
	</footer>
</div>
<!-- /container -->

<script src="geoloc.js"></script>

</body>
</html>