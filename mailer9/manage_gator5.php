<?php
	require_once 'areTheyLoggedIn5.php';
	require_once '../../../php/landfill.php';
	$username = $_SESSION['username'];
  	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	if ($connekt->connect_error) die($connekt->connect_error);
	# if they are logged in, the following works like normal?
	function renderForm($id, $forename, $surname, $username, $email, $error)
	{
?>
<!DOCTYPE html>
<html>
<head><meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
<title>Manage Investigator</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	
	
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header"> <a class="navbar-brand" href="http://www.roxorsoxor.com/mailer9/index_09.php">You</a> </div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="http://www.roxorsoxor.com/mailer9/cases5.php">Cases</a></li>
					<li><a href="http://www.roxorsoxor.com/mailer9/observations_09.php">Observations</a></li>
					<li><a href="http://www.roxorsoxor.com/mailer9/gators5.php">Investigators</a></li>
					<li><a href="http://www.roxorsoxor.com/mailer9/assignments5.php">Assignments</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="logout_stakeout5.php">Logout</a></li>
				</ul>
			</div>
			<!-- /collapse -->
		</div>
		<!-- /container-fluid -->
	</nav>
	<!-- /navbar -->
<?php
 	// if there are any errors, display them
 	if ($error != '')
		{
		echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
		}
?>
	<!-- This form displays user profile info from the database -->
	<form class="form-horizontal" action="" method="post">
		<input type="hidden" name="id" value="<?php echo $id; ?>"/>
		<fieldset>
			<legend>Manage Investigator</legend>
			<div class="form-group"> <!-- Row 1 -->
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="forename">First Name</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="text" name="forename" value="<?php echo $forename; ?>" />
				</div>
			</div>
			<!-- /Row 1 -->
			<div class="form-group"> <!-- Row 2 -->
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="surname">Last Name</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="text" name="surname" value="<?php echo $surname; ?>" />
				</div>
			</div>
			<!-- /Row 2 -->
			<div class="form-group"> <!-- Row 3 -->
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="username">username</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="text" name="username" value="<?php echo $username; ?>" />
				</div>
			</div>
			<!-- /Row 3 -->

			<div class="form-group"> <!-- Row 5 -->
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="email">eMail</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="email" name="email"  value="<?php echo $email; ?>" />
				</div>
			</div>
			<!-- /Row 5 -->
			<!-- Last Row -->
			<div class="form-group"> <!-- Last Row -->
				<div class="col-lg-4 col-lg-offset-2">
					<button class="btn btn-primary" type="submit" name="submit">Update Investigator</button>
				</div>
			</div>
			<!-- /Last Row -->
		</fieldset>
	</form>
<?php
	// PHP code in a more secure location
	include("../../../php/landfill.php");
	// Start creating an HTML table for Assigned Cases and create header row
    echo "<table class='table table-striped table-hover '><thead><tr><th>Assigned Cases</th></tr></thead>";
	echo "<tbody>";
	//Uses PHP code to connect to database
	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	// Connection test and feedback
	if (!$connekt) {
		die('Rats! Could not connect: ' . mysqli_error());
	}
	// Create variable for query
	$query0 = "
	SELECT a.caseID, c.caseName, c.status, a.username, b.id, b.forename, b.surname
		FROM assignments4 a
			INNER JOIN user_creds4 b
				ON a.username = b.username
			INNER JOIN cases4 c
				ON a.caseID = c.caseID
					WHERE b.id = $id AND c.status = 1";
	// Use variable with MySQL command to grab info from database
	$result0 = $connekt->query($query0);
	// Create a row in HTML table for each row from database
    while ($row = mysqli_fetch_array($result0)) {
		echo "<tr><td>" . $row['caseName'] . "</td></tr>";
    }
	// Finish table of Assigned Cases
    echo "</tbody></table>";
	// When attempt is complete, connection closes
    mysqli_close($connekt);
?>
	<footer class="footer">
		<p>&copy; RoxorSoxor 2017</p>
	</footer>
</div>
<!-- /container -->
</body>
</html>
<?php
	} // end of the renderForm function
	$salt1    = "qm&h*";
	$salt2    = "pg!@";
	// check if the form has been submitted.
	if (isset($_POST['submit'])){
		// If form is being submitted, process the form
		// confirm that the 'id' value is a valid integer before getting the form data
		if (is_numeric($_POST['id'])){
			// if id is valid integer
			// get form data, making sure it is valid
			$id = $_POST['id'];
			$forename = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['forename']));
			$surname = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['surname']));
			$username = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['username']));
			// $password = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['password']));
			// $pw_hashness = hash('ripemd128', "$salt1$password$salt2");
			$email = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['email']));
			// check that username field is filled in
			if ($username == '' || $email == ''){
				// if form is NOT filled in
				// generate error message
				$error = 'ERROR: Boy, you sure are stupid! Fill in all required fields like you were told!';
				// and display form
				renderForm($id, $forename, $surname, $username, $email, $error);
			}
			else // if form is filled in
			{
				// save data to database
				$updateUser = "UPDATE user_creds4 SET forename='$forename', surname='$surname', username='$username',email='$email' WHERE id='$id'";
				$retval = $connekt->query($updateUser);
				// Feedback of whether UPDATE worked or not
				if(!$retval){
					// if insert did NOT work
					die('Crap. Could not update this investigator: ' . mysqli_error());
				}
				else
				{
					// if update worked, go to list of investigators
					// do I want to change that to something AJAXy?
					header("Location: gators5.php");
				}
			}
		}
		else // if the 'id' isn't valid, display an error
		{
		echo $error;
		}
	}
	else // if the form isn't being submitted, get the data from the db and display the form
	{
		// confirm id is valid and is numeric/larger than 0)
		if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0){
			// query db
			$id = $_GET['id'];
			$result = mysqli_query($connekt, "SELECT * FROM user_creds4 WHERE id=$id")
			or die(mysqli_error($result));
			$row = mysqli_fetch_array($result);
			// check that the 'id' matches up with a row in the databse
			if($row){
	 			// if there's a match
				// get data from db
				$id = $row['id'];
				$forename = $row['forename'];
				$surname = $row['surname'];
				$username = $row['username'];
				// $password = $row['password'];
				$email = $row['email'];
				// show form
				renderForm($id, $forename, $surname, $username, $email, '');
			}
			else // if no match, display error
			{
				echo "No results!";
			}
		}
		else // if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
		{
			echo $error;
		}
	} // end of what to do if form isn't being submitted
?>