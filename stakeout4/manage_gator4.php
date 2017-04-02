<?php

	require_once 'areTheyLoggedIn4.php';
	require_once '../../../php/landfill.php';

  	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);

	if ($connekt->connect_error) die($connekt->connect_error);

	# if they are logged in, the following works like normal?
	function renderForm($id, $forename, $surname, $username, $password, $error)
	{
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Manage Investigator</title>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

	<div class="container">
            <div class="masthead">
                <a href="http://www.roxorsoxor.com/stakeout4/index4.php"><img src="http://www.roxorsoxor.com/stakeout/stakeoutLogo.png" width="680" height="198"/></a>      
            </div> <!-- /masthead -->

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout4/index4.php">Stakeout Home</a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    	<ul class="nav navbar-nav">
                            <li><a href="http://www.roxorsoxor.com/stakeout4/cases4.php">Cases</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout4/observations4.php">Observations</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout4/gators4.php">Investigators</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="http://www.roxorsoxor.com">RoxorSoxor.com</a></li>
                        </ul>
                    </div> <!-- /collapse -->                    

                </div> <!-- /container-fluid -->   
            </nav> <!-- /navbar -->

<?php 
 	// if there are any errors, display them
 	if ($error != '')
		{
		echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
		}
?> 

        <!-- This form uses code in handle_gator to insert input into the database -->

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
                </div><!-- /Row 1 -->    

                <div class="form-group"> <!-- Row 2 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="surname">Last Name</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="surname" value="<?php echo $surname; ?>" />
                    </div>
                </div><!-- /Row 2 -->     
                
                <div class="form-group"> <!-- Row 3 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="username">username</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="username" value="<?php echo $username; ?>" />
                    </div>
                </div><!-- /Row 3 -->    

                <div class="form-group"> <!-- Row 4 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="password">password</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="password" name="password" />
                    </div>
                </div><!-- /Row 4 -->                     		

                <div class="form-group"> <!-- Last Row -->           
                    <div class="col-lg-4 col-lg-offset-2">
                        <button class="btn btn-primary" type="submit" name="submit">Update Investigator</button>
                    </div>
                </div><!-- /Last Row -->            

            </fieldset>
        </form>

    <footer class="footer">
        <p>&copy; RoxorSoxor 2017</p>
    </footer>

</div> <!-- /container -->

</body>
</html>

<?php

	} // end of the renderForm function
	
	 
	// check if the form has been submitted. If it has, process the form and save it to the database
	if (isset($_POST['submit']))
		{ 
		
		// confirm that the 'id' value is a valid integer before getting the form data
		if (is_numeric($_POST['id']))
			{
				
			// get form data, making sure it is valid
			$id = $_POST['id'];
			$forename = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['forename']));
			$surname = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['surname']));
			$username = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['username']));
			$password = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['password']));	
	
			// check that forename and surname fields are both filled in
			if ($username == '')
				{
				// generate error message
				$error = 'ERROR: Boy, you sure are stupid! Fill in all required fields like you were told!';
	 
				//error, display form
				renderForm($id, $forename, $surname, $username, $password, $error);
				}
	
			else
				{
	
				// save data to database
				$updateUser = "UPDATE user_creds SET forename='$forename', surname='$surname', username='$username',password='$password' WHERE id='$id'";
				
				$retval = $connekt->query($updateUser);
	  
				// Feedback of whether INSERT worked or not
	 
				if(!$retval){
					die('Crap. Could not update this investigator: ' . mysqli_error());
				}
				else 
				{
				// after save, go to view page
				header("Location: gators4.php"); 
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
			$id = $_GET['id'];
			$result = mysqli_query($connekt, "SELECT * FROM user_creds WHERE id=$id")
			or die(mysqli_error($result)); 
			$row = mysqli_fetch_array($result);
	 
			// check that the 'id' matches up with a row in the databse
			if($row)
				{
	 
				// get data from db
				$id = $row['id'];
				$forename = $row['forename'];
				$surname = $row['surname'];
				$username = $row['username'];
				$password = $row['password'];			
	 
				// show form
				renderForm($id, $forename, $surname, $username, $password, '');
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