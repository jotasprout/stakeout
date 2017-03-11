<?php

	include_once '../../../php/landfill.php'; // connects to db

	session_start();

	$error = '';

	if (isset($_POST['submit'])) {
		
		if (empty($_POST['username']) || empty ($_POST['password'])) {
			$error = "Username and/or Password fields are required.";
		} 
		else 
		{
			// assign values from form to variables
			$username = $_POST['username'];
			$password = $_POST['password'];

			// prevent sql injection
			$username = stripslashes($username);
			$username = mysqli_real_escape_string($username);
			$password = stripslashes($password);
			$password = mysqli_real_escape_string($password);

			// select the database using landfill
			mysqli_select_db($connekt,"jscript_stakeout");

			// select matching users in table
			$query = mysqli_query("SELECT * user_creds WHERE username = '$username' AND password = '$password'", $connekt);
			$count = mysqli_num_rows($query); // checks to see how many rows match. Shouldn't this always be just one because of "unique" checks?

			// if user is registered
			if ($count == 1) {
				$_SESSION['username']=$username; // initializes session
				header("location: index.php"); // redirects to welcome page dashboard thingy
			} else {
				$error = "Access Denied. Username and/or Password not accepted.";
			}

			mysqli_close($connekt); // slam that door												
		}
	}
?>