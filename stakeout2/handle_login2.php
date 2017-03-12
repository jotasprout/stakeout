<?php

	include_once '../../../php/landfill.php'; // connects to db

	$error = '';

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

		// query selects matching users in table
		$query = mysqli_query("SELECT * user_creds WHERE username = '$username' AND password = '$password'", $connekt);

		$result = mysqli_fetch_array($query);

		// if user is registered
		if ($result["username"]==$username && $result["password"]==$password) {
			$_SESSION['username'] = $username;
			header("location: index.php"); // redirects to welcome page dashboard thingy
		} else {
			$error = "Access Denied. Username and/or Password not accepted.";
			// Doesn't the error need to be echoed for this to matter?
		}

		mysqli_close($connekt); // slam that door												

?>